<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;

class InpatientArrangement extends Arrangement
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
            $rows = model('inpatient_arrangement')
                    ->with("doctor")
                    ->all()
                    ->bindAttr("doctor",["doctor" => "name"]);
        }
        else if ($role == "doctor") {
            $account = Auth::getAccount();
            $rows = model('inpatient_arrangement')
                    ->with("doctor")
                    ->where("drId",$account)
                    ->select()
                    ->bindAttr("doctor",["doctor"=>"name"]); 
        }
        return $rows;
    }

    public function prepareOpts()
    {
        $doctor = model("doctor")->all()->toArray();
        $opts = array("drId" => $doctor
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