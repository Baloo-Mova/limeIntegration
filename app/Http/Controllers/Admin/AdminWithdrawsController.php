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
class AdminWithdrawsController extends Controller
{
    //


    public function index()
    {

        $withdraws = WithdrawBalance::orderBy('status','asc')->orderBy('created_at','desc')->paginate(20);

        return view('admin.withdraws.index')->with([

            'withdraws' => $withdraws,


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
}
