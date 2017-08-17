<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class PagesController extends Controller
{
    public function pageView(Request $request)
    {
        $page = Pages::where(['name' => $request->pageName])->first();
        if (!isset($page)) {
            abort(404);
        }

        return view('frontend.pages.index', ['page' => $page]);
    }
}
