<?php
namespace app\validate;

use think\Validate;

class ClinicRoom extends Validate
{
    protected $rule = [
        'id' => 'require|length:1,20'
    ];

}
?>