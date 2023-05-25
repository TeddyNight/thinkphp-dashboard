<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use think\facade\Request;
use think\facade\View;
use app\common\Auth;
use app\common\PayableLogic;
use think\Db;

class Treatment extends BaseLogic implements PayableLogic
{
    public $alias = "诊疗方案";
    protected $fields = array("id" => "编号", "doctor" => "医生", "patient" => "病人", "create_time" => "创建时间");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $role = Auth::getRole();
        $account = Auth::getAccount();
        if ($role == "admin") {
            $rows = Db::query("SELECT t.id, d.name doctor, p.name patient, t.create_time, t.payId
                            FROM treatment t
                            INNER JOIN inpatient_file f
                            INNER JOIN doctor d
                            INNER JOIN patient p
                            ON (t.fId = f.id AND f.drId = d.id AND f.pId = p.id)");
        }
        else if ($role == "patient") {
            $rows = Db::query("SELECT t.id, d.name doctor, p.name patient, t.create_time, t.payId
                            FROM treatment t
                            INNER JOIN inpatient_file f
                            INNER JOIN doctor d
                            INNER JOIN patient p
                            ON (t.fId = f.id AND f.drId = d.id AND f.pId = p.id)
                            WHERE p.id = $account");
        }
        else if ($role == "doctor") {
            $rows = Db::query("SELECT t.id, d.name doctor, p.name patient, t.create_time, t.payId
                            FROM treatment t
                            INNER JOIN inpatient_file f
                            INNER JOIN doctor d
                            INNER JOIN patient p
                            ON (t.fId = f.id AND f.drId = d.id AND f.pId = p.id)
                            WHERE d.id = $account");
        }
        return $rows;
    }

    public function prepareOpts()
    {
        $role = Auth::getRole();
        $account = Auth::getAccount();
        if ($role == "doctor") {
            $files = model("inpatient_file")
                    ->with("patient")
                    ->where("drId",$account)
                    ->select()
                    ->bindAttr("patient",["patient" => "name"]);
        }
        View::share("files",$files);
    }

    public function prepareData($id)
    {
        $m = model("treatment");
        return $m->where('id',$id)->find();
    }

    public function doCreate() {
        $this->allowField(true)->save($_POST);
        $tId = $this->id;
        $medicine = array_count_values($_POST["medicine"]);
        $mList = [];
        foreach ($medicine as $mId => $num) {
            $tmp = array('tId' => $tId, 'mId' => $mId, 'num' => $num);
            array_push($mList,$tmp);
        }
        $m = model("InpatientMedicine");
        $m->saveAll($mList);
    }

    public function doUpdate() {
        // Not allow to update here..
    }

    public function loadDetail($id) {
        $data = Db::query("SELECT t.id,t.create_time,d.name doctor,p.name patient,t.description `description`, t.payId
        FROM treatment t 
        INNER JOIN inpatient_file f
        INNER JOIN doctor d
        INNER JOIN patient p
        ON (t.fId = f.id AND f.drId = d.id AND f.pId = p.id)
        WHERE t.id = $id LIMIT 1")[0];
        View::share("data",$data);
        $medicines = Db::query("SELECT m.name, m.price, mlist.num, m.usage
        FROM inpatient_medicine mlist
        INNER JOIN medicine m
        ON (mlist.mId = m.id)
        WHERE mlist.tId = $id");
        View::share("medicines",$medicines);
        View::share("total",$this->getTotal($id));
        View::share("bedPrice",$this->bedPrice($id));
        View::share("medicineTotal",$this->medicineTotal($id));
    }

    private function bedPrice($id)
    {
        return Db::query("SELECT inpatient_room.price FROM inpatient_room
            INNER JOIN treatment
            INNER JOIN inpatient_file
            ON (treatment.fId = inpatient_file.id
                AND inpatient_file.rId = inpatient_room.id)
            WHERE treatment.id = $id
            LIMIT 1
            ")[0]["price"];
    }

    private function medicineTotal($id)
    {
        return Db::query("SELECT SUM(medicine.price) total
            FROM inpatient_medicine
            INNER JOIN medicine
            ON (inpatient_medicine.mId = medicine.id)
            WHERE inpatient_medicine.tId = $id
            ")[0]["total"];   
    }
    
    public function getTotal($id)
    {
        return $this->bedPrice($id)+$this->medicineTotal($id);
    }
    
}