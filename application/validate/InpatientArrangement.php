<?php
namespace app\validate;

use think\Validate;

class InpatientArrangement extends Validate
{
    protected $rule = [
        'start_time' => 'require|date',
        'end_time' => 'require|date',
        'drId' => 'require|number',
    ];
}
?>