<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BalanceTransactionLog
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string|null $description
 * @property int $balance_operation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $payment_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereBalanceOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceTransactionLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
