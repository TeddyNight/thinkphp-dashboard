<?php
namespace app\validate;

use think\Validate;

class Arrangement extends Validate
{
    protected $rule = [
        'room' => 'require|length:2,20',
        'startTime' => 'require|date',
        'endTime' => 'require|date',
        'drId' => 'require|number|length:11',
        'type' => 'require'
    ];
}
?>