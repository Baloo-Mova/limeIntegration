<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lime\LimeParticipants;
use App\Models\Lime\LimeSurveys;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function redirectFaceBook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFaceBook()
    {
        $providerUser = Socialite::driver('facebook')->user();
        if (isset($providerUser)) {
            $user = User::where('email', '=', $providerUser->email)->first();
            if (isset($user) && $user->facebook == $providerUser->id) {
                Auth::login($user);
                return redirect(route('site.index'));
            }

            if (isset($user) && $user->facebook != $providerUser->id) {
                return redirect('/login')->withErrors(['alreadyExist' => __('auth.alreadyExist', ['email' => $user->email])]);
            }

            if (!isset($user)) {
                $guid = LimeParticipants::gen_uuid();
                $lime_base = DB::connection('mysql_lime');
                $schemaConnAdmin = Schema::connection('mysql_lime');
                $tmp = explode(" ", $providerUser->name);
                LimeParticipants::insert([
                    'participant_id' => $guid,
                    'firstname' => isset($tmp[0]) ? $tmp[0] : "",
                    'lastname' => isset($tmp[1]) ? $tmp[1] : "",
                    'email' => $providerUser->email,
                    'language' => null,
                    'blacklisted' => 'N',
                    'owner_uid' => 1,
                    'created_by' => 1,
                    'created' => Carbon::now(config('app.timezone')),
                    'modified' => null,
                ]);

                $surveys = LimeSurveys::where(['type_id' => 0])->get();
                if (isset($surveys)) {
                    $res = [];
                    foreach ($surveys as $survey) {
                        if (!$schemaConnAdmin->hasTable('tokens_' . $survey->sid)) {
                            $schemaConnAdmin->create('tokens_' . $survey->sid, function (Blueprint $table) {
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

                        $t = $lime_base->table('tokens_' . $survey->sid)->insertGetId([
                            'participant_id' => $guid,
                            'firstname' => isset($tmp[0]) ? $tmp[0] : "",
                            'lastname' => isset($tmp[1]) ? $tmp[1] : "",
                            'email' => $providerUser->email,
                            'token' => $this->gen_uuid(),
                            'emailstatus' => 'OK'
                        ]);

                        $res[] = [
                            'participant_id' => $guid,
                            'token_id' => $t,
                            'survey_id' => $survey->sid,
                            'date_created' => Carbon::now()->toDateTimeString()
                        ];
                    }
                    $lime_base->table('survey_links')->insert($res);
                }
                $password = bcrypt(uniqid());
                $user = new User();
                $user->email = $providerUser->email;
                $user->password = $password;
                $user->name = isset($tmp[0]) ? $tmp[0] : "";
                $user->second_name = isset($tmp[1]) ? $tmp[1] : "";
                $user->gender = $providerUser->user['gender'] == "male" ? 0 : 1;
                $user->ls_password = $password;
                $user->ls_participant_id = $guid;
                $user->facebook = $providerUser->id;
                $user->verified = 1;
                $user->token = null;
                $user->save();
            }

            Auth::login($user);
            return redirect(route('site.index'));
        }

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
}

