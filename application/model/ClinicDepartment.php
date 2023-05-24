<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class ClinicDepartment extends Model
{
    protected $type = [
        'id'    =>  'integer'
    ];

    public function doctor()
    {
        return $this->hasMany('doctor','c_deptId','id');
    }

}
