<?php
namespace app\controller;
use think\Controller;
use think\facade\Request;
use app\model\Hospital;
use app\common\BaseController;
use app\model\Department;
use app\model\Doctor;
use app\common\Auth;

class Dashboard extends BaseController
{
    protected $beforeActionList = [
        'checkPermission',
        'prepare',
    ];

    public function checkPermission()
    {
        if (!Auth::isLogin())
        {
            return $this->error("请先登录","/index.php/user/login");
        }

        $permission = ["doctor" => ["list" => ["arrangement"], "edit" => []],
                "admin" => ["list" => ["all"], "edit" => ["all"]]
            ];
        $type = Request::param('type');
        $role = Auth::getRole();
        $action = request()->action();
        if ($action == "index") {
            
        }
        else if (isset($permission[$role][$action]) && 
            (in_array("all", $permission[$role][$action]) || in_array($type, $permission[$role][$action]))) {
                if (isset($permission[$role]["edit"]) && 
                (in_array("all", $permission[$role]["edit"]) || in_array($type, $permission[$role]["edit"]))) {
                    $this->assign("editable",true);
                }
                else {
                    $this->assign("editable",false);
                }
        }
        else if (isset($permission[$role]["edit"]) && 
            (in_array("all", $permission[$role]["edit"]) || in_array($type, $permission[$role]["edit"]))) {
            
        }
        else {
            return $this->error("没有权限访问","/index.php/dashboard/index");
        }
    }

    public function index() 
    {
        return $this->fetch('index');
    }

    public function list($type) 
    {
        $title = "";
        $m = model($type,"logic");
        $m->loadFields();
        $m->loadRows();

        $this->assign("title",$m->name);
        $this->assign("type",$type);

        return $this->fetch("list");
    }

    public function new($type)
    {
        $m = model($type,"logic");
        $m->loadFields();
        $m->loadOpts();

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

    protected function prepare() {
        parent::prepare();
        $role = Auth::getRole();
        if ($role == "admin") {
            $sidebar = array(
                "首页" => url('dashboard/index'),
                "医院管理" => "",
                "科室管理" => url('dashboard/list','type=department'),
                "医生管理" => url('dashboard/list','type=doctor'),
                "排班管理" => url('dashboard/list','type=arrangement'),
            );
        }
        else if ($role == "doctor") {
            $sidebar = array(
                "首页" => url('dashboard/index'),
                "排班情况" => url('dashboard/list','type=arrangement'),
            );
        }
        $this->assign("role",$role);
        $this->assign("account",Auth::getAccount());
        $this->assign("sidebar",$sidebar);
    }

}
