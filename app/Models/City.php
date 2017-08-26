<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $city_id
 * @property int $country_id
 * @property int|null $region_id
 * @property string|null $title
 * @property string|null $area
 * @property int $lang_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $table = 'cities';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'country_id',
        'region_id',
        'title',
        'area',
        'lang_id',
    ];


}
