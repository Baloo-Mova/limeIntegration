<?php

namespace App\Http\Controllers\Admin;

use App\Models\BalanceTransactionLog;
use App\Models\WithdrawBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\PaymentsType\UpdateRequest;
use Illuminate\Support\Facades\DB;

class AdminWithdrawsController extends Controller
{
    //


    public function index($column = 'created_at', $direction = 'desc')
    {

        $withdraws = WithdrawBalance::orderBy($column,$direction)->paginate(10);

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
        $withdraws = DB::table('withdraw_balances')
            ->join('users', 'withdraw_balances.user_id', '=', 'users.id')
            ->select('users.email', 'withdraw_balances.*')
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
