<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentsType
 *
 * @property int $id
 * @property string $title
 * @property int|null $weight_global
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentsType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentsType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentsType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentsType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentsType whereWeightGlobal($value)
 * @mixin \Eloquent
 */
class PaymentsType extends Model
{
    protected $table = 'payments_types';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'title',
        'weight_global',
        'created_at',
        'updated_at',
    ];


}
