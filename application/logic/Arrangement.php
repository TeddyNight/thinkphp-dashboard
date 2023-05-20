<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;

class Arrangement extends BaseLogic
{
    public $name = "排班";
    protected $fields = array("id" => "编号", "type" => "类型", "room" => "诊室或病房", "doctor" => "医生", "startTime" => "开始时间", "endTime" => "结束时间");
    protected $textFields = array("room" => "诊室或病房", "startTime" => "开始时间", "endTime" => "结束时间");
    protected $optFields = array("type" => "类型", "drId" => "医生");

    public function prepareRows()
    {
        $rows = [];
        $role = Auth::getRole();
        if ($role == "admin") {
            $m = model("arrangement");
            $rows = $m->with("doctor")->all()->bindAttr('doctor',["doctor" => "name"]);
        }
        else if ($role == "doctor") {
            $m = model("arrangement");
            $rows = $m->with("doctor")->where('drId', Auth::getAccount())->select()->bindAttr('doctor',["doctor" => "name"]);   
        }
        return $rows;
    }

    public function prepareOpts()
    {
        $m = model("doctor");
        $opts = array("drId" => $m->all()->toArray(), 
                "type" => [array('id' => '坐诊', 'name' => '坐诊'), array('id' => '巡诊', 'name' => '巡诊')]
            );
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("arrangement");
        return $m->where('id',$id)->find();
    }

}