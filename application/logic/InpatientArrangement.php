<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;

class InpatientArrangement extends BaseLogic
{
    public $alias = "巡诊安排";
    protected $fields = array("id" => "编号", "doctor" => "医生", "start_time" => "开始时间", "end_time" => "结束时间");
    protected $textFields = array("id" => "编号", "start_time" => "开始时间", "end_time" => "结束时间");
    protected $optFields = array("drId" => "医生");

    public function prepareRows()
    {
        $rows = [];
        $role = Auth::getRole();
        if ($role == "admin") {
            $rows = model('inpatient_department')->with("doctor")->all()->bindAttr("doctor",["doctor" => "name"]);
        }
        else if ($role == "doctor") {
            $account = Auth::getAccount();
            $rows = model('inpatient_department')->with("doctor")->where("drId",$account)->bindAttr("doctor",["doctor"=>"name"]); 
        }
        return $rows;
    }

    public function prepareOpts()
    {
        $doctor = model("doctor")->all()->toArray();
        $room = array_map(function ($row) {
            return array("id" => $row['id'], "name" => $row['id']);
        },model("clinic_room")->all()->toArray());
        $opts = array("drId" => $doctor,
                    "rId" => $room
            );
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("clinic_arrangement");
        $data = $m->get($id);
        return $data;
    }

}