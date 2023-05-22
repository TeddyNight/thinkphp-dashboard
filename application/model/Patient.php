<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class Patient extends Model
{
    
    public function registration()
    {
        return  $this->hasMany('registration','patId');
    }

    
}
