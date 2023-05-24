<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;
use think\facade\View;
use think\facade\Request;

class InpatientBed extends BaseLogic
{
    public $alias = "住院部病床";
    protected $fields = array("rId" => "病房号", "bId" => "病床号", "patient" => "病人");
    protected $textFields = array("bId" => "病床号");
    protected $optFields = array("rId" => "病房号");

    public function prepareRows()
    {
        $rows = Db::query("SELECT b.rId, b.bId, p.name patient
                FROM inpatient_bed b
                LEFT JOIN (
                    inpatient_file f INNER JOIN patient p ON (f.pId = p.id)
                )
                ON (b.rId = f.rId AND b.bId = f.bId)");
        return $rows;
    }

    public function prepareOpts()
    {
        $depts = model('inpatient_department')
                ->with('inpatient_room')
                ->all();
        $rooms = model('inpatient_room')->with('inpatient_bed')->all();
        View::share("depts",$depts);
        View::share("rooms",$rooms);
    }

    public function prepareData($id)
    {

    }

    public function doDelete() {
        $this->where('rId',Request::param('rId'))
            ->where('bId',Request::param('bId'))
            ->delete();
    }

}