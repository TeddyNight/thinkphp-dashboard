<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class InpatientRoom extends Model
{
    protected $type = [
        'id'    =>  'integer'
    ];

    public function InpatientDepartment()
    {
        return $this->belongsTo('inpatient_department','deptId','id');
    }

    public function InpatientBed()
    {
        return $this->hasMany('inpatient_bed', 'rId', 'id');
    }
}
