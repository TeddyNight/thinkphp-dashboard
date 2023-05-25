<?php
namespace app\validate;

use think\Validate;

class InpatientFile extends Validate
{
    protected $rule = [ 
        'drId' => 'require|number|length:11',
        'rId' => 'require|number',
        'bId' => 'require|number'
    ];

}
?>