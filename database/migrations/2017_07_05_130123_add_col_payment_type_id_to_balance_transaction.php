<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColPaymentTypeIdToBalanceTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('balance_transactions_log', function (Blueprint $table) {
            $table->integer('payment_type_id')->unsigned();
            $table->integer('status')->default(0);
            $table->integer('ls_surveys_id')->unsigned()->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('balance_transactions_log', function(Blueprint $table){
            $table->dropColumn('payment_type_id');
            $table->dropColumn('status');
            $table->dropColumn('ls_surveys_id');


        });
    }
}
