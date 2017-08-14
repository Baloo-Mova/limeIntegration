<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveys;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            'gender' => 'required',
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
        $lime_base = DB::connection('mysql_lime');
        $schemaConnAdmin = Schema::connection('mysql_lime');

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

        $surveys = LimeSurveys::where(['type_id' => 0])->get();
        if(isset($surveys)){

            $res = [];

            foreach ($surveys as $survey){
                if(!$schemaConnAdmin->hasTable('tokens_'.$survey->sid)){
                    $schemaConnAdmin->create('tokens_'.$survey->sid, function (Blueprint $table) {
                        $table->increments('tid');
                        $table->string('participant_id', 50)->nullable();
                        $table->string('firstname', 150)->nullable();
                        $table->string('lastname', 150)->nullable();
                        $table->text('email')->nullable()->nullable();
                        $table->text('emailstatus')->nullable();
                        $table->string('token', 35)->nullable();
                        $table->string('language', 25)->nullable();
                        $table->string('blacklisted', 17)->nullable();
                        $table->string('sent', 17)->default('N');
                        $table->string('remindersent', 17)->default('N');
                        $table->integer('remindercount')->default(0);
                        $table->string('completed', 17)->default('N');
                        $table->integer('usesleft')->default(1);
                        $table->datetime('validfrom')->nullable();
                        $table->datetime('validuntil')->nullable();
                        $table->integer('mpid')->nullable();
                    });
                }

                $t = $lime_base->table('tokens_'.$survey->sid)->insertGetId([
                    'participant_id' => $guid,
                    'firstname' => $data['name'],
                    'lastname' => $data['second_name'],
                    'email'    => $data['email'],
                    'token'    => $this->gen_uuid(),
                    'emailstatus' => 'OK'
                ]);
                $res[] = [
                    'participant_id' => $guid,
                    'token_id'       => $t,
                    'survey_id'      => $survey->sid,
                    'date_created'   => Carbon::now()->toDateTimeString()
                ];
            }
            $lime_base->table('survey_links')->insert($res);

        }

        return User::create([
            'name' => $data['name'],
            'second_name' => $data['second_name'],
            'gender' => $data['gender'],
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

    protected function gen_uuid()
    {
        return sprintf(
            '%04x%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000
        );
    }

    public function showRegistrationForm(){
        if(config('app.locale')=='ru'){
            $countries_list = Country::where(['lang_id'=>2])->orderBy('title', 'asc')->limit(300)->get();

        }
        if(config('app.locale')=='ua'){
            $countries_list = Country::where(['lang_id'=>1])->orderBy('title', 'asc')->limit(300)->get();

        }
    return view('auth.register')->with([
        'countries' => $countries_list,
    ]);
    }



}
