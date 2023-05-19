<?php
namespace app\controller;
use think\Controller;
use app\model\Hospital;
use app\common\UserBaseController;

class Admin extends UserBaseController
{
    protected $role = "admin";

    public function hospital_info()
    {
        $this->assign('hospital', Hospital::get(1));
        return $this->fetch('hospital_info');
    }

    public function list()
    {
        return $this->fetch('list');
    }

}
