<?php
namespace app\model;

use think\Model;

class Doctor extends Model
{
    public function ClinicDepartment()
    {
        return $this->belongsTo('clinic_department',"c_deptId","id");
    }

    public function ClinicArrangement()
    {
        return $this->hasMany('clinic_arrangement','drId');
    }

}
