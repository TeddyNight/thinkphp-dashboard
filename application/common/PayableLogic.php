<?php
namespace app\common;

use think\Model;
use think\facade\View;

interface PayableLogic
{
    public function getTotal($id);
}