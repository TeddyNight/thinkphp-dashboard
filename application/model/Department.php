<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class Department extends Model
{
    protected $type = [
        'id'    =>  'integer'
    ];

    public function doctor()
    {
        return $this->hasMany('Doctor','deptId');
    }
}
