<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PaymentsType;
use Carbon\Carbon;
use App\Http\Requests\PaymentsType\UpdateRequest;
class AdminTransactionController extends Controller
{
    //


    public function index()
    {

        $payments_types = PaymentsType::orderBy('weight_global', 'id')->paginate(20);

        return view('admin.paymentstypes.index')->with([

            'paymentstypes' => $payments_types,


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
