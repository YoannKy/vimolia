<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use Session;
use DB;
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

    public static function chooseDoctors($doctorId, $formId)
    {
        $form = Form::find($formId);

        $form->choose= $doctorId;

        $form->save();
    }

    public static function addPatient($validation, $formId)
    {
        $form = Form::find($formId);

        if ($validation == 'valider') {
            $form->has_consultation = true;
        } else {
            $form->has_consultation = false;
        }

        $form->save();
    }

    public static function getUserForm()
    {
        return Form::where('user_id',Sentinel::getUser()->id)->get();
    }

    public static function isFind($doctorId)
    {
        $consultation = DB::table('forms')
            ->select('forms.id')
            ->where('forms.choose', $doctorId)
            ->where('forms.user_id', Sentinel::getUser()->id)
            ->where('forms.has_consultation', 1)
            ->get();

        if ($consultation == null) {
           return false;
        }
        return true;
    }

    public static function noteDoctor($note, $doctorId)
    {
        DB::table('note_users')->insert(
            ['user_id' => Sentinel::getUser()->id, 'doctor_id' => $doctorId, 'note' => $note]
        );
    }

    public static function isNoted($doctorId)
    {
        $noted = DB::table('note_users')
            ->select('note_users.id')
            ->where('doctor_id', $doctorId)
            ->where('user_id', Sentinel::getUser()->id)
            ->get();

        if ($noted == null) {
            return false;
        }
        return true;
    }
}
