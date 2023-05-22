<?php
namespace app\validate;

use think\Validate;

class Registration extends Validate
{
    protected $rule = [
        'patId' => 'require|number',
        'arrId' => 'require|number'
    ];
}
?>