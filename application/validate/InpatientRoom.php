<?php
namespace app\validate;

use think\Validate;

class InpatientRoom extends Validate
{
    protected $rule = [
        'id' => 'require|length:1,30',
        'deptId' => 'require|number'
    ];

    public function InpatientBed()
    {
        return $this->hasMany('inpatient_bed','rId','id');
    }
}
?>