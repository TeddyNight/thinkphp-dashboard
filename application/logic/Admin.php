<?php
namespace app\logic;

use think\Model;
use app\common\UserLogic;

class Admin extends Model implements UserLogic
{
    public function findAccount($account) {
        return db("admin")->where('account',$account)->find();
    }
}