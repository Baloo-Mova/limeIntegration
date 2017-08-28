<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransactionLog;
use App\Models\PaymentsType;
use App\Models\Settings;
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
        return view('frontend.rewards.index', ['balancelogs' => Auth::user()->balancetransactionlog()->paginate(20)]);
    }

    public function balance()
    {
        $settings = Settings::find(1);
        if (!isset($settings)) {
            $min_sum = 500;
        }
        $paymentstypes = PaymentsType::all();
        $min_sum = $settings->min_sum;
        $balanceLogs = WithdrawBalance::where(['user_id' => Auth::user()->id])->paginate(20);
        return view('frontend.rewards.balance', ['min_sum' => $min_sum, 'paymentstypes' => $paymentstypes, 'balancelogs' => $balanceLogs]);
    }


    public function storeWithdraw(Request $request)
    {

        $settings = Settings::find(1);
        if (!isset($settings)) {
            $min_sum = 500;
        }

        $this->validate($request, [
            'destination' => 'required',
            'amount' => 'required|integer|min:' . $settings->min_sum . '|max:' . Auth::user()->balance,
            'paymentstype' => 'required|integer'
        ],
            [
                'required' => __('messages.form_required'),
                'amount.min' => __('messages.form_amount_min').' :min',
                'amount.max' => __('messages.form_amount_max').' :max'
            ]);

        WithdrawBalance::create([
            'user_id' => Auth::user()->id,
            'decription' => null,
            'amount' => $request["amount"],
            'payment_type_id' => $request["paymentstype"],
            'destination' => $request["destination"],
            'currency_id' => 0,

        ]);

        return back();

    }


}
