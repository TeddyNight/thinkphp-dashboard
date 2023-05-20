<?php
namespace app\common;

use think\Model;
use think\facade\View;

interface UserLogic
{
    public function findAccount($account);
}