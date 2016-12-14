<?php

namespace App;

use Carbon\Carbon;
use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{

    protected $table = 'roles';

    protected $fillable = [
        'name', 'slug', 'permissions', 'active', 'list_id'
    ];

    /**
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    public function getPermissions()
    {
        parent::getPermissions();
    }

}
