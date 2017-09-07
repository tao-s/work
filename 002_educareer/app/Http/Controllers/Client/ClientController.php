<?php namespace App\Http\Controllers\Client;

use Auth;
use View;
use App\Client;
use App\Http\Requests;
use App\Custom\FlashMessage;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'company');
    }

    public function edit($id)
    {
        if ($id != Auth::client()->get()->client_id)
        {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message("権限のないページにアクセスしました。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $client = Client::find($id);
        return view('client.client.edit')->with(compact('client'));
    }

    public function update(UpdateClientRequest $req, $id)
    {
        $client = Client::find($id);
        $client->company_name = $req->input('company_name');
        $client->company_id = $req->input('company_id');
        $client->url = $req->input('url');
        $ret = $client->save();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("会社情報の更新に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("会社情報の更新に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

}
