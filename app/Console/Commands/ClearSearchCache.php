<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\SearchCache;

class ClearSearchCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:search_cache';

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
        $dt = Carbon::now()->subMinute(30);
        $clearlist = SearchCache::where('search_time', '<', $dt)->get()->toArray();

        foreach ($clearlist as $cl){

            try{
                DB::table('search_cache_'.$cl->guid)->delete();
            }catch (\Exception $ex){
                continue;
            }
        }

        SearchCache::whereIn('guid', array_column($clearlist, 'guid'))->delete();
    }
}
