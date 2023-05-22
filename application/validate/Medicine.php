<?php
namespace app\validate;

use think\Validate;

class Medicine extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,30',
        'price' => 'require|float',
        'stockNum' => 'require|integer',
        'usage' => 'require|length:1,200'
    ];
}
?>