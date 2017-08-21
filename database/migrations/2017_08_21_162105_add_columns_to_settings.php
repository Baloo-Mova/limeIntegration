<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function(Blueprint $table){
            $table->string('smtp')->nullable();
            $table->smallInteger('smtp_port')->nullable();
            $table->string('smtp_login')->nullable();
            $table->string('smtp_pasw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings',function(Blueprint $table){
            $table->dropColumn('smtp');
            $table->dropColumn('smtp_port');
            $table->dropColumn('smtp_login');
            $table->dropColumn('smtp_pasw');
        });
    }
}
