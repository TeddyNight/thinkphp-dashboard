<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;
use think\facade\Request;

abstract class Arrangement extends BaseLogic
{
    protected function is_time_collision($arr,$start,$end) {
        $astart = strtotime($arr['start_time']);
        $aend = strtotime($arr['end_time']);
        if ($end < $astart) {
            return false;
        }
        else if ($start > $aend) {
            return false;
        }
        return true;
    }

    protected function is_vaild_time($start, $end)
    {
        if (!($start < $end)) {
            throw new \think\Exception('开始时间或结束时间有误',100006);
        }
        $clinic = model("clinic_arrangement")->all();
        foreach ($clinic as $arr) {
            if ($this->is_time_collision($arr,$start,$end)) {
                throw new \think\Exception('时间冲突', 100006);
            }
        }

        $inpatient = model("inpatient_arrangement")->all();
        foreach ($inpatient as $arr) {
            if ($this->is_time_collision($arr,$start,$end)) {
                throw new \think\Exception('时间冲突', 100006);
            }   
        }

    }

    public function doCreate() {
        $start = strtotime(Request::post('start_time'));
        $end = strtotime(Request::post('end_time'));
        $this->is_vaild_time($start,$end);
        $this->allowField(true)->save($_POST);
    }

    public function doUpdate() {
        $start = strtotime(Request::post('start_time'));
        $end = strtotime(Request::post('end_time'));
        $this->is_vaild_time($start,$end);
        $this->allowField(true)->isUpdate(true)->save($_POST);
    }
}