<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use Session;

class Form extends Model
{
    protected $table = 'forms';
   
    public function user()
    {
        return  $this->belongs('App\Models\User', 'user_id');
    }

    public function conv()
    {
        return  $this->belongs('App\Models\Conv', 'conv_id');
    }

    public static function store($request)
    {
        /*create a new form*/
        $form = new Form;

        $form->user_id = Sentinel::getUser()->id;
        $form->expert_id = Session::get('expert');
        $form->conv_id = Session::get('conv');
        $form->first_name =$request->input('first_name');
        $form->last_name = $request->input('last_name');
        $form->town = $request->input('town');
        $form->symptom= $request->input('symptom');
        $form->info = $request->input('info');
        $form->save();
    }

    public static function addDoctors($aId, $id)
    {
        $form = Form::find($id);

        $form->doctors= $aId;

        $form->save();
    }

    public static function getUserForm()
    {
        return Form::where('user_id',Sentinel::getUser()->id)->get();
    }
}
