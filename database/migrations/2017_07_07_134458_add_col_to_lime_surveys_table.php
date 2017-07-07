<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToLimeSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_lime')->table('surveys', function (Blueprint $table) {
            $table->longText('interests_tags')->nullable();
            $table->integer('type_id')->unsigned()->default(0);
            $table->integer('reward')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_lime')->table('surveys', function(Blueprint $table){
            $table->dropColumn('interests_tags');
            $table->dropColumn('type_id');
            $table->dropColumn('reward');

        });
    }
}
