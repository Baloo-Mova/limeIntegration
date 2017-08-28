<?php

namespace App\Console\Commands;

use App\Models\C;
use App\Models\City;
use App\Models\R;
use App\Models\Region;
use App\Models\S;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\Cities;
use App\Models\Regions;
use GuzzleHttp\Client;
use App\Shop;
use Illuminate\Support\Facades\DB;

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
        /*$countries = Country::where('lang_id', '<>', 'ru')->get();

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
        Region::insert($res);*/

        /*$countries = Country::all();

        $res = [];

        foreach ($countries as $country){
            $cou = C::where('title_ru', '=', $country->title)->first();

            $regions = R::where('country_id', '=', $cou->country_id)->get();

            foreach ($regions as $r){
                $res[] = [
                    'country_id' => $country->country_id,
                    'title' => $r->title_ru,
                    'lang_id' => $country->lang_id
                ];
            }
        }
        Region::insert($res);*/

        /*$countries = Country::all();

        $res = [];

        foreach ($countries as $country){
            $cou = C::where('title_ru', '=', $country->title)->first();

            $regions = R::where('country_id', '=', $cou->country_id)->get();

            foreach ($regions as $r){

                $reg = Region::where([
                    'title' => $r->title_ru,
                    'lang_id' => $country->lang_id
                ])->first();

                $cities = S::where([
                    'region_id' => $r->region_id,
                    'country_id' => $cou->country_id
                ])->get();

                foreach ($cities as $c){
                    $res[] = [
                        'country_id' => $country->country_id,
                        'region_id' => $reg->region_id,
                        'title' => $c->title_ru,
                        'area' => $c->area_ru,
                        'lang_id' => $country->lang_id
                    ];

                    if (count($res) > 999){
                        echo "insert".PHP_EOL;
                        City::insert($res);
                        $res = [];
                        continue;
                    }
                }
            }

            if (count($res) > 0){
                City::insert($res);
            }


        }*/

        /*$countries = Country::where('lang_id', '<>', 'ru')->get();

        $res = [];
        foreach ($countries as $c) {
            $co = Country::where(['title' => $c->title, 'lang_id' => 'ru'])->first();
            $regions = Region::where([
                ['country_id', '=', $co->country_id],
                ['lang_id', '=', 'ru']
            ])->get();

            foreach ($regions as $region) {

                $reg = Region::where([
                    'country_id' => $c->country_id,
                    'lang_id' => $c->lang_id
                ])->first();

                $cities = City::where([
                    'country_id' => $co->country_id,
                    'region_id' => $region->region_id,
                    'lang_id' => 'ru'
                ])->get();


                foreach ($cities as $city) {

                    $res[] = [
                        'country_id' => $c->country_id,
                        'region_id' => $reg->region_id,
                        'title' => $city->title,
                        'area' => $city->area,
                        'lang_id' => $c->lang_id
                    ];

                    if (count($res) > 999) {
                        echo "insert" . PHP_EOL;
                        City::insert($res);
                        $res = [];
                        continue;
                    }
                }

                if (count($res) > 0) {
                    City::insert($res);
                }

                sleep(5);

            }
        }*/

        /*$regions = Region::where('country_id', '=', 2)->get();

        $res = [];

        foreach ($regions as $region){
            $reg = R::where('title_ru', '=', $region->title)->first();
            Region::where('region_id', '=', $region->region_id)
                ->update([
                    'title' => $reg->title_ua,
                    'lang_id' => 'uk'
                ]);
        }*/

        $res = [];

            //$reg = DB::table('located_region')->where(['region' => 9, 'region' => 10])->get();

            $area = DB::table('located_area')->where('region', '=', 10)->get();

            foreach ($area as $a){
                $res[] = [
                    'country_id' => 2,
                    'region_id' => 86,
                    'title' => $a->area,
                    'area' => null,
                    'lang_id' => 'uk'
                ];

                if(count($res) > 999){
                    echo "insert".PHP_EOL;
                    City::insert($res);
                    $res = [];
                }
            }

            $villages = DB::table('located_village')->where('region', '=', 10)->get();

            foreach ($villages as $village){
                $res[] = [
                    'country_id' => 2,
                    'region_id' => 86,
                    'title' => $village->village,
                    'area' => null,
                    'lang_id' => 'uk'
                ];

                if(count($res) > 999){
                    echo "insert".PHP_EOL;
                    City::insert($res);
                    $res = [];
                }
            }

        if(count($res) > 0){
            echo "insert".PHP_EOL;
            City::insert($res);
            $res = [];
        }




    }

}
