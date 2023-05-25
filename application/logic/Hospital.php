<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;

class Hospital extends BaseLogic
{
    public $alias = "医院信息";
    protected $fields = array("id" => "编号", "name" => "医院名称");
    protected $textFields = array("id" => "编号" , "name" => "医院名称");
    protected $optFields = [];

    public function prepareRows()
    {
        $m = model("hospital");
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
        $m = model("hospital");
        return $m->where('id',$id)->find();
    }
}