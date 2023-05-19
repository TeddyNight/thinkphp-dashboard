<?php
namespace app\common;

use think\Model;

class BaseModel extends Model
{
    protected $fields;
    
    function getFields() {
        return $fields;
    }
    
}
