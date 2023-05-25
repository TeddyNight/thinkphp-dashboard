<?php
namespace app\model;

use think\Model;
use app\common\BaseModel;

class InpatientMedicine extends Model
{
    protected $pk = ['mId','tId'];
}
