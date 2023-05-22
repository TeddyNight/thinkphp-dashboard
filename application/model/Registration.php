<?php
namespace app\model;

use think\Model;

class Registration extends Model
{
    public function patient()
    {
        return $this->belongsTo('patient',"patId","id");
    }

    public function arrangement()
    {
        return $this->belongsTo('arrangement',"arrId","id");
    }

    public function doctor()
    {
        return $this->belongsTo('doctor');
    }
}
