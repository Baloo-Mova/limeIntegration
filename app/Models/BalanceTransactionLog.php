<?php

namespace App\Models;


use App\Models\Lime\LimeSurveyLinks;
use App\Models\Lime\LimeSurveysLanguageSettings;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentsType;
use Illuminate\Support\Facades\Lang;

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
 * @property int $status
 * @property int $ls_surveys_id
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
        'payment_type_id',
        'status',
        'ls_surveys_id',
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
                return Lang::get('messages.balanceStatusCompleted');;
                break;
            case 2:
                return Lang::get('messages.balanceStatusCanceled');
                break;
        }

    }

    public function survey()
    {
        return 1;
    }
}
