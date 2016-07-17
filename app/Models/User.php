<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Carbon\Carbon;
use Sentinel;
use DB;
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


    public static function getUser($id)
    {
        return User::find($id);
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

    public static function  listPatients()
    {
        $users = DB::table('forms')
            ->join('users', 'users.id', '=', 'forms.user_id')
            ->select('users.*', 'forms.id as formId', 'forms.has_consultation as isValidate')
            ->where('forms.choose', Sentinel::getUser()->id)
            ->get();

        return $users;
    }

    public static function getNote($id)
    {
        $note = DB::table('note_users')
            ->select(DB::raw('SUM(note) as note, COUNT(note_users.id) as number'))
            ->where('note_users.doctor_id', $id)
            ->get();
        if($note[0]->number == 0) {
            return null;
        }
        $note = $note[0]->note / $note[0]->number;
        $note = number_format($note, 1);
        return $note;
    }
}
