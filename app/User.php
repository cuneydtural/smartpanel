<?php

namespace App;

use Carbon\Carbon;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Support\Facades\DB;


class User extends EloquentUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'active', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('id', 1);
    }

    /**
     * @return array
     */
    public function getRolesPermissions()
    {
        foreach($this->roles() as $role) {
            $role_slug[] = $role->slug;
        }

        $roles = Role::whereIn('slug', $role_slug)->get();

        $permissions = [];
        foreach ($roles as $role) {
            $permissions = array_merge_recursive($role->permissions, $permissions);
        }
        return $permissions;
    }

    /**
     * @param $role_id
     * @return bool
     */
    public function hasRole($role_id)
    {
        $role = DB::table('role_users')->where('user_id', $this->id)
            ->where('role_id', $role_id)->get();
        if(count($role) <> 0) {
            return true;
        } else {
            return false;
        }
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
    
}
