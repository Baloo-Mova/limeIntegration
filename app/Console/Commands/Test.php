<?php

namespace App\Console\Commands;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\Cities;
use App\Models\Regions;
use GuzzleHttp\Client;
use App\Shop;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countries = Country::where('lang_id', '<>', 'ru')->get();

        $res = [];
        foreach ($countries as $c){
            $co = Country::where(['title' => $c->title, 'lang_id' => 'ru'])->first();
            $region = Region::where([
                ['country_id', '=', $co->country_id],
                ['lang_id', '=', 'ru']
            ])->get();

            foreach ($region as $r){
                $res[] = [
                    'country_id' => $c->country_id,
                    'title' => $r->title,
                    'lang_id' => $c->lang_id
                ];
            }
        }
        Region::insert($res);
    }
}
