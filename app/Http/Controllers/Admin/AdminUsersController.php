<?php

namespace App\Http\Controllers\Admin;

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

class AdminUsersController extends Controller
{
    //


    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
$user = User::first();


        $users = User::where(['role_id'=>1])->orderBy('id')->paginate(20);
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
        $paymentstype = PaymentsType::whereId($id)->first();
        if (!isset($paymentstype)) {

            return redirect(rounte('admin.paymentstypes.index'));
        }
          return view('admin.paymentstypes.edit')->with(['paymentstype'=>$paymentstype,]);
    }

    public function update(UpdateRequest $request, $id)
    {
        PaymentsType::whereId($id)->update([
            'title'=>$request["title"],
            'weight_global'=>$request["weight_global"]
        ]);


        return redirect(route('admin.paymentstypes.index'));
    }

    public function show($id)
    {
        $paymentstype=PaymentsType::whereId($id)->first();
        if(!isset($paymentstype))return redirect('admin.paymentstype.index');

          return view('admin.paymentstypes.show')->with([
              'paymentstype' =>$paymentstype,
          ]);

    }

    public function delete($id)
    {
        try {
            PaymentsType::whereId($id)->delete();
        }catch(\Exception $ex){
            return redirect('admin.paymentstype.index');
        }


        return back()->with(['message' => 'deleted']);
    }
}
