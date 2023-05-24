<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class InpatientBed extends Model
{
    protected $pk = ['bId','rId'];

    public function InpatientRoom()
    {
        return $this->belongsTo('inpatient_room','rId','rId');
    }

}
