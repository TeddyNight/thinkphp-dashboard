<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class ClinicRoom extends Model
{
    public function arrangement()
    {
        return $this->hasMany('arrangement','rId','id');
    }   
}