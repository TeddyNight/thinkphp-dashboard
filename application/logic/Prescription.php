<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use think\facade\Request;
use think\facade\View;
use app\common\Auth;
use app\common\PayableLogic;
use think\Db;

class Prescription extends BaseLogic implements PayableLogic
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
            $rows = Db::query("SELECT p.id,p.create_time,d.name doctor,pat.name patient,p.payId FROM prescription p 
                INNER JOIN registration r
                INNER JOIN clinic_arrangement a
                INNER JOIN doctor d
                INNER JOIN patient pat
                ON (p.rId = r.id AND r.aId = a.id AND a.drId = d.id AND r.pId = pat.id)");
        }
        else if ($role == "patient") {
            $rows = Db::query("SELECT p.id,p.create_time,d.name doctor,pat.name patient,p.payId FROM prescription p 
                INNER JOIN registration r
                INNER JOIN clinic_arrangement a
                INNER JOIN doctor d
                INNER JOIN patient pat
                ON (p.rId = r.id AND r.aId = a.id AND a.drId = d.id AND r.pId = pat.id)
                WHERE pat.id = $account");
        }
        else if ($role == "doctor") {
            $rows = Db::query("SELECT p.id,p.create_time,d.name doctor,pat.name patient,p.payId FROM prescription p 
                INNER JOIN registration r
                INNER JOIN clinic_arrangement a
                INNER JOIN doctor d
                INNER JOIN patient pat
                ON (p.rId = r.id AND r.aId = a.id AND a.drId = d.id AND r.pId = pat.id)
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

    public function doCreate() {
        $this->allowField(true)->save($_POST);
        $pId = $this->id;
        $medicine = array_count_values($_POST["medicine"]);
        $mList = [];
        foreach ($medicine as $mId => $num) {
            $tmp = array('pId' => $pId, 'mId' => $mId, 'num' => $num);
            array_push($mList,$tmp);
        }
        $m = model("ClinicMedicine");
        $m->saveAll($mList);
    }

    public function doUpdate() {
        // Not allow to update here..
    }

    public function loadDetail($id) {
        $data = Db::query("SELECT p.id,p.create_time,d.name doctor,pat.name patient,p.description `description`, p.payId
        FROM prescription p 
        INNER JOIN registration r
        INNER JOIN clinic_arrangement a
        INNER JOIN doctor d
        INNER JOIN patient pat
        ON (p.rId = r.id AND r.aId = a.id AND a.drId = d.id AND r.pId = pat.id)
        WHERE p.id = $id LIMIT 1")[0];
        View::share("data",$data);
        $medicines = Db::query("SELECT m.name, m.price, mlist.num, m.usage
        FROM clinic_medicine mlist
        INNER JOIN medicine m
        ON (mlist.mId = m.id)
        WHERE mlist.pId = $id");
        View::share("medicines",$medicines);
        View::share("total",$this->getTotal($id));
        View::share("doctorPrice",$this->doctorPrice($id));
        View::share("medicineTotal",$this->medicineTotal($id));
    }

    private function doctorPrice($id)
    {
        return Db::query("SELECT doctor_title.price price FROM doctor_title
            INNER JOIN doctor
            INNER JOIN clinic_arrangement
            INNER JOIN prescription
            INNER JOIN registration
            ON (doctor.title = doctor_title.name 
                AND clinic_arrangement.drId = doctor.id
                AND prescription.rId = registration.id
                AND registration.aId = clinic_arrangement.id)
            LIMIT 1
            ")[0]["price"];
    }

    private function medicineTotal($id)
    {
        return Db::query("SELECT SUM(medicine.price*clinic_medicine.num) total
            FROM clinic_medicine
            INNER JOIN medicine
            ON (clinic_medicine.mId = medicine.id)
            WHERE clinic_medicine.pId = $id
            ")[0]["total"];   
    }
    
    public function getTotal($id)
    {
        return $this->doctorPrice($id)+$this->medicineTotal($id);
    }

    public function loadList() {
        View::share('title','就诊记录—处方');
        $this->loadFields();
        $this->loadRows();
    }
}