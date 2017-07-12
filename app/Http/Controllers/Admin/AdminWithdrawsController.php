<?php

namespace App\Http\Controllers\Admin;

use App\Models\WithdrawBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\PaymentsType\UpdateRequest;
class AdminWithdrawsController extends Controller
{
    //


    public function index()
    {

        $withdraws = WithdrawBalance::orderBy('status','asc')->orderBy('created_at','desc')->paginate(20);

        return view('admin.withdraws.index')->with([

            'withdraws' => $withdraws,


        ]);
    }

    public function create()
    {

        return view('admin.paymentstypes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'weight_global' => 'required',
        ]);


        PaymentsType::insert([
            'title' => $request["title"],
            'weight_global' => (($request["weight_global"] != null) ? $request["weight_global"] : 0),
            'created_at' => Carbon::now(config('app.timezone')),

        ]);
        return redirect()->back();
    }


    public function updateStatus(Request $request)
    {
        $description = ($request->input('description'));
//dd($request->input('withdraw_id'));
        WithdrawBalance::whereId($request["withdraw_id"])->update([
            'status'=>$request["status"],
            'description' => isset($description) ? $description : null,
        ]);


        return redirect(route('admin.withdraws.index'));
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
            WithdrawBalance::whereId($id)->delete();
        }catch(\Exception $ex){
            return redirect('admin.withdraws.index');
        }


        return back()->with(['message' => 'deleted']);
    }
}
