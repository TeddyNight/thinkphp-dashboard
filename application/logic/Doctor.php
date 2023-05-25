<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\UserLogic;
use think\Db;

class Doctor extends BaseLogic implements UserLogic
{
    public $alias = "医生";
    protected $fields = array("id" => "工号", "name" => "姓名", "phone" => "电话", "c_dept" => "所属门诊部科室", "i_dept" => "所属住院部科室");
    protected $textFields = array("id" => "工号", "name" => "姓名", "phone" => "电话");
    protected $optFields = array("sex" => "性别" , "title" => "职称", "c_deptId" => "所属门诊科室", "i_deptId" => "所属住院部科室");

    public function prepareRows()
    {
        $m = model("doctor");
        $rows = $m->with("clinic_department,inpatient_department")
                ->all()
                ->bindAttr("clinic_department",["c_dept" => "name"])
                ->bindAttr("inpatient_department",["i_dept" => "name"]);
        return $rows;
    }

    public function prepareOpts()
    {
        $clinic = model("clinic_department")->all();
        $inpatient = model("inpatient_department")->all();
        $title = model("doctor_title")->all()->toArray();
        $opts = array(
                "c_deptId" => $clinic,
                "i_deptId" => $inpatient,
                "sex" => [array('id' => '男', 'name' => '男'), array('id' => '女', 'name' => '女')],
                "title" => array_map(function ($row) {
                    return array('id' => $row['name'], 'name' => $row['name']);
                },$title)
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