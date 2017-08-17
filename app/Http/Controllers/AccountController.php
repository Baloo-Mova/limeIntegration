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
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

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
                $lang_id = 1;
                break;
            case "ru":
                $lang_id = 2;
                break;
            case "en":
                $lang_id = 3;
                break;
        }


        $countries = Country::orderBy('country_id')->limit(300)->get();
        $regions = Region::where(['country_id' => Auth::user()->country_id])->get();
        $cities = City::where(['country_id' => Auth::user()->country_id, 'region_id' => Auth::user()->region_id])->get();

        return view('frontend.account.edit')->with([
            'user' => Auth::user(),
            'countries' => $countries,
            'regions' => $regions,
            'cities' => $cities,
        ]);
    }

    public function update(Request $request)
    {
        Validator::extend('olderThan', function ($attribute, $value, $parameters) {
            $minAge = (!empty($parameters)) ? (int)$parameters[0] : 13;

            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'gender' => 'required',
            'email' => 'required|string|email|max:255',
            'date_birth' => 'required|olderThan:15',
            'country' => 'integer',
        ], [
            'country.integer' => __('validation.city')
        ]);

        $user = Auth::user();

        if (isset($user->participant)) {
            $user->participant->setPrimKey('participant_id');
            $user->participant->firstname = $request['name'];
            $user->participant->lastname = $request['second_name'];
            $user->participant->email = $request['email'];
            $user->participant->modified = Carbon::now(config('app.timezone'));
            $user->participant->save();
        }
        $user->name = $request['name'];
        $user->second_name = $request['second_name'];
        $user->gender = $request['gender'];
        $user->email = $request['email'];

        $user->date_birth = Carbon::parse($request['date_birth']);
        $user->country_id = $request['country'];
        $user->region_id = ($request['region'] != 'undefined') ? $request['region'] : null;
        $user->city_id = ($request['city'] != 'undefined') ? $request['city'] : null;
        $user->save();

        return redirect(route('account.edit'));
    }


    public function delete($id)
    {
        try {
            User::whereId($id)->delete();
        } catch (\Exception $ex) {
            return redirect('site.index');
        }


        return back()->with(['message' => 'deleted']);
    }
}
