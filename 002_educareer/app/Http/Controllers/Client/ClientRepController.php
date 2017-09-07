<?php namespace App\Http\Controllers\Client;

use DB;
use Log;
use Mail;
use Auth;
use View;
use App\Http\Controllers\Controller;
use App\Custom\FlashMessage;
use Carbon\Carbon;
use App\ClientRep;
use App\ClientRepConfirmation;
use App\Http\Requests\Client\StoreClientRepRequest;
use App\Http\Requests\Client\PasswordConfirmRequest;
use App\Http\Requests\Client\UpdateClientRepRequest;
use App\Http\Requests\Client\UpdateClientRepPasswordRequest;

class ClientRepController extends Controller {

    public function __construct()
    {
        View::share('module_key', 'client_rep');
    }

    public function index()
	{
        $client_id = Auth::client()->get()->client_id;
        $client_reps = ClientRep::where('client_id', $client_id)->paginate(10);
        return view('client.client_rep.index')->with(compact('clients', 'client_reps'));
    }

	public function store(StoreClientRepRequest $req)
	{
        $client_rep = new ClientRep();
        $client_rep->email = $req->input('email');
        $client_rep->client_id = Auth::client()->get()->client_id;

        $flash = new FlashMessage();
        if (!$client_rep->save()) {
            $flash->type('danger');
            $flash->message('担当者の登録に失敗しました。システム管理者にお問い合わせ下さい。');
            return redirect('/rep')->with('flash_msg', $flash);
        }

        $confirm = new ClientRepConfirmation();
        $confirm->client_rep_id = $client_rep->id;
        $confirm->saveWithOnetimeUrl();

        $data = ['confirmation_url' => url('/rep/confirm/' . $confirm->confirmation_token)];
        // @mail クライアント担当者新規作成メール to Client
        Mail::queue(['text' => 'emails.client.create_client_rep'], $data, function ($message) use ($client_rep) {
            $message->from('info@education-career.jp')
                ->to($client_rep->email)
                ->subject('【Education Career】仮登録のお知らせ');
        });

        $flash->type('success');
        $flash->message("{$client_rep->company_name} {$client_rep->email} に登録用メールを送信しました。");
        return redirect('/rep')->with('flash_msg', $flash);
	}

    public function checkUrl($token)
    {
        if (!$conf = ClientRepConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        return view('client.client_rep.create_confirm')->with('token', $conf->confirmation_token);
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

            Log::alert('担当者のパスワード設定に失敗', ['StackTrace' => $e->getTraceAsString()]);
            return redirect('/login')->with('flash_msg', $flash);
        }
        DB::commit();

        Auth::client()->logout();
        Auth::client()->loginUsingId($client_rep->id);

        $flash->type('success');
        $flash->message('パスワードの設定が完了しました。');
        return redirect('/rep')->with('flash_msg', $flash);
    }


    public function edit($id)
	{
        $client_rep = ClientRep::find($id);
        if (!$client_rep || $client_rep->client_id != Auth::client()->get()->client_id)
        {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message("権限のないページにアクセスしました。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $client_rep = ClientRep::find($id);
        return view('client.client_rep.edit')->with(compact('client_rep'));
	}

	public function update(UpdateClientRepRequest $req, $id)
	{
        $client_rep = ClientRep::where('id', $id)->first();
        $client_rep->email = $req->email;
        $client_rep->name = $req->name;
        $email = $client_rep->email;
        $ret = $client_rep->save();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("担当者 {$email} の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client_rep')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("担当者 {$email} の変更に成功しました。");
        return redirect('/rep')->with('flash_msg', $flash);
    }

    public function reset_password($id)
    {
        $client_rep = ClientRep::where('id', $id)->first();
        if (!$client_rep) {
            abort(404);
        }

        return view('client.client_rep.reset_password')->with(compact('client_rep'));
    }

    public function update_password(UpdateClientRepPasswordRequest $req)
    {
        $client_rep = ClientRep::where('id', $req->client_rep_id)->first();

        $flash = new FlashMessage();
        if (!$client_rep) {
            $flash->type('danger');
            $flash->message("不正なアクセスを検知しました。ページをリロードしてもう一度操作を行ってください。");
            return redirect('/client_rep')->with('flash_msg', $flash);
        }

        $client_rep->password = bcrypt($req->password);
        $ret = $client_rep->save();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("担当者 {$client_rep->email} のパスワード変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/client_rep')->with('flash_msg', $flash);
        }

        // @mail パスワード変更のお知らせ to Client
        $data = ['client_rep' => $client_rep];
        Mail::queue(['text' => 'emails.client.password_updated'], $data, function ($message) use ($client_rep) {
            $message->from('info@education-career.jp')
                ->to($client_rep->email)
                ->subject('【Education Career】パスワードが変更されました');
        });

        $flash->type('success');
        $flash->message("担当者 {$client_rep->email} のパスワード変更に成功しました。");
        return redirect('/rep')->with('flash_msg', $flash);
    }

	public function destroy($id)
	{
        $client_rep = ClientRep::find($id);
        $email = $client_rep->email;
        $ret = $client_rep->delete();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("担当者 {$email} の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/rep')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("担当者 {$email} の削除に成功しました。");
        return redirect('/rep')->with('flash_msg', $flash);
    }

}
