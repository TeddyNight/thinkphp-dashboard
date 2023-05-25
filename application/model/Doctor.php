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

    public function InpatientDepartment()
    {
        return $this->belongsTo('inpatient_department',"i_deptId","id");
    }

    public function InpatientArrangement()
    {
        return $this->hasMany('inpatient_arrangement','drId');
    }

    public function InpatientFile()
    {
        return $this->hasMany('inpatient_file','drId','id');
    }

}
