<?php
namespace app\common;
use think\Controller;
use app\model\Hospital;

class BaseController extends Controller
{
    protected function prepare() {
        $this->assign('hospital', Hospital::get(1));
    }

    public function index() {
        return $this->fetch('index');
    }

}
