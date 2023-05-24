<?php
namespace app\model;

use think\Model;

class Registration extends Model
{
    public function patient()
    {
        return $this->belongsTo('patient',"pId","id");
    }

    public function arrangement()
    {
        return $this->belongsTo('arrangement',"aId","id");
    }

    public function doctor()
    {
        return $this->belongsTo('doctor');
    }

    public function getPatientAttr($value,$data)
    {
        $patient = Patient::get($data["pId"]);
        return $patient["name"];
    }
}
