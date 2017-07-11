<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransactionLog;
use App\Models\Lime\LimeSurveys;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller
{
    //
    public function getRegionsInfo($countryid){


            $regions = DB::table('regions')->select('region_id','title')->where('country_id', '=', $countryid)->get();
            return Response::json( $regions );


    }
    public function getCitiesInfo($countryid,Request $request){

        $req_arr =[];
        if(isset($request["region_id"])){
           $req_arr ['region_id'] = $request["region_id"];
        }

        $req_arr  ['country_id'] =$countryid;

        $cities = DB::table('cities')->select('city_id','title','area')->where($req_arr)->get();
        return Response::json( $cities );


    }
    public function updatebalance($id,Request $request){

       if(Auth::user()!=null){

           if(Auth::user()->participant->checkCompleteSurvey($id)){
            $balance_transacrion= Auth::user()->balancetransactionlog()->where(['ls_surveys_id'=>$id])->first();

            if(!isset($balance_transacrion)){
                $limesurvey= LimeSurveys::where(['sid'=>$id])->first();
                $text = $limesurvey->type_id==0 ? Lang::get('messages.CompleteProfilesBalanceLog'):Lang::get('messages.CompleteSurveysBalanceLog');

                if(isset($limesurvey)) {
                    Auth::user()->increment('balance',$limesurvey->reward);

                    BalanceTransactionLog::create([


                            'to_user_id' =>Auth::user()->id,
                            'from_user_id'=> 0,
                            'description' => $text,
                            'balance_operation'=>$limesurvey->reward,
                            'status'=> 1,
                            'payment_type_id'=>0,
                            'ls_surveys_id'=>$id,

                    ]);



                }
            }
           }


       }
        return redirect(route('site.index'));
    }
}
