<?php
namespace app\common;
use think\Controller;

class UserBaseController extends BaseController
{
    protected $role;

    /*
    public function __construct($role) {
        $this->role = $role;
    }
     */

    protected function prepare() {
        parent::prepare();
        $this->assign('role',$this->role);
    }

    public function login() {
        $this->prepare();
        return $this->fetch('login');
    }

    public function doLogin() {
        $account = input('post.account');
        $passwd = input('post.passwd');
        $ret = array('ok' => false, 'msg' => '');
        if (empty($account)) {
            $ret['msg'] = "用户名不能为空";
            return $ret;
        }
        if (empty($passwd)) {
            $ret['msg'] = "密码不能为空";
            return $ret;
        }
        $res = db($this->role)->where('account',$account)->find();
        if ($res == NULL) {
            $ret['msg'] = "用户不存在";
            return $ret;
        }
        if ($res['passwd'] != md5($passwd)) {
            $ret['msg'] = "密码错误";
            return $ret;
        }
        $ret['ok'] = true;
        return json($ret);
    }

}
