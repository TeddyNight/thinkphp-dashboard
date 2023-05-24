<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class InpatientDepartment extends Model
{
    protected $type = [
        'id'    =>  'integer'
    ];

    public function doctor()
    {
        return $this->hasMany('doctor','i_deptId','id');
    }

    public function InpatientRoom()
    {
        return $this->hasMany('inpatient_room','deptId','id');
    }
}
