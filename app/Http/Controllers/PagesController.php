<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class PagesController extends Controller
{
    public function aboutUs()
    {
        $page = Pages::where(['name' => 'aboutUs'])->first();
        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка!');
            return back();
        }
        return view('frontend.pages.index', ['page' => $page]);
    }

    public function faq()
    {
        $page = Pages::where(['name' => 'faq'])->first();
        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка!');
            return back();
        }
        return view('frontend.pages.index', ['page' => $page]);
    }

    public function confidentiality()
    {
        $page = Pages::where(['name' => 'confidentiality'])->first();
        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка!');
            return back();
        }
        return view('frontend.pages.index', ['page' => $page]);
    }

    public function terms()
    {
        $page = Pages::where(['name' => 'terms'])->first();
        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка!');
            return back();
        }
        return view('frontend.pages.index', ['page' => $page]);
    }

    public function feedback()
    {
        $page = Pages::where(['name' => 'feedback'])->first();
        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка!');
            return back();
        }
        return view('frontend.pages.index', ['page' => $page]);
    }
}
