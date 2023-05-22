<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\UserLogic;

class Patient extends BaseLogic implements UserLogic
{
    public $name = "病人";
    protected $fields = array("id" => "编号", "name" => "名字", "sex" => "性别", "phone" => "电话号码", "address" => "地址");
    protected $textFields = array("name" => "名字", "phone" => "电话号码", "address" => "地址");
    protected $optFields = array("sex" => "性别");

    public function prepareRows()
    {
        $m = model("patient");
        $rows = $m->all();
        return $rows;
    }

    public function prepareOpts()
    {
        $opts = array("sex" => [array('id' => '男', 'name' => '男'), array('id' => '女', 'name' => '女')]);
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("patient");
        return $m->where('id',$id)->find();
    }

    public function findAccount($account) {
        $m = model("patient");
        return $m->where('phone',$account)->find();
    }

}