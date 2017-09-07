<?php namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Mail;
use View;
use App\Http\Controllers\Controller;
use App\Custom\FlashMessage;
use Carbon\Carbon;
use App\Client;
use App\ClientRep;
use App\ClientRepConfirmation;
use App\Http\Requests;
use App\Http\Requests\Admin\StoreClientRepRequest;
use App\Http\Requests\Admin\PasswordConfirmRequest;
use App\Http\Requests\Admin\UpdateClientRepRequest;

class ClientRepController extends Controller {

    public function __construct()
    {
        View::share('module_key', 'client_rep');
    }

    public function index()
	{
        $clients = Client::all();
        $client_reps = ClientRep::paginate(10);
        return view('admin.client_rep.index')->with(compact('clients', 'client_reps'));
    }

	public function store(StoreClientRepRequest $req)
	{
        $client_rep = new ClientRep();
        $client_rep->email = $req->input('email');
        $client_rep->client_id = $req->input('client_id');

        $flash = new FlashMessage();
        if (!$client_rep->save()) {
            $flash->type('danger');
            $flash->message('クライアント担当者の登録に失敗しました。システム管理者にお問い合わせ下さい。');
            return redirect('/client_rep')->with('flash_msg', $flash);
        }

        $crConfirm = new ClientRepConfirmation();
        $crConfirm->client_rep_id = $client_rep->id;
        $crConfirm->saveWithOnetimeUrl();

        $data = ['confirmation_url' => route('client.confirm') . '/' . $crConfirm->confirmation_token];
        // @mail クライアント担当者作成
        Mail::queue(['text' => 'emails.client.create_client_rep'], $data, function ($message) use ($client_rep) {
            $message->from('info@education-career.jp')
                ->to($client_rep->email)
                ->subject('【Education Career】仮登録のお知らせ');
        });

        $flash->type('success');
        $flash->message("{$client_rep->company_name} {$client_rep->email} に登録用メールを送信しました。");
        return redirect('/client_rep')->with('flash_msg', $flash);
	}

    public function checkUrl($token)
    {
        if (!$conf = ClientRepConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        return view('admin.client_rep.create_confirm')->with('token', $conf->confirmation_token);
    }

    public function confirm(PasswordConfirmRequest $req)
    {
        $flash = new FlashMessage();

        DB::beginTransaction();
        try {
            $conf = ClientRepConfirmation::where('confirmation_token', $req->input('token'))->first();
            $conf->confirmed_at = Carbon::now()->setTimezone('jst');
            $conf->save();

            $client_rep = ClientRep::where('id', $conf->client_rep_id)->first();
            $client_rep->password = bcrypt($req->input('password'));
            $client_rep->save();
        } catch (RuntimeException $e) {
            DB::rollBack();

            $flash->type('danger');
            $flash->message('パスワードの設定に失敗しました。システム管理者にお問い合わせ下さい。');

            Log::alert('クライアント担当者のパスワード設定に失敗', ['StackTrace' => $e->getTraceAsString()]);
            return redirect('/login')->with('flash_msg', $flash);
        }
        DB::commit();

        $flash->type('success');
        $flash->message('パスワードの設定が完了しました。');
        return redirect('/client_rep')->with('flash_msg', $flash);
    }


    public function edit($id)
	{
        $clients = Client::all();
        $client_rep = ClientRep::find($id);
        return view('admin.client_rep.edit')->with(compact('clients', 'client_rep'));
	}

	public function update(UpdateClientRepRequest $req, $id)
	{
        $client_rep = ClientRep::find($id);
        $client_rep->client_id = $req->input('client_id');
        $email = $client_rep->email;
        $ret = $client_rep->save();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("クライアント担当者 {$email} の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client_rep')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("クライアント担当者 {$email} の変更に成功しました。");
        return redirect('/client_rep')->with('flash_msg', $flash);
    }

	public function destroy($id)
	{
        $client_rep = ClientRep::find($id);
        $email = $client_rep->email;
        $ret = $client_rep->delete();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("クライアント担当者 {$email} の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client_rep')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("クライアント担当者 {$email} の削除に成功しました。");
        return redirect('/client_rep')->with('flash_msg', $flash);
    }

}
