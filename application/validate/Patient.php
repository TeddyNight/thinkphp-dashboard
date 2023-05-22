<?php
namespace app\validate;

use think\Validate;

class Patient extends Validate
{
    protected $rule = [
        'name' => 'require|chsAlpha|length:2,16',
        'phone' => 'require|mobile',
        'sex' => 'require',
        'address' => 'require|chsAlpha|length:2,50'
    ];
}
?>