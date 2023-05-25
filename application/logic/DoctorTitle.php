<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;

class DoctorTitle extends BaseLogic
{
    public $alias = "医生职称";
    protected $fields = array("name" => "名称", "price" => "诊疗费用");
    protected $textFields = array("name" => "名称", "price" => "诊疗费用");
    protected $optFields = [];

    public function prepareRows()
    {
        $m = model("doctor_title");
        $rows = $m->all();
        return $rows;
    }

    public function prepareOpts()
    {
        $opts = [];
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("doctor_title");
        return $m->where('name',$id)->find();
    }

    public function doCreate() {
        $this->allowField(true)->save($_POST);
    }

    public function doUpdate() {
        $this->allowField(true)->isUpdate(true)->save($_POST);
    }
}