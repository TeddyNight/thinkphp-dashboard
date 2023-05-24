<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;

class InpatientRoom extends BaseLogic
{
    public $alias = "住院部病房";
    protected $fields = array("id" => "房间号", "department" => "所属住院部科室");
    protected $textFields = array("id" => "房间号");
    protected $optFields = array("deptId" => "所属住院部科室");

    public function prepareRows()
    {
        $rows = model('inpatient_room')
            ->with('inpatient_department')
            ->all()
            ->bindAttr('inpatient_department',['department' => 'name']);
        return $rows;
    }

    public function prepareOpts()
    {
        $dept = model("inpatient_department")->all();
        $opts = array("deptId" => $dept);
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("inpatient_room");
        $data = $m->get($id);
        return $data;
    }

}