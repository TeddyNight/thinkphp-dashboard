<?php
namespace app\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'account' => 'require',
        'passwd' => 'require'
    ];
}
?>