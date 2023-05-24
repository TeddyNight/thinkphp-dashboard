<?php
namespace app\validate;

use think\Validate;

class InpatientBed extends Validate
{
    protected $rule = [
        'rId' => 'require|length:1,30',
        'bId' => 'require|number'
    ];

}
?>