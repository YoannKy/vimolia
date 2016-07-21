<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use App\Models\User;
use DB;
class Skill extends Model
{
    protected $table = 'skills';


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'skill_users', 'skill_id', 'user_id');
    }


    public static function addSkills(array $ids, $userId)
    {
        /*create a new form*/
        foreach ($ids as $skillId) {
            DB::table('skill_users')->insert(array('skill_id' => $skillId, 'user_id' => $userId));
        }
    }
}
