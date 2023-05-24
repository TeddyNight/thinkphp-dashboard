<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;

class ClinicArrangement extends BaseLogic
{
    public $alias = "坐诊安排";
    protected $fields = array("id" => "编号", "room" => "诊室", "doctor" => "医生", "start_time" => "开始时间", "end_time" => "结束时间");
    protected $textFields = array("id" => "编号", "start_time" => "开始时间", "end_time" => "结束时间");
    protected $optFields = array("rId" => "诊室", "drId" => "医生");

    public function prepareRows()
    {
        $rows = [];
        $role = Auth::getRole();
        if ($role == "admin") {
            $rows = Db::query("SELECT a.id id, r.id room, a.start_time, a.end_time, dr.name doctor
                FROM clinic_arrangement a
                INNER JOIN clinic_room r
                INNER JOIN doctor dr
                ON (a.rId = r.id AND a.drId = dr.id)");
        }
        else if ($role == "doctor") {
            $account = Auth::getAccount();
            $rows = Db::query("SELECT a.id id, r.id room, a.start_time, a.end_time, dr.name doctor
                FROM clinic_arrangement a
                INNER JOIN clinic_room r
                INNER JOIN doctor dr
                ON (a.rId = r.id AND a.drId = dr.id)
                WHERE a.drId = $account
                LIMIT 1");  
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
                    "room" => $room
            );
        return $opts;
    }

    public function prepareData($id)
    {
        $data = Db::query("SELECT a.id id, r.room clinic_room, a.start_time, a.end_time, a.drId
                        FROM clinic_arrangement a
                        INNER JOIN clinic_room r
                        ON (a.rId = r.id)
                        WHERE a.id = $id
                        LIMIT 1")[0];
        return $data;
    }

}