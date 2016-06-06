<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Carbon\Carbon;
use Sentinel;

class User extends EloquentUser
{
   
    public function roles()
    {
        return  $this->belongsToMany('App\Models\Role', 'role_users', 'user_id', 'role_id');
    }


    public function convs()
    {
        return  $this->belongsToMany('App\Models\Conv', 'conv_users', 'user_id', 'conv_id');
    }

    public function forms()
    {
        return $this->hasMany('App\Models\Form');
    }

    public static function listExpertsFromLastWeek()
    {
          return User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'like', '%expert%');
          })/*->where('last_login', '>=', new Carbon('last week'))*/->get();
    }

    public static function getParticipants($aId)
    {
        return User::whereIn('id', $aId)->where('id', '!=', Sentinel::getUser()->id)->first();
    }

    public static function listDoctors($filter = null)
    {
        if ($filter) {
            return User::whereIn('doctors', $filter)->get();
        }
        return User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'like', '%practicien%');
        })->get();
    }

    public static function listExperts()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'like', '%expert%');
        })->get();
    }
}
