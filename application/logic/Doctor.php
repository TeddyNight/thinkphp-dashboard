<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\UserLogic;
use think\Db;

class Doctor extends BaseLogic implements UserLogic
{
    public $alias = "医生";
    protected $fields = array("id" => "工号", "name" => "姓名", "phone" => "电话");
    protected $textFields = array("id" => "工号", "name" => "姓名", "phone" => "电话");
    protected $optFields = array("sex" => "性别" , "title" => "职称");

    public function prepareRows()
    {
        $m = model("doctor");
        $rows = $m->all();
        return $rows;
    }

    public function prepareOpts()
    {
        $opts = array(
                "sex" => [array('id' => '男', 'name' => '男'), array('id' => '女', 'name' => '女')],
                "title" => [array('id' => '初级', 'name' => '初级'),
                        array('id' => '中级', 'name' => '中级'),
                        array('id' => '高级', 'name' => '高级')]
            );
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("doctor");
        return $m->where('id',$id)->find();
    }

    public function findAccount($account) {
        $m = model("doctor");
        return $m->where('id',$account)->find();
    }
}