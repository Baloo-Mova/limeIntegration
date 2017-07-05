<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTransactionsLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transactions_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->index();
            $table->integer('to_user_id')->index();
            $table->string('description')->nullable();
            $table->integer('balance_operation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_transactions_log');
    }
}
