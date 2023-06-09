<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;

class Clinicdepartment extends BaseLogic
{
    public $alias = "门诊部科室";
    protected $fields = array("id" => "编号", "name" => "科室名称");
    protected $textFields = array("id" => "编号" , "name" => "科室名称");
    protected $optFields = [];

    public function prepareRows()
    {
        $m = model("clinic_department");
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
        $m = model("clinic_department");
        return $m->where('id',$id)->find();
    }

    public function doCreate() {
        $this->allowField(true)->save($_POST);
    }

    public function doUpdate() {
        $this->allowField(true)->isUpdate(true)->save($_POST);
    }
}