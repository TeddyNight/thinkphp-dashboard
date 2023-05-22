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

        $permission = ["doctor" => ["list" => ["arrangement","patient"], "update" => [], "new" => [], "delete" => []],
                "admin" => ["list" => ["all"], "create" => ["all"], "update" => ["all"], "delete" => ["all"]],
                "patient" => ["list" => ["registration"], "create" => ["registration"], "update" => [], "delete" => []]
            ];
        $type = Request::param('type');
        $role = Auth::getRole();
        $action = request()->action();
        if ($action == "index") {
            
        }
        else if (isset($permission[$role][$action]) && 
            (in_array("all", $permission[$role][$action]) || in_array($type, $permission[$role][$action]))) {
                if ($action == "list") {
                    $this->assign("creatable",in_array("all", $permission[$role]["create"]) || in_array($type, $permission[$role]["create"]));
                    $this->assign("deletable",in_array("all", $permission[$role]["delete"]) || in_array($type, $permission[$role]["delete"]));
                    $this->assign("updatable",in_array("all", $permission[$role]["update"]) || in_array($type, $permission[$role]["update"]));
                }
        }
        else {
            return $this->error("没有权限访问$action","/index.php/dashboard/index");
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
        $m->loadList();

        $this->assign("title",$m->name);
        $this->assign("type",$type);

        return $this->fetch("dashboard/list/$type");
    }

    public function create($type)
    {
        if (Request::instance()->isPost()) {
            $vaildator = $this->validate($_POST,$type);
            if(true !== $vaildator){
                return $this->error($vaildator);
            }
            $m = model($type);
            $m->allowField(true)->save($_POST);
            return $this->success('添加成功',"/index.php/dashboard/list/type/$type");
        }

        $m = model($type,"logic");
        $m->loadEdit();

        $this->assign("title","添加$m->name");
        $this->assign("type",$type);
        return $this->fetch("dashboard/edit/$type");
    }

    public function update($type,$id)
    {
        if (Request::instance()->isPost()) {
            $vaildator = $this->validate($_POST,$type);
            if(true !== $vaildator){
                return $this->error($vaildator);
            }
            $m = model($type);
            $m->allowField(true)->isUpdate(true)->save($_POST);
            return $this->success('修改成功',"/index.php/dashboard/list/type/$type");
        }

        $m = model($type,"logic");
        $m->loadEdit();
        $m->loadData($id);

        $this->assign("title","修改$m->name");
        $this->assign("type",$type);
        return $this->fetch("dashboard/edit/$type");
    }

    public function delete($type,$id)
    {
        $m = model($type);
        $m->destroy($id);
        return $this->success('删除成功',"/index.php/dashboard/list/type/$type");
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
                "病人管理" => url('dashboard/list','type=patient'),
            );
        }
        else if ($role == "doctor") {
            $sidebar = array(
                "首页" => url('dashboard/index'),
                "排班情况" => url('dashboard/list','type=arrangement'),
                "待接诊病人" => url('dashboard/list','type=patient')
            );
        }
        else if ($role == "patient") {
            $sidebar = array(
                "首页" => url('dashboard/index'),
                "挂号" => url('dashboard/list','type=registration'),
            );
        }
        $this->assign("role",$role);
        $this->assign("account",Auth::getAccount());
        $this->assign("sidebar",$sidebar);
    }

}
