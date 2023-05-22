<?php
namespace app\model;

use think\Model;

class Doctor extends Model
{
    public function department()
    {
        return $this->belongsTo('department',"deptId","id");
    }

    public function arrangement()
    {
        return $this->hasMany('arrangement','drId');
    }

}
