<?php
namespace app\validate;

use think\Validate;

class ClinicArrangement extends Validate
{
    protected $rule = [
        'rId' => 'require|length:2,20',
        'start_time' => 'require|date',
        'end_time' => 'require|date',
        'drId' => 'require|number',
    ];
}
?>