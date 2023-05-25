<?php
namespace app\validate;

use think\Validate;

class Treatment extends Validate
{
    protected $rule = [
        'fId' => 'require|number',
        'description' => 'require|length:1,200',
        'medicine' => 'require|array'
    ];
}
?>