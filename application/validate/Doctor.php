<?php
namespace app\validate;

use think\Validate;

class Doctor extends Validate
{
    protected $rule = [
        'name' => 'require|chsAlpha|length:2,16',
        'title' => 'require',
        'i_deptId' =>  'require|number',
        'c_deptId' =>  'require|number',
        'phone' => 'require|mobile',
    ];
}
?>