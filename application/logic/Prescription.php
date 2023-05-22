<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use think\facade\Request;
use app\common\Auth;
use think\Db;

class Prescription extends BaseLogic
{
    public $alias = "处方";
    protected $fields = array("id" => "编号", "doctor" => "医生", "patient" => "病人", "create_time" => "创建时间");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $role = Auth::getRole();
        $account = Auth::getAccount();
        if ($role == "admin") {
            $m = model("prescription");
            $rows = $m->all();
        }
        else if ($role == "patient") {
            $rows = Db::view('prescription','id')
            ->where([['rId','IN',function($query) {
                $query->table('registration')->where('patId',$account);
            }]])
            ->select();
        }
        else if ($role == "doctor") {
            $rows = Db::query("SELECT p.id,p.create_time,d.name doctor,pat.name patient FROM prescription p 
                INNER JOIN registration r
                INNER JOIN arrangement a
                INNER JOIN doctor d
                INNER JOIN patient pat
                ON (p.rId = r.id AND r.arrId = a.id AND a.drId = d.id AND r.patId = pat.id)
                WHERE a.drId = $account");
        }
        return $rows;
    }

    public function prepareOpts()
    {
        $opts = [];
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("department");
        return $m->where('id',$id)->find();
    }

    public function doSave() {
        $this->allowField(true)->save($_POST);
        $pId = $this->id;
        $medicine = array_count_values($_POST["medicine"]);
        $mList = [];
        foreach ($medicine as $mId => $num) {
            $tmp = array('pId' => $pId, 'mId' => $mId, 'num' => $num);
            array_push($mList,$tmp);
        }
        $m = model("medicineList");
        $m->saveAll($mList);
    }

    public function doUpdate() {
        // Not allow to update here..
    }

}