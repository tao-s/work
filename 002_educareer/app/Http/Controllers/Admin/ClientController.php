<?php namespace App\Http\Controllers\Admin;

use App\Plan;
use DB;
use View;
use Auth;
use App\Job;
use App\Client;
use App\Upgrade;
use App\Http\Requests;
use App\Custom\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'client');
    }

    public function index()
    {
        $clients = Client::with('upgrade')->with('jobs.applications')->paginate(10);
        return view('admin.client.index')->with(compact('clients'));
    }

    public function create()
    {
        return view('admin.client.create')->with('plans', Plan::all());
    }

    public function store(StoreClientRequest $req)
    {
        /** @var Plan $plan */
        $plan = Plan::find($req->input('plan'));

        if (!$plan) {
            abort(404);
        }

        $client = DB::transaction(function() use($req, $plan) {
            $client = new Client();
            $client->company_name = $req->company_name;
            $client->company_id = $req->company_id;
            $client->url = $req->url;
            $ret1 = $client->save();

            if ($plan->price) {
                // 有料プランを設定する場合
                $upgrade = new Upgrade();
                $ret2 = $upgrade->saveWithPlanAndClient($plan, $client);
            } else {
                // 無料プランを設定する場合
                $ret2 = true;
            }

            if ($ret1 && $ret2) {
                return $client;
            }

            return null;
        });

        $flash = new FlashMessage();
        if (!$client) {
            $flash->type('danger');
            $flash->message("クライアント「{$client->company_name}」の登録に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("クライアント「{$client->company_name}」の登録に成功しました。");
        return redirect('/client')->with('flash_msg', $flash);
    }

    public function permit(Request $req, $id)
    {
        $client = Client::find($id);
        if ($req->get('permission') == '0') {
            $client->can_publish = 0;
            $action = '求人公開取消';
        } else {
            $client->can_publish = 1;
            $action = '求人公開承認';
        }
        $ret = DB::transaction(function() use($client) {
            $ret1 = true;
            if (!$client->can_publish && Job::where('client_id', $client->id)->first()) {
                $ret1 = Job::where('client_id', $client->id)->update(['main_slide_flag' => false, 'pickup_flag' => false]);
            }

            $ret2 = $client->save();

            return $ret1 && $ret2;
        });

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("クライアント「{$client->company_name}」の{$action}に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("クライアント「{$client->company_name}」の{$action}に成功しました。");
        return redirect('/client')->with('flash_msg', $flash);
    }

    public function edit($id)
    {
        $client = Client::with('upgrade')->whereId($id)->get()->first();

        if (!$client) {
            abort(404);
        }

        $plans = Plan::all();
        $selected_plan_id = isset($client->upgrade->plan_id) ? $client->upgrade->plan_id : null;

        return view('admin.client.edit')->with(compact('client', 'plans', 'selected_plan_id'));
    }

    public function update(UpdateClientRequest $req, $id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        /** @var Plan $plan */
        $plan = Plan::find($req->input('plan'));

        if (!$client || !$plan) {
            abort(404);
        }

        $result = DB::transaction(function() use($req, $client, $plan) {
            $client->company_name = $req->input('company_name');
            $client->company_id = $req->input('company_id');
            $client->url = $req->input('url');
            $client->can_publish = $req->input('permission') == 'on';

            /** @var Upgrade $upgrade */
            $upgrade = Upgrade::whereClientId($client->id)->get()->first();

            if ($plan->price) {
                // 有料プランを設定する場合
                if (!$upgrade) {
                    $upgrade = new Upgrade();
                }
                $upgradeResult = $upgrade->saveWithPlanAndClient($plan, $client, $req->input('plan_update'));
            } else {
                // 無料プランを設定する場合
                if ($upgrade instanceof Upgrade) {
                    $upgradeResult = $upgrade->delete();
                } else {
                    $upgradeResult = true;
                }
            }

            return $upgradeResult && $client->save();
        });

        if ($result) {
            return $this->success('/client', "クライアント {$client->company_name} の更新に成功しました。");
        } else {
            return $this->error('/client', "クライアント {$client->company_name} の更新に失敗しました。システム管理者にお問い合わせ下さい。");
        }
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $company_name = $client->company_name;
        $ret = $client->delete();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("クライアント「{$company_name}」の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("クライアント「{$company_name}」の削除に成功しました。");
        return redirect('/client')->with('flash_msg', $flash);
    }
}
