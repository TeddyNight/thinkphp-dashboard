<?php
namespace app\validate;

use think\Validate;

class Department extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,16'
    ];
}
?>