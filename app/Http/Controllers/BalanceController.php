<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransactionLog;
use App\Models\PaymentsType;
use App\Models\WithdrawBalance;
use Illuminate\Http\Request;


use App\User;
use App\Models\Lime\User as LimeUser;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Lime\LimeSurveys;
use App\Models\Lime\LimeSurveysLanguageSettings;
use Carbon\Carbon;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use org\jsonrpcphp\JsonRPCClient;


class BalanceController extends Controller
{
    public $client;

    //
    public function index()
    {
        $balanceLogs = Auth::user()->balancetransactionlog()->paginate(20);
        return view('frontend.rewards.index')->with(
            [
                'balancelogs' => $balanceLogs
            ]
        );
    }

    public function balance()
    {
        return view('frontend.rewards.balance');
    }

    public function indexwithdraw()
    {
        $withdraws = Auth::user()->withdrawbalance()->paginate(20);
        $paymentstypes = PaymentsType::get();
        return view('frontend.withdraws.index')->with(
            [
                'withdraws' => $withdraws,
                'paymentstypes' => $paymentstypes,

            ]
        );
    }

    public function storeWithdraw(Request $request)
    {

        if (isset($request["destination"]) && isset($request["amount"])) {
        WithdrawBalance::create([
            'user_id' =>Auth::user()->id,
            'decription' =>null,
            'amount' =>$request["amount"],
            'payment_type_id' =>$request["paymentstype"],
            'destination' =>$request["destination"],
            'currency_id' =>0,

        ]);

        }
        return redirect(route('withdraws.index'));

    }


}
