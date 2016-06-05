<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;

class Conv extends Model
{
    protected $table = 'conversations';
   
    public function users()
    {
        return  $this->belongsToMany('App\Models\User', 'conv_users', 'conv_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    public static function setConvAttribute($id, $attribute, $isAttribute)
    {
        $conv = Conv::find($id);
        if ($attribute == 'closed') {
            $conv->closed= $isAttribute;
        } else if ($attribute == 'satisfied') {
            $conv->satisfied= $isAttribute;
        } else if ($attribute == 'public') {
              $conv->public= $isAttribute;
        } else if ($attribute == 'further') {
              $conv->further= $isAttribute;
        }
        $conv->save();
    }

    public static function getPublicConvs()
    {
        return Conv::where('public',1)->where('closed',1)->get();
    }
}
