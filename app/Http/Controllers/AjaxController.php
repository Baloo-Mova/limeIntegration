<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
use Illuminate\Support\Facades\DB;
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
        //  return json_encode([



        // ]);
        //}

    }
}
