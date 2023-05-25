<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class DoctorTitle extends Model
{
    protected $pk = "name";

    public function doctor()
    {
        return $this->belongsTo('doctor','title','name');
    }

}
