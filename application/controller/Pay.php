<?php
namespace app\controller;
use think\Controller;
use think\facade\Session;
use app\common\Auth;

// just a prototype..
class Pay extends Controller
{
    protected $beforeActionList = [
        'checkLogin' =>  ['except'=>'callBack'],
    ];

    public function index($type,$id)
    {
        // Pay Logic...
        $m = model($type,"logic")->get($id);
        if ($m->payId != null) {
            return $this->error("已支付");
        }

        $total = $m->getTotal($id);
        $payId = time();
        $msg = array("id" => $id, "type" => $type, "total" => $total);
        $this->callBack($payId, $msg);

        return $this->success('跳转支付页面',"/index.php/pay/afterPay/type/$type");
    }

    public function afterPay($type)
    {
        return $this->success('支付成功',"/index.php/dashboard/list/type/$type");
    }

    public function checkLogin()
    {
        if (!Auth::isLogin())
        {
            return $this->error("请先登录","/index.php/user/login");
        }
    }

    public function callBack($payId,$msg)
    {
        // may be check token first
        $type = $msg["type"];
        $id = $msg["id"];
        $total = $msg["total"];
        $payment = model("payment");
        $payment->save([
            'id'  =>  $payId,
            'total' =>  $total
        ]);

        $m = model($type)->get($id);
        $m->payId = $payId;
        $m->save();
    }

}
