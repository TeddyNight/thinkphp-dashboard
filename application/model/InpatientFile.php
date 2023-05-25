<?php
namespace app\model;

use think\Model;

class InpatientFile extends Model
{
    public function Patient()
    {
        return $this->belongsTo('Patient','pId','id');
    }

    public function Doctor()
    {
        return $this->belongsTo('Doctor','drId','id');
    }
}
