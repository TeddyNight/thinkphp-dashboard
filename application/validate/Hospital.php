<?php
namespace app\validate;

use think\Validate;

class Hospital extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,20'
    ];
}
?>