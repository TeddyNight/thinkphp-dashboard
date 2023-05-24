<?php
namespace app\model;

use think\Model;

class InpatientArrangement extends Model
{
    public function doctor()
    {
        return $this->belongsTo('doctor',"drId","id");
    }

}
