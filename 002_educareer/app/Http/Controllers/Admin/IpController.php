<?php namespace App\Http\Controllers\Admin;

use Psy\Test\CodeCleaner\ImplicitReturnPassTest;
use View;
use App\Custom\FlashMessage;
use App\IpAddress;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreIpRequest;

class IpController extends Controller
{
    public function __construct()
    {
        View::share('module_key', 'ip');
    }

    public function create()
    {
        $ips = IpAddress::all();
        $my_ip = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $my_ip = getenv('HTTP_CLIENT_IP');
        } else if(getenv('HTTP_X_FORWARDED_FOR')) {
            $my_ip = getenv('HTTP_X_FORWARDED_FOR');
        } else if(getenv('HTTP_X_FORWARDED')) {
            $my_ip = getenv('HTTP_X_FORWARDED');
        } else if(getenv('HTTP_FORWARDED_FOR')) {
            $my_ip = getenv('HTTP_FORWARDED_FOR');
        } else if(getenv('HTTP_FORWARDED')) {
            $my_ip = getenv('HTTP_FORWARDED');
        } else if(getenv('REMOTE_ADDR')) {
            $my_ip = getenv('REMOTE_ADDR');
        } else {
            $my_ip = 'UNKNOWN';
        }

        return view('admin.ip.create')->with(compact('ips', 'my_ip'));
    }


    public function store(StoreIpRequest $req)
    {
        $ips = array();
        foreach ($req->ip as $val) {
            $ips[]['ip'] = $val;
        }
        IpAddress::truncate();
        $ret = IpAddress::insert($ips);

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('success');
            $flash->message('IPアドレスの許可設定に失敗しました。');
        }

        $flash->type('success');
        $flash->message('IPアドレスの許可設定に成功しました。');
        return redirect('/ip')->with('flash_msg', $flash);
    }
}
