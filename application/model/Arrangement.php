<?php
namespace app\model;

use think\Model;

class Arrangement extends Model
{
    public function doctor()
    {
        return $this->belongsTo('doctor',"drId","id");
    }

    public function registration()
    {
        return  $this->hasMany('registration','arrId');
    }

    public function getNameAttr($value,$data)
    {
        $doctor = Doctor::get($data["drId"]);
        return  "{$doctor["name"]} {$data["startTime"]}-{$data["endTime"]} {$data["room"]}诊室";
    }

    public function getDoctorAttr($value,$data)
    {
        $doctor = Doctor::get($data["drId"]);
        return $doctor["name"];
    }

    public function getTimeAttr($value,$data)
    {
        return "{$data["startTime"]} - {$data["endTime"]}";
    }

}
