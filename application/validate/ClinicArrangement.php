<?php
namespace app\validate;

use think\Validate;

class ClinicArrangement extends Validate
{
    protected $rule = [
        'room' => 'require|length:2,20',
        'start_time' => 'require|date',
        'end_time' => 'require|date',
        'drId' => 'require|number|length:11',
    ];
}
?>