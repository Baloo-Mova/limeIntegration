<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Country;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $second_name
 * @property string $email
 * @property string $password
 * @property int $balance
 * @property int $role_id
 * @property int $country_id
 * @property int $region_id
 * @property int $city_id
 * @property string $date_birth
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $phone
 * @property string|null $ls_password
 * @property string|null $ls_session_token
 * @property int|null $ls_session_expire
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Country[] $country
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDateBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLsPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLsSessionExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLsSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSecondName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'second_name',
        'email',
        'password',
        'balance',
        'role_id',
        'country_id',
        'region_id',
        'city_id',
        'date_birth',
        'ls_password',
        'ls_session_token',
        'ls_session_expire',
        'interests_tags',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	 public function  isAdmin(){
     return $this->role_id;
    }
    public function country(){
	     if(Lang::getLocale()=="ru"){
	         return $this->hasMany(Country::class, 'country_id','country_id')->where('lang_id',2 );
	     }
    }
}