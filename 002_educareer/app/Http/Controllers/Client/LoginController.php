<?php namespace App\Http\Controllers\Client;

use DB;
use Log;
use Mail;
use Auth;
use Carbon\Carbon;
use App\ClientRep;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClientRepConfirmation;
use App\Http\Requests\Client\ResetPasswordRequest;
use App\Http\Requests\Client\PasswordConfirmRequest;
use App\Custom\FlashMessage;

class LoginController extends Controller
{

    public function index()
    {
        if (Auth::client()->check()) {
            return redirect('/');
        }

        return view('client.login');
    }

    public function login(Request $req)
    {
        $credentials = $req->except('_token', 'remember_me');
        $remember_me = $req->input('remember_me') ? true : false;

        if (Auth::client()->attempt($credentials, $remember_me)) {
            return redirect('/');
        } else {
            return redirect()->back()
                ->withInput($req->except('_token'))
                ->withErrors(['メールアドレスもしくはパスワードに誤りがあります。']);
        }
    }

    public function logout()
    {
        Auth::client()->logout();
        return redirect('/login');
    }

    public function resetPassword()
    {
        return view('client.reset_password');
    }

    public function sendResetMail(ResetPasswordRequest $req)
    {
        $client = ClientRep::where('email', $req->input('email'))->first();

        $clientConfirm = new ClientRepConfirmation();
        $clientConfirm->client_rep_id = $client->id;
        $clientConfirm->saveWithOnetimeUrl($client);
        $data = ['confirmation_url' => url('/confirm/' . $clientConfirm->confirmation_token)];

        // @mail パスワード再設定メール to Client
        Mail::queue(['text' => 'emails.client.password_reset'], $data, function ($message) use ($client) {
            $message->from('info@education-career.jp')
                ->to($client->email)
                ->subject('【Education Career】パスワード再設定に関するお知らせ');
        });

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('指定したメールアドレスに登録用メールを送信しました。');
        return redirect('/login')->with('flash_msg', $flash);
    }

    public function checkUrl($token)
    {
        if (!$conf = ClientRepConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        return view('client.reset_password_confirm')->with('token', $conf->confirmation_token);
    }

    public function confirm(PasswordConfirmRequest $req)
    {
        $flash = new FlashMessage();

        DB::beginTransaction();
        try {
            $conf = ClientRepConfirmation::where('confirmation_token', $req->input('token'))->first();
            $conf->confirmed_at = Carbon::now()->setTimezone('jst');
            $conf->save();

            $client = ClientRep::where('id', $conf->client_rep_id)->first();
            $client->password = bcrypt($req->input('password'));
            $client->save();
        } catch (RuntimeException $e) {
            DB::rollBack();

            $flash->type('danger');
            $flash->message('パスワードの設定に失敗しました。システム管理者にお問い合わせ下さい。');

            Log::alert('担当者のパスワード設定に失敗', ['StackTrace' => $e->getTraceAsString()]);
            return redirect('/login')->with('flash_msg', $flash);
        }
        DB::commit();

        $flash->type('success');
        $flash->message('パスワードの設定が完了しました。');
        return redirect('/login')->with('flash_msg', $flash);
    }

}