<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class BalanceTransactionLog extends Model
{
    protected $table = 'balance_transactions_log';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'description',
        'balance_operation',
        'created_at',
        'updated_at',
    ];


}
