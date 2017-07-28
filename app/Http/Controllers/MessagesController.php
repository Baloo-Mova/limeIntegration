<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\Notifications;
use Carbon\Carbon;

class MessagesController extends Controller
{
    public function index()
    {
        return view('frontend.messages.index', with([
            'messages' => \Auth::user()->notifications
        ]));
    }

    public function show($mid)
    {
        $message = Notifications::where(['id' => $mid])->first();
        if(!isset($message)){
            return back();
        }

        $text = json_decode($message->data);

        if($message->read_at == null){
            $message->read_at = Carbon::now();
            $message->save();
        }

        return view('frontend.messages.show', with([
            'message' => $message,
            'text'    => $text->data->message
        ]));
    }
}
