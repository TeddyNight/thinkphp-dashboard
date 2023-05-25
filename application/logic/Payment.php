<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;

class Payment extends BaseLogic
{
    public $alias = "支付记录";
    protected $fields = array("id" => "支付流水号", "create_time" => "支付时间", "total" => "支付金额");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $m = model("payment");
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
        $m = model("payment");
        return $m->where('id',$id)->find();
    }
}