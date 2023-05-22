<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\facade\View;

class Registration extends BaseLogic
{
    public $name = "挂号";
    protected $fields = array("id" => "编号", "patient" => "病人名字", "room" => "诊室", "doctor" => "医生", "time" => "时间");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $rows = [];
        $role = Auth::getRole();
        if ($role == "admin") {
            $m = model("registration");
            $rows = $m->with("patient,arrangement")
                ->all()
                ->bindAttr('arrangement',["doctor" => "doctor"])
                ->bindAttr('arrangement',["room" => "room"])
                ->bindAttr('arrangement',["time" => "time"])
                ->bindAttr('patient',["patient" => "name"]);
        }
        else if ($role == "doctor") {
            $m = model("arrangement");
            $rows = $m->with("doctor")->where('drId', Auth::getAccount())->select()->bindAttr('doctor',["doctor" => "name"]);   
        }
        return $rows;
    }

    public function prepareOpts() {

    }


    public function loadEdit()
    {
        $dept = model("department")->with("doctor");
        View::share("depts",$dept->all());
        $dr = model("doctor")->with("arrangement");
        View::share("drs",$dr->all());
    }

    public function prepareData($id)
    {
        $m = model("arrangement");
        return $m->where('id',$id)->find();
    }

}