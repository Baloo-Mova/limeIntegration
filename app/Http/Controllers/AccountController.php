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

    public function addParticipant()
    {
        return view('frontend.account.addParticipant');
    }

    public function saveParticipant(Request $request)
    {
        $survey_id = $request->get('survey');

        if(!isset($survey_id)){
            return back();
        }

        $user = Auth::user();

        $lime_base = DB::connection('mysql_lime');
        $schemaConnAdmin = Schema::connection('mysql_lime');

        if(!$schemaConnAdmin->hasTable('tokens_'.$survey_id)){
            $schemaConnAdmin->create('tokens_'.$survey_id, function (Blueprint $table) {
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

        $participant = $lime_base->table('tokens_'.$survey_id)->where(['participant_id' => $user->ls_participant_id])->first();

        if(isset($participant)){
            return back();
        }

        $t = $lime_base->table('tokens_'.$survey_id)->insertGetId([
            'participant_id' => $user->ls_participant_id,
            'firstname' => $user->name,
            'lastname' => $user->second_name,
            'email'    => $user->email,
            'token'    => $this->gen_uuid(),
            'emailstatus' => 'OK'
        ]);

        $lime_base->table('survey_links')->insert([
            'participant_id' => $user->ls_participant_id,
            'token_id'       => $t,
            'survey_id'      => $survey_id,
            'date_created'   => Carbon::now()->toDateTimeString()
        ]);

        return back();

    }

    static function gen_uuid()
    {
        return sprintf(
            '%04x%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000
        );
    }
}
