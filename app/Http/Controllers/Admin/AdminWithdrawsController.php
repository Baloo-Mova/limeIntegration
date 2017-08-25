<?php

namespace App\Http\Controllers\Admin;

use App\Models\BalanceTransactionLog;
use App\Models\WithdrawBalance;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\PaymentsType\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\User;

class AdminWithdrawsController extends Controller
{
    //


    public function index($column = 'created_at', $direction = 'desc')
    {
        $withdraws = DB::table('withdraw_balances')
            ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
            ->join('payments_types', 'withdraw_balances.payment_type_id', '=', 'payments_types.id')
            ->select('users.name', 'users.second_name', 'withdraw_balances.*', 'payments_types.title')
            ->orderBy($column, $direction)
            ->paginate(10);

        return view('admin.withdraws.index')->with([
            'withdraws' => $withdraws,
            'column' => $column,
            'direction' => $direction
        ]);
    }



    public function updateStatus(Request $request)
    {
        $description = ($request->input('description'));
//dd($request->input('withdraw_id'));
        $withdrawbalance = WithdrawBalance::whereId($request["withdraw_id"])->first();

        $withdrawbalance->status = $request["status"];
        $withdrawbalance->description  = isset($description) ? $description : null;
        $withdrawbalance->save();


        switch ($request["status"]) {
            case '1':
                BalanceTransactionLog::create([
                        'to_user_id' =>$withdrawbalance->user->id,
                        'from_user_id'=> Auth::user()->id,
                        'description' => "Вывод средств",
                        'balance_operation'=>-1*($withdrawbalance->amount),
                        'status'=> 1,
                        'payment_type_id'=>$withdrawbalance->payment_type_id,
                        'ls_surveys_id'=>0,

                    ]);
                $withdrawbalance->user->decrement('balance',$withdrawbalance->amount);
                break;
            case '2':

                break;

        }

        return redirect(route('admin.withdraws.index'));
    }

    public function delete($id)
    {
        try {
            WithdrawBalance::whereId($id)->delete();
        }catch(\Exception $ex){
            return redirect('admin.withdraws.index');
        }


        return back()->with(['message' => 'deleted']);
    }

    public function export()
    {
        return view('admin.withdraws.export');
    }

    public function getUsers(Request $request)
    {
        $users = User::select(['id', 'name', 'second_name'])
            ->where('name', 'like', '%' . $request->email['term'] . '%')
            ->orWhere('second_name', 'like', '%' . $request->email['term'] . '%')
            ->offset($request->page == null ? 0 : $request->page * 10)
            ->limit(10)
            ->get();
        $response = [];
        foreach ($users as $item) {
            $response[] = [
                'id' => $item->id,
                'text' => $item->name." ".$item->second_name
            ];
        }

        return response()->json($response);
    }

    public function exportCsv(Request $request)
    {
        $user = $request->get('user');
        $date = $request->get('date');
        $send_all = $request->get('send_all');

        if(!isset($user) && !isset($date) && !isset($send_all)){
            Toastr::error("Не указаны обязательные параметры", "Ошибка");
            return back();
        }

        if (isset($date)) {
            $find = stripos($date, ' -');
            $date_from = substr($date, 0, $find);
            $date_from = Carbon::createFromFormat('m-d-Y', $date_from)->toDateTimeString();
            $date_to = substr($date, $find + 3);
            $date_to = Carbon::createFromFormat('m-d-Y', $date_to)->toDateTimeString();
        }

        if(isset($send_all) && $send_all == "on"){
            $withdraws = DB::table('withdraw_balances')
                ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
                ->join('payments_types', 'withdraw_balances.payment_type_id', '=', 'payments_types.id')
                ->select('users.name', 'users.second_name', 'users.email', 'withdraw_balances.*', 'payments_types.title')
                ->get();
        }elseif(isset($date) && !isset($user)){
            $withdraws = DB::table('withdraw_balances')
                ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
                ->join('payments_types', 'withdraw_balances.payment_type_id', '=', 'payments_types.id')
                ->select('users.name', 'users.second_name', 'users.email', 'withdraw_balances.*', 'payments_types.title')
                ->whereBetween('withdraw_balances.created_at', [$date_from, $date_to])
                ->get();
        }elseif(!isset($date) && isset($user)){
            $withdraws = DB::table('withdraw_balances')
                ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
                ->join('payments_types', 'withdraw_balances.payment_type_id', '=', 'payments_types.id')
                ->select('users.name', 'users.second_name', 'users.email', 'withdraw_balances.*', 'payments_types.title')
                ->get();
        }elseif(isset($date) && isset($user)){
            $withdraws = DB::table('withdraw_balances')
                ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
                ->join('payments_types', 'withdraw_balances.payment_type_id', '=', 'payments_types.id')
                ->select('users.id', 'users.name', 'users.second_name', 'users.email', 'withdraw_balances.*', 'payments_types.title')
                ->where('users.id', $user)
                ->whereBetween('withdraw_balances.created_at', [$date_from, $date_to])
                ->get();
        }

        $result = [];
        $dt = microtime();

        if(!file_exists(storage_path('app/csv/'))){
            mkdir(storage_path('app/csv/'));
        }
        $file = fopen(storage_path('app/csv/')."export_withdraw" . $dt . ".csv", 'w');
        fputcsv($file, [
            'user_id',
            'user_email',
            'description',
            'amount',
            'status',
            'date'
        ], ";");
        foreach ($withdraws as $w){
            fputcsv($file, [
                $w->user_id,
                $this->icv($w->email),
                $this->icv($w->description),
                $this->icv($w->amount),
                $w->status == 0 ? $this->icv("не выплачено") : $this->icv("выплачено"),
                $w->created_at
            ], ";");
        }
        fclose($file);

        return response()->download(storage_path('app/csv/').'export_withdraw' . $dt . '.csv');
    }

    public function exportFunction($column, $direction)
    {
        $withdraws = DB::table('withdraw_balances')
            ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
            ->join('payments_types', 'withdraw_balances.payment_type_id', '=', 'payments_types.id')
            ->select('users.name', 'users.second_name', 'users.email', 'withdraw_balances.*', 'payments_types.title')
            ->orderBy($column, $direction)
        ->get();

        $result = [];
        $dt = microtime();

        if(!file_exists(storage_path('app/csv/'))){
            mkdir(storage_path('app/csv/'));
        }
        $file = fopen(storage_path('app/csv/')."export" . $dt . ".csv", 'w');
        fputcsv($file, [
            'user_id',
            'user_email',
            'description',
            'amount',
            'status',
            'date'
        ], ";");
        foreach ($withdraws as $w){
            fputcsv($file, [
                $w->user_id,
                $this->icv($w->email),
                $this->icv($w->description),
                $this->icv($w->amount),
                $w->status == 0 ? $this->icv("не выплачено") : $this->icv("выплачено"),
                $w->created_at
            ], ";");
        }
        fclose($file);

        return response()->download(storage_path('app/csv/').'export' . $dt . '.csv');
    }

    private function icv($str)
    {
        $res = "=\"" . iconv("UTF-8", "Windows-1251//IGNORE", $str) . "\"";
        return $res;
    }
}
