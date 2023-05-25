<?php
namespace app\validate;

use think\Validate;

class DoctorTitle extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,20',
        'price' => 'require|float',
    ];
}
?>