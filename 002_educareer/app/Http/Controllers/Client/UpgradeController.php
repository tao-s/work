<?php namespace App\Http\Controllers\Client;

use DB;
use Log;
use Mail;
use Auth;
use Config;
use View;
use App\Http\Controllers\Controller;
use App\Custom\FlashMessage;
use App\Admin;
use App\Upgrade;
use App\Http\Requests;
use App\Http\Requests\Client\StoreUpgradeRequest;

class UpgradeController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'upgrade');
    }

    public function index()
    {
        $client_id = Auth::client()->get()->client_id;
        $upgrade = Upgrade::where('client_id', $client_id)->first();
        $flash = new FlashMessage();

        if ($upgrade) {
            $flash->type('danger');
            $flash->message("既に有料プランの申請を行っています。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $prefectures = Config::get('prefecture');
        return view('client.upgrade.index')->with(compact('prefectures'));
    }

    public function store(StoreUpgradeRequest $req)
    {
        $upgrade = new Upgrade();
        $upgrade->plan_id = $req->plan_id;
        $upgrade->company_name = $req->company_name;
        $upgrade->client_id = Auth::client()->get()->client_id;
        $upgrade->ceo = $req->ceo;
        $upgrade->post_code = $req->post_code;
        $upgrade->address = $req->address;
        $ret = $upgrade->save();

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("有料プランの申請に失敗しました。システム運営者にお問い合わせ下さい。");
            return redirect('/upgrade')->with('flash_msg', $flash);
        }

        // @mail アップグレード申請完了のお知らせ to Client
        $rep = Auth::client()->get();
        $upgrade->load('client');
        $data = ['company_name' => $upgrade->client->company_name];
        Mail::queue(['text' => 'emails.client.upgrade_applied'], $data, function ($message) use ($rep) {
            $message->from('info@education-career.jp')
                ->to($rep->email)
                ->subject('【Education Career】アップグレードの申し込みありがとうございます');
        });
        // @mail アップグレード申請完了のお知らせ to Admin
        $data = ['client' => $upgrade->client, 'upgrade' => $upgrade];
        $emails = Admin::getAllAdminEmails();
        Mail::queue(['text' => 'emails.admin.upgrade_applied'], $data, function ($message) use ($emails) {
            $message->from('info@education-career.jp')
                ->to($emails)
                ->subject('【Education Career】クライアントからアップグレードの申し込みがありました');
        });

        $flash->type('success');
        $flash->message("有料プランを申請しました。引き続き求人を作成することが可能になります。");
        return redirect('/posting')->with('flash_msg', $flash);
    }
}