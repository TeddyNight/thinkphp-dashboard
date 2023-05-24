<?php
namespace app\validate;

use think\Validate;

class InpatientDepartment extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,30'
    ];
}
?>