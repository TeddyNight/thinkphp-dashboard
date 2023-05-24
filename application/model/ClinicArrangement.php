<?php
namespace app\model;

use think\Model;

class ClinicArrangement extends Model
{
    public function doctor()
    {
        return $this->belongsTo('doctor',"drId","id");
    }

    public function registration()
    {
        return  $this->hasMany('registration','arrId');
    }

    public function room()
    {
        return $this->belongsTo('room','rId','id');
    }

    public function getDoctorAttr($value,$data)
    {
        $doctor = Doctor::get($data["drId"]);
        return $doctor["name"];
    }

}
