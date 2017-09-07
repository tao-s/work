<?php namespace App\Http\Controllers\Admin;

use View;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Custom\FlashMessage;
use Illuminate\Http\Request;
use App\Upgrade;
use App\Job;

class UpgradeController extends Controller
{
    public function __construct()
    {
        View::share('module_key', 'client');
    }

    public function show($id)
    {
        $upgrade = Upgrade::where('id', $id)->with('client')->with('plan')->first();
        if (!$upgrade) {
            abort(404);
        }

        return view('admin.upgrade.show')->with(compact('upgrade'));
    }

    public function update(Request $req, $id)
    {
        $upgrade = Upgrade::where('id', $id)->first();
        if ($req->approved_flag == '1') {
            $upgrade->is_approved = 0;
            $upgrade->expire_date = null;
            $action = "取り消し";
        } else {
            $upgrade->is_approved = 1;
            $upgrade->expire_date = Carbon::today()->addMonths($upgrade->plan_months);
            $action = "承認";
        }

        $ret = $upgrade->save();

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("有料プラン申請の{$action}に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("有料プラン申請の{$action}に成功しました。");
        return redirect('/client')->with('flash_msg', $flash);
    }

    public function destroy($id)
    {
        $upgrade = Upgrade::with('client')->where('id', $id)->first();
        $company_name = $upgrade->client->company_name;
        $client_id = $upgrade->client->id;
        // @todo トランザクション
        Job::prepareFroFreePlan($client_id);
        $ret = $upgrade->delete();

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("クライアント {$company_name} の有料プラン申請却下に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client')->with('flash_msg', $flash);
        }

        //@todo メールでクライアントに通知
        $flash->type('success');
        $flash->message("クライアント {$company_name} の有料プラン申請却下に成功しました。");
        return redirect('/client')->with('flash_msg', $flash);
    }
}
