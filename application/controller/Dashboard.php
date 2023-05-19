<?php
namespace app\controller;
use think\Controller;
use app\model\Hospital;
use app\common\BaseController;
use app\model\Department;
use app\model\Doctor;

class Dashboard extends BaseController
{
    public function index() 
    {
        $this->prepare();
        return $this->fetch('index');
    }

    public function list($type) 
    {
        $title = "";
        $m = model($type,"logic");
        $m->loadFields();

        $this->assign("title",$m->name);
        $this->assign("type",$type);

        $this->prepare();
        return $this->fetch("list");
    }

    public function new($type)
    {
        $m = model($type,"logic");
        $m->loadFields();
        $m->loadOpts();
        $this->prepare();

        $this->assign("title","添加$m->name");
        $this->assign("type",$type);
        return $this->fetch("edit");
    }

    public function edit($type,$id)
    {
        $m = model($type,"logic");
        $m->loadFields();
        $m->loadOpts();
        $m->loadData($id);
        $this->prepare();

        $this->assign("title","修改$m->name");
        $this->assign("type",$type);
        return $this->fetch("edit");
    }

    public function delete($type,$id)
    {
        $m = model($type);
        $m->destroy($id);
        return $this->success('删除成功',"/index.php/dashboard/list/type/$type");
    }

    public function doNew($type) {
        $vaildator = $this->validate($_POST,$type);
        if(true !== $vaildator){
            return $this->error($vaildator);
        }
        $m = model($type);
        $m->allowField(true)->save($_POST);
        return $this->success('添加成功',"/index.php/dashboard/list/type/$type");
    }

    public function doEdit($type) {
        $vaildator = $this->validate($_POST,$type);
        if(true !== $vaildator){
            return $this->error($vaildator);
        }
        $m = model($type);
        $m->allowField(true)->isUpdate(true)->save($_POST);
        return $this->success('修改成功',"/index.php/dashboard/list/type/$type");
    }

}
