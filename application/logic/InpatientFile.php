<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\facade\Request;
use think\facade\View;

class InpatientFile extends BaseLogic
{
    public $alias = "住院档案";
    protected $fields = array("id" => "编号", "patient" => "病人姓名" ,"doctor" => "主治医生姓名", "rId" => "病房号", "bId" => "病床号", "admission_date" => "入院时间", "discharge_date" => "出院日期");
    protected $textFields = array("id" => "编号");
    protected $optFields = array("i_deptId" => "住院部科室", "drId" => "主治医生", "rId" => "病房号", "bId" => "病床号");

    public function prepareRows()
    {
        $m = model("inpatient_file");
        $role = Auth::getRole();
        $account = Auth::getAccount();
        if ($role == "admin") {
            $rows = $m->with("doctor,patient")
                    ->all()
                    ->bindAttr("doctor",["doctor" => "name"])
                    ->bindAttr("patient",["patient" => "name"]);
        }
        else if ($role == "patient") {
            $rows = $m->with("doctor,patient")
                    ->where('pId',$account)
                    ->select()
                    ->bindAttr("doctor",["doctor" => "name"])
                    ->bindAttr("patient",["patient" => "name"]);
        }
        else if ($role == "doctor") {
            $rows = $m->with("doctor,patient")
                    ->where('drId',$account)
                    ->select()
                    ->bindAttr("doctor",["doctor" => "name"])
                    ->bindAttr("patient",["patient" => "name"]);
        }
        return $rows;
    }

    public function prepareOpts()
    {
        
    }

    public function loadEdit()
    {
        $dept = model("inpatient_department")->with("doctor");
        View::share("depts",$dept->all());
        $dr = model("doctor")->with("inpatient_arrangement");
        View::share("drs",$dr->all());
    }

    public function prepareData($id)
    {
        $m = model("medicine");
        return $m->where('id',$id)->find();
    }

    public function doCreate() {
        $this->pId = Auth::getAccount();
        $this->admission_date = date('Y-m-d');
        $this->allowField(true)->save($_POST);
    }

}