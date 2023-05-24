<?php
namespace app\validate;

use think\Validate;

class Doctor extends Validate
{
    protected $rule = [
        'id'  =>  'require|number|length:11',
        'name' => 'require|chsAlpha|length:2,16',
        'i_deptId' =>  'require|number',
        'c_deptId' =>  'require|number',
        'phone' => 'require|mobile',
    ];
}
?>