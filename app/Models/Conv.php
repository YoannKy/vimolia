<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use App\Models\User;

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

    public static function setConvAttribute($id, $attributeName, $attribute)
    {
        $conv = Conv::find($id);
        if ($attributeName == 'closed') {
            $conv->closed= $attribute;
        } else if ($attributeName == 'satisfied') {
            $conv->satisfied= $attribute;
        } else if ($attributeName == 'public') {
              $conv->public= $attribute;
        } else if ($attributeName == 'further') {
              $conv->further= $attribute;
        } else if ($attributeName == 'title') {
              $conv->title= $attribute;
        } else if ($attributeName == 'video') {
              $conv->video= $attribute;
        }
        $conv->save();
    }

    public static function getPublicConvs()
    {
        return Conv::where('public', 1)->where('closed', 1)->get();
    }

    public static function removeOtherExperts($id)
    {
        $conv = Conv::find($id);
        foreach ($conv->users as $user) {
            if (Sentinel::findById($user->id)->inRole('expert') && $user->id != Sentinel::getUser()->id) {
                $conv->users()->detach($user);
            }
        }
        $conv->save();
    }

    public static function getReceiver($id)
    {
        $receiver = [];
        $conv = Conv::find($id);
        foreach ($conv->users as $user) {
            if ($user->id != Sentinel::getUser()->id) {
                array_push($receiver, $user->email);
            }
        }
        return $receiver;
    }
}
