<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('regions');
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('region_id');
            $table->integer('country_id')->index();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('regions');
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->index();
            $table->integer('region_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('lang_id');
            $table->timestamps();
        });
    }
}
