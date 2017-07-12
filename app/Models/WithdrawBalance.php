<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $decription
 * @property integer $amount
 * @property integer $payment_type_id
 * @property string $destination
 * @property integer $currency_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class WithdrawBalance extends Model
{
    /**
     * @var array
     */
    protected $table = 'withdraw_balances';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'payment_type_id',
        'destination',
        'currency_id',
        'status',
        'created_at',
        'updated_at'
    ];
    public function paymentstype()
    {
        return $this->belongsTo(PaymentsType::class, 'payment_type_id');
    }

    public function getStatusMessage()
    {
        switch ($this->status) {
            case 0:
                return Lang::get('messages.balanceStatusInProcess');
                break;
            case 1:
                return Lang::get('messages.balanceStatusCompleted');
                break;
            case 2:
                return Lang::get('messages.balanceStatusCanceled');
                break;
        }

    }
    public function getStatusColor()
    {
        switch ($this->status) {
            case 0:
                return 'bg-warning';
                break;
            case 1:
                return 'bg-success';
                break;
            case 2:
                return 'bg-danger';
                break;
        }

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
