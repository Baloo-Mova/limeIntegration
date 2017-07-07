<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();

            $table->string('ls_password')->nullable();
            $table->string('ls_session_token')->nullable();
            $table->integer('ls_session_expire')->nullable();
            $table->longText('interests_tags')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('ls_password');
            $table->dropColumn('ls_session_token');
            $table->dropColumn('ls_session_expire');
            $table->dropColumn('interests_tags');
        });
    }
}
