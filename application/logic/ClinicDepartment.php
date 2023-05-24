<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;

class Clinicdepartment extends BaseLogic
{
    public $alias = "门诊科室";
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

}