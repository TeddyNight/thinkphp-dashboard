<?php
namespace app\logic;

use think\Model;
use app\common\BaseLogic;
use app\common\Auth;
use think\Db;

class ClinicRoom extends BaseLogic
{
    public $alias = "住院部病房";
    protected $fields = array("id" => "房间号");
    protected $textFields = array("id" => "房间号");
    protected $optFields = array();

    public function prepareRows()
    {
        $rows = model('clinic_room')
            ->all();
        return $rows;
    }

    public function prepareOpts()
    {
        $opts = [];
        return $opts;
    }

    public function prepareData($id)
    {
        $m = model("clinic_room");
        $data = $m->get($id);
        return $data;
    }

}