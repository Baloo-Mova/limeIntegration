<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\Users\UpdateRequest;
use App\User;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Lime\LimeParticipants;
use Illuminate\Support\Facades\Session;
class AdminUsersController extends Controller
{
    //


    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {

        $users = User::where(['role_id'=>1])->orWhere(['role_id'=>3])->orderBy('id')->paginate(20);

        if(Lang::getLocale()=="ru"){
            $countries = Country::where(['lang_id'=>2])->get();
        }

        if(Lang::getLocale()=="uk"){
            $countries = Country::where(['lang_id'=>1])->get();
        }

        return view('admin.users.index')->with([
            'users' => $users,
            'countries' =>$countries,

        ]);
    }

    public function create()
    {

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'date_birth' => 'required|date',
            'country' => 'integer',
        ]);


        return User::create([
            'name' => $request['name'],
            'second_name' => $request['second_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'date_birth' => Carbon::parse($request['date_birth']),
            'country_id'=>$request['country'],
            'region_id'=>1,
            'city_id'=>1,
        ]);
        return redirect()->back();
    }

    public function edit($id)
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
        $user = User::whereId($id)->first();

        if (!isset($user)) {

            return redirect(rounte('admin.users.index'));
        }
        $countries = Country::where(['lang_id'=> $lang_id])->orderBy('country_id')->limit(300)->get();
        $regions = Region::where(['country_id'=>$user->country_id])->get();
        $cities = City::where(['country_id'=>$user->country_id, 'region_id'=>$user->region_id ])->get();
        $roles= Role::get();
          return view('admin.users.edit')->with([
              'user'=>$user,
              'countries'=>$countries,
              'regions' => $regions,
              'cities' => $cities,
              'roles' =>$roles,
          ]);
    }

    public function update(Request $request, $id)
    {
        $user=User::whereId($id)->first();
        $user->participant->setPrimKey('participant_id');
        $user->participant->firstname= $request['name'];
        $user->participant->lastname = $request['second_name'];
        $user->participant->email = $request['email'];

        $user->participant->modified =Carbon::now(config('app.timezone'));

        $user->participant->save();



        $user->role_id=($request['role']!='null') ? $request['role'] : $user->role_id;
        $user->name = $request['name'];
        $user->second_name = $request['second_name'];
        $user->email = $request['email'];
        $user->balance = $request['balance'];
        $user->rating = $request['rating'];

        $user->date_birth = Carbon::parse($request['date_birth']);
        $user->country_id=$request['country'];
        $user->region_id=($request['region']!='undefined') ? $request['region'] : null;
        $user->region_id=($request['region']!='undefined') ? $request['region'] : null;
        $user->city_id=($request['city']!='undefined') ? $request['city'] : null;
        $user->save();





        return redirect(route('admin.users.index'));
    }

    public function show($id)
    {
        $user=User::whereId($id)->first();
        if(!isset($user))return redirect('admin.users.index');

          return view('admin.users.show')->with([
              'user' =>$user,
          ]);

    }

    public function showByPid($pid)
    {
        $user=User::where(['ls_participant_id' => $pid])->first();
        if(!isset($user))return redirect('admin.users.index');

        return redirect(route('admin.users.show', ['user' => $user->id]));

    }

    public function delete($id)
    {
        try {
            User::whereId($id)->delete();
        }catch(\Exception $ex){
            return redirect('admin.paymentstype.index');
        }


        return back()->with(['message' => 'deleted']);
    }
}
