<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\facade\View;
use think\Db;

class Waitpatient extends BaseLogic
{
    public $alias = "待接诊病人";
    protected $fields = array("id" => "挂号编号", "name" => "病人名字", "room" => "诊室");
    protected $textFields = [];
    protected $optFields = [];

    public function prepareRows()
    {
        $rows = Db::view('registration','id')
            ->view('arrangement','room','arrangement.id = registration.arrId')
            ->view('patient','name','patient.id = registration.patId')
            ->where([['arrangement.drId','=',Auth::getAccount()],
                ['registration.id','NOT EXISTS',function ($query) {
                    $query->table('prescription')->where('rId','registration.id');
                }]])
            ->select();
        return $rows;
    }

    public function prepareOpts() {

    }

    public function loadEdit()
    {

    }

    public function prepareData($id)
    {

    }
}