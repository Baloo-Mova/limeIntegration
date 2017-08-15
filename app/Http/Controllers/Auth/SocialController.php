<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
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
            if(isset($user) && $user->facebook == $providerUser->id){
                Auth::login($user);
                redirect(route('site.index'));
            }

            if(isset($user) && $user->facebook != $providerUser->id){
                redirect('/register')->withErrors('alreadyExist');
            }

            if (!isset($user)) {
                $user = new User();
                $user->email = $providerUser->email;
                $user->password = bcrypt(uniqid());
                $tmp = explode("  ", $providerUser->name);
                $user->name = isset($tmp[0]) ? $tmp[0] : "";
                $user->second_name = isset($tmp[1]) ? $tmp[1] : "";
                $user->gender = $providerUser->user['gender'] == "male" ? 0 : 1;
                $user->save();
            }

            Auth::login($user);
            redirect(route('site.index'));
        }
    }
}