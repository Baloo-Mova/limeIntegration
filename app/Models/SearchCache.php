<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchCache extends Model
{
    protected $table = 'search_cache';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parameters',
        'search_time',
        'guid'
    ];
}
