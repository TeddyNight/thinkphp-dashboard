<?php
namespace app\validate;

use think\Validate;

class Prescription extends Validate
{
    protected $rule = [
        'rId' => 'require|number',
        'description' => 'require|length:1,200',
        'medicine' => 'require|array'
    ];
}
?>