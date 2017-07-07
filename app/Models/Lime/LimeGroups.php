<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $gid
 * @property string $language
 * @property integer $sid
 * @property string $group_name
 * @property integer $group_order
 * @property string $description
 * @property string $randomization_group
 * @property string $grelevance
 */
class LimeGroups extends Model
{
    /**
     * @var array
     */
    protected $connection = 'mysql_lime';
    protected $table = 'groups';
    protected $fillable = ['sid', 'group_name', 'group_order', 'description', 'randomization_group', 'grelevance'];

}
