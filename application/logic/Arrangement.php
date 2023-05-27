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
        $astart = $arr['start_time'];
        $aend = $arr['end_time'];
        if (($astart < $start) && ($aend < $start)) {
            return true;
        }
        else if ($astart > $end) {
            return true;
        }
        return false;
    }

    protected function is_exists_arr($start, $end)
    {
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
        $this->is_exists_arr(Request::post('start_time'),Request::post('end_time'));
        $this->allowField(true)->save($_POST);
    }

    public function doUpdate() {
        $this->is_exists_arr(Request::post('start_time'),Request::post('end_time'));
        $this->allowField(true)->isUpdate(true)->save($_POST);
    }
}