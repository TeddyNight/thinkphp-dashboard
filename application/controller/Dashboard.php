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

        $permission = ["doctor" => ["list" => ["clinic_arrangement","wait_patient","medicine","prescription","treatment","inpatient_arrangement"], "update" => [], "create" => ["prescription","treatment"], "delete" => [], "detail" => ["prescription","treatment"]],
                "admin" => ["list" => ["all"], "create" => ["all"], "update" => ["all"], "delete" => ["all"], "detail" => ["all"]],
                "patient" => ["list" => ["registration","prescription","inpatient_file","treatment"], "create" => ["registration","inpatient_file"], "update" => [], "delete" => [], "detail" => ["prescription","treatment"]]
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
        $role = Auth::getRole();
        return $this->fetch("dashboard/index/$role");
    }

    public function list($type) 
    {
        if (Request::isAjax()) {
            $m = model($type, "logic");
            $rows = $m->prepareRows()->toArray();
            $results = array_map(function ($row) {
                return array("id" => $row["id"], "text" => $row["name"]);
            },$rows);
            $ret = array("results" => $results);
            return json($ret);
        }
        
        $m = model($type,"logic");
        $m->loadList();

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
            $m = model($type,"logic");
            $m->doCreate();
            return $this->success('添加成功',"/index.php/dashboard/list/type/$type");
        }

        $m = model($type,"logic");
        $m->loadEdit();

        $this->assign("title","添加$m->alias");
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
            $m = model($type,"logic");
            $m->doUpdate();
            return $this->success('修改成功',"/index.php/dashboard/list/type/$type");
        }

        $m = model($type,"logic");
        $m->loadEdit();
        $m->loadData($id);

        $this->assign("title","修改$m->alias");
        $this->assign("type",$type);
        return $this->fetch("dashboard/edit/$type");
    }

    public function delete($type)
    {
        $m = model($type,"logic");
        $m->doDelete();
        return $this->success('删除成功',"/index.php/dashboard/list/type/$type");
    }

    public function detail($type,$id)
    {
        $m = model($type,"logic");
        $m->loadDetail($id);
        $this->assign('title',$m->alias);
        $this->assign('type',$type);
        return $this->fetch("dashboard/detail/$type");
    }

    protected function prepare() {
        parent::prepare();
        $role = Auth::getRole();
        $this->assign("role",$role);
        $this->assign("account",Auth::getAccount());
    }

}
