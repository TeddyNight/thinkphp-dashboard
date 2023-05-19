<?php
namespace app\controller;
use think\Controller;
use app\common\BaseController;

class Table extends BaseController
{

    public function getData() {
        $this->assign("rows",[['a'],['b']]);
        $this->assign("fields",['a']);
    }

    public function show($type) {
        $this->prepare();
        $this->getData();
        return $this->fetch("table");
    }

}
