<?php
namespace app\validate;

use think\Validate;

class Registration extends Validate
{
    protected $rule = [
        'arrId' => 'require|number'
    ];
}
?>