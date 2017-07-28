<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class AdminPagesController extends Controller
{
    public function index()
    {
        $pages = Pages::paginate(10);
        return view('admin.pages.index', with([
            'pages' => $pages
        ]));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $page_content = $request->get('page_content');
        $title = $request->get('title');

        if (!isset($title)){
            Toastr::error('Вы не указали заголовок страницы', 'Ошибка');
        }

        if (!isset($page_content)){
            Toastr::error('Вы не указали содержание страницы', 'Ошибка');
        }

        $page = new Pages();
        $page->title = $title;
        $page->page_content = $page_content;
        $page->save();

        Toastr::success('Страница успешно добавлена', 'Сохранено');
        return redirect()->route('admin.pages.index');
    }

    public function delete($id)
    {
        $page = Pages::find($id);

        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка');
            return back();
        }

        $page->delete();
        Toastr::success('Страница успешно удалена', 'Удалено');
        return back();
    }

    public function show($id)
    {
        $page = Pages::find($id);

        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка');
            return back();
        }

        return view('admin.pages.show', with([
            'page' => $page
        ]));
    }

    public function edit($id)
    {
        $page = Pages::find($id);

        if(!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка');
            return back();
        }

        return view('admin.pages.edit', with([
            'page' => $page
        ]));
    }

    public function update(Request $request)
    {
        $page_content = $request->get('page_content');
        $title = $request->get('title');
        $page_id = $request->get('page_id');

        if (!isset($title)){
            Toastr::error('Вы не указали заголовок страницы', 'Ошибка');
            return back();
        }

        if (!isset($page_content)){
            Toastr::error('Вы не указали содержание страницы', 'Ошибка');
            return back();
        }

        if (!isset($page_id)){
            Toastr::error('Вы не указали id страницы', 'Ошибка');
            return back();
        }

        $page = Pages::find($page_id);

        if (!isset($page)){
            Toastr::error('Данной страницы не существует!', 'Ошибка');
            return back();
        }

        $page->title = $title;
        $page->page_content = $page_content;
        $page->save();

        Toastr::success('Страница успешно изменена', 'Сохранено');
        return redirect()->route('admin.pages.index');
    }
}
