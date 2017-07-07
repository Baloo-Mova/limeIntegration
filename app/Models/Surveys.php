<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $sid
 * @property string $interests_tags
 * @property integer $type_id
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 */
class Surveys extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['interests_tags', 'type_id', 'active', 'created_at', 'updated_at'];

}
