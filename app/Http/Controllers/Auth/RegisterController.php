<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Lime\LimeParticipants;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('olderThan', function($attribute, $value, $parameters)
        {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;

             return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'date_birth' => 'required|olderThan:15',
            'country' => 'integer',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $guid = LimeParticipants::gen_uuid();
        LimeParticipants::insert([
            'participant_id' => $guid,
            'firstname'=> $data['name'],
            'lastname' => $data['second_name'],
            'email' => $data['email'],
            'language' => null,
            'blacklisted' =>'N',
            'owner_uid' =>1,
            'created_by'=>1,
            'created' => Carbon::now(config('app.timezone')),
            'modified' =>null,

        ]);

        return User::create([
            'name' => $data['name'],
            'second_name' => $data['second_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'date_birth' => Carbon::parse($data['date_birth']),
            'country_id'=>$data['country'],
            'region_id'=>($data['region']!='undefined') ? $data['region'] : null,
            'city_id'=>($data['city']!='undefined') ? $data['city'] : null,
            'ls_password'=>($data['password']),
            'ls_participant_id'=>$guid,

        ]);
    }
    public function showRegistrationForm(){
        if(config('app.locale')=='ru'){
            $countries_list = Country::where(['lang_id'=>2])->orderBy('country_id')->limit(300)->get();

        }
        if(config('app.locale')=='ua'){
            $countries_list = Country::where(['lang_id'=>1])->orderBy('country_id')->limit(300)->get();

        }
    return view('auth.register')->with([
        'countries' => $countries_list,
    ]);
    }



}
