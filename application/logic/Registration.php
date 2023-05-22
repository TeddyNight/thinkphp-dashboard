<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\facade\View;

class Registration extends BaseLogic
{
    public $alias = "挂号";
    protected $fields = array("id" => "编号", "patient" => "病人名字", "room" => "诊室", "doctor" => "医生", "time" => "时间");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $rows = [];
        $m = model("registration");
        $rows = $m->with("arrangement")
            ->all()
            ->bindAttr('arrangement',["doctor" => "doctor"])
            ->bindAttr('arrangement',["room" => "room"])
            ->bindAttr('arrangement',["time" => "time"]);
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
        $m = model("registration");
        return $m->where('id',$id)->find();
    }

}