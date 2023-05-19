<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;

class Doctor extends BaseLogic
{
    public $name = "医生";
    protected $fields = array("id" => "工号", "name" => "姓名", "phone" => "电话", "department" => "部门");
    protected $textFields = array("id" => "工号", "name" => "姓名", "phone" => "电话");
    protected $optFields = array("deptId" => "所属科室");

    public function prepareFields()
    {
        $m = model("doctor");
        $rows = $m->with("department")->all()->bindAttr('department',["department" => "name"]);
        return $rows;
    }

    public function prepareOpts()
    {
        $m = model("department");
        $opts = array("deptId" => $m->all()->toArray());
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("doctor");
        return $m->where('id',$id)->find();
    }
}