<?php
namespace app\controller;
use think\Controller;
use app\common\BaseController;
use app\common\Auth;

class User extends BaseController
{

    public function login($role = "admin") {
        $this->prepare();
        $this->assign('role',$role);
        return $this->fetch('login');
    }

    public function doLogin($role) {
        $ret = array('ok' => false, 'msg' => '');
        $vaildator = $this->validate($_POST,"user");
        if(true !== $vaildator){
            $ret['msg'] = $vaildator;
            return json($ret);
        }
        $account = input('post.account');
        $passwd = input('post.passwd');

        $m = model($role,"logic");
        $res = $m->findAccount($account);
        if ($res == NULL) {
            $ret['msg'] = "用户不存在";
        }
        else if ($res['passwd'] != md5($passwd)) {
            $ret['msg'] = "密码错误";
        }
        else {
            $ret['ok'] = true;
            Auth::login($res["id"],$role);
        }
        return json($ret);
    }

    public function doRegister($role) {
        $ret = array('ok' => false, 'msg' => '');
        $vaildator = $this->validate($_POST,$role);
        if(true !== $vaildator){
            $ret['msg'] = $vaildator;
            return json($ret);
        }
        $m = model($role,"logic");
        $m->doCreate();
        $ret['ok'] = true;
        return json($ret);
    }

    public function logout() {
        Auth::logout();
        return $this->success("注销成功");
    }

    public function register()
    {
        $this->prepare();
        $this->assign('role',"patient");
        return $this->fetch('register');
    }

}
