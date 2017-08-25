<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helpers\Macros;
use Illuminate\Support\Facades\DB;
use App\Notifications\SendMessage;

class SendBaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $guid;
    protected $send_all;
    protected $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($guid, $send_all, $text)
    {
        $this->guid = $guid;
        $this->send_all = $send_all;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $text = Macros::convertMacro($this->text);

        if($this->send_all){
            $users = User::all();
            if(!isset($users)) {
                return false;
            }
            foreach ($users as $user){
                if($user->role_id == 2){
                    continue;
                }
                $user->notify(new SendMessage($text));
            }
        }else{
            $users = DB::table('search_cache_' .$this->guid)->get();
            if(!isset($users)){
                return false;
            }
            $users = collect($users)->map(function ($x) {
                return (array)$x;
            })->toArray();

            if(!isset($users)){
                return false;
            }

            $u = User::whereIn('ls_participant_id', array_column($users, 'participant_id'))->get();

            if(!isset($u)){
                return false;
            }

            foreach ($u as $user){
                $user->notify(new SendMessage($text));
            }
        }

    }
}
