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
        return $this->hasManyThrough('ClinicDoctor','doctor','drId','deptId','id');
    }
}
