<?php
namespace app\validate;

use think\Validate;

class InpatientFile extends Validate
{
    protected $rule = [ 
        'drId' => 'require|number',
        'rId' => 'require|number',
        'bId' => 'require|number'
    ];

}
?>