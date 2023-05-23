<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use think\facade\Request;

class Medicine extends BaseLogic
{
    public $alias = "药品";
    protected $fields = array("id" => "编号", "name" => "药品名称", "price" => "价格", "stockNum" => "库存");
    protected $textFields = array("id" => "编号", "name" => "药品名称", "price" => "价格", "stockNum" => "库存", "usage" => "用法");
    protected $optFields = [];

    public function prepareRows()
    {
        $m = model("medicine");
        if (Request::has('search','get')) {
            $search = Request::get('search');
            $rows = $m->where([['name','like',"%$search%"],['stockNum','>','0']])->select();
        }
        else {
            $rows = $m->where([['stockNum','>','0']])->select();
        }
        return $rows;
    }

    public function prepareOpts()
    {
        $opts = [];
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("medicine");
        return $m->where('id',$id)->find();
    }

}