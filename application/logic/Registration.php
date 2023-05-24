<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\facade\View;
use think\Db;

class Registration extends BaseLogic
{
    public $alias = "挂号";
    protected $fields = array("id" => "编号", "patient" => "病人名字", "location" => "诊室", "doctor" => "医生", "time" => "时间");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $account = Auth::getAccount();
        $rows = Db::query("SELECT reg.id id, pat.name patient, room.location, dr.name doctor, CONCAT(arr.start_time,'-',arr.end_time) `time`
                        FROM registration reg
                        INNER JOIN arrangement arr
                        INNER JOIN room
                        INNER JOIN patient pat
                        INNER JOIN doctor dr
                        ON (reg.pId = pat.id AND reg.aId = arr.id AND arr.rId = room.id AND arr.drId = dr.id)
                        WHERE pat.id = $account");
        // $rows = $m->with("arrangement")
        //     ->all()
        //     ->bindAttr('arrangement',["doctor" => "doctor"])
        //     ->bindAttr('arrangement',["location" => "location"])
        //     ->bindAttr('arrangement',["time" => "time"]);
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