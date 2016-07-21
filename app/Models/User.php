<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Carbon\Carbon;
use Sentinel;
use DB;
class User extends EloquentUser
{

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'address',
        'zip_code',
        'city',
        'date_of_birth',
        'phone_number',
        'avatar',
        'profession',
        'siret',
        'degree',
        'how_did_you_know'
    ];

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill', 'skill_users', 'user_id', 'skill_id');
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

    public static function listDoctors($last_name = null, $skill = null)
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'like', '%praticien%');
        });


        if ($last_name) {
            $user = $user->where('last_name', $last_name);
        }
        if ($skill) {
            $user = $user->whereHas('skills', function ($query) use ($skill) {
                $query->where('skills.name', $skill);
            });
        }
        return $user->get();
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
