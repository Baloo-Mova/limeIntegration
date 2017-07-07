<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Lime\User
 *
 * @property int $uid
 * @property string $users_name
 * @property mixed $password
 * @property string $full_name
 * @property int $parent_id
 * @property string|null $lang
 * @property string|null $email
 * @property string|null $htmleditormode
 * @property string $templateeditormode
 * @property string $questionselectormode
 * @property mixed|null $one_time_pw
 * @property int $dateformat
 * @property string|null $created
 * @property string|null $modified
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereDateformat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereHtmleditormode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereOneTimePw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereQuestionselectormode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereTemplateeditormode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\User whereUsersName($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'full_name',
        'email',
        'password',

    ];



}
