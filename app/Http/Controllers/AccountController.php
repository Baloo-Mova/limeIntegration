<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;

use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\Users\UpdateRequest;
use App\User;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Lime\LimeParticipants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AccountController extends Controller
{
    //


    /**
     * @param Request $request
     * @return $this
     */


    public function edit()
    {

        switch (Lang::getLocale()) {
            case "ua":
                $lang_id=1;
                break;
            case "ru":
                $lang_id=2;
                break;
            case "en":
                $lang_id=3;
                break;
        }



        $countries = Country::where(['lang_id'=> $lang_id])->orderBy('country_id')->limit(300)->get();
        $regions = Region::where(['country_id'=>Auth::user()->country_id])->get();
        $cities = City::where(['country_id'=>Auth::user()->country_id, 'region_id'=>Auth::user()->region_id ])->get();

          return view('frontend.account.edit')->with([
              'user'=>Auth::user(),
              'countries'=>$countries,
              'regions' => $regions,
              'cities' => $cities,
          ]);
    }

    public function update(Request $request)
    {
        Auth::user()->participant->setPrimKey('participant_id');
        Auth::user()->participant->firstname= $request['name'];
        Auth::user()->participant->lastname = $request['second_name'];
        Auth::user()->participant->email = $request['email'];

        Auth::user()->participant->modified =Carbon::now(config('app.timezone'));

        Auth::user()->participant->save();




        Auth::user()->name = $request['name'];
        Auth::user()->second_name = $request['second_name'];
        Auth::user()->email = $request['email'];

        Auth::user()->date_birth = Carbon::parse($request['date_birth']);
        Auth::user()->country_id=$request['country'];
        Auth::user()->region_id=($request['region']!='undefined') ? $request['region'] : null;
        Auth::user()->city_id=($request['city']!='undefined') ? $request['city'] : null;

        Auth::user()->save();





        return redirect(route('account.edit'));
    }



    public function delete($id)
    {
        try {
            User::whereId($id)->delete();
        }catch(\Exception $ex){
            return redirect('site.index');
        }


        return back()->with(['message' => 'deleted']);
    }
}
