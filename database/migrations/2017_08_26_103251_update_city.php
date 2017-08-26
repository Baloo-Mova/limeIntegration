<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cities');
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('city_id');
            $table->integer('country_id')->nullable()->index();
            $table->integer('region_id')->index();
            $table->string('title')->nullable();
            $table->string('area')->nullable();
            $table->string('lang_id', 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id')->index();
            $table->integer('country_id')->index();
            $table->integer('region_id')->index();
            $table->string('title')->nullable();
            $table->string('area')->nullable();
            $table->integer('lang_id');
            $table->timestamps();
        });
    }
}
