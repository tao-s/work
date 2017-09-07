<?php namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Mail;
use Auth;
use Carbon\Carbon;
use App\Admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminConfirmation;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Http\Requests\Admin\PasswordConfirmRequest;
use App\Custom\FlashMessage;

class LoginController extends Controller
{

    public function index()
    {
        if (Auth::client()->check()) {
            return redirect('/');
        }

        return view('admin.login');
    }

    public function login(Request $req)
    {
        $credentials = $req->except('_token', 'remember_me');
        $remember_me = $req->input('remember_me') ? true : false;

        if (Auth::admin()->attempt($credentials, $remember_me)) {
            return redirect('/');
        } else {
            return redirect()->back()
                ->withInput($req->except('_token'))
                ->withErrors(['メールアドレスもしくはパスワードに誤りがあります。']);
        }
    }

    public function logout()
    {
        Auth::admin()->logout();
        return redirect('/login');
    }

    public function resetPassword()
    {
        return view('admin.reset_password');
    }

    public function sendResetMail(ResetPasswordRequest $req)
    {
        $admin = Admin::where('email', $req->input('email'))->first();

        $adminConfirm = new AdminConfirmation();
        $adminConfirm->setOnetimeUrl($admin);
        $data = ['confirmation_url' => url('/confirm/' . $adminConfirm->confirmation_token)];
        Mail::queue('emails.admin.password_reset', $data, function ($message) use ($admin) {
            $message->from('info@education-career.jp')
                ->to($admin->email)
                ->subject('パスワード再設定用メール: EducationCareer管理画面');
        });

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('指定したメールアドレスに登録用メールを送信しました。');
        return redirect('/login')->with('flash_msg', $flash);
    }

    public function checkUrl($token)
    {
        if (!$conf = AdminConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        return view('admin.reset_password_confirm')->with('token', $conf->confirmation_token);
    }

    public function confirm(PasswordConfirmRequest $req)
    {
        $flash = new FlashMessage();

        DB::beginTransaction();
        try {
            $conf = AdminConfirmation::where('confirmation_token', $req->input('token'))->first();
            $conf->confirmed_at = Carbon::now()->setTimezone('jst');
            $conf->save();

            $admin = Admin::where('id', $conf->admin_id)->first();
            $admin->password = bcrypt($req->input('password'));
            $admin->save();
        } catch (RuntimeException $e) {
            DB::rollBack();

            $flash->type('danger');
            $flash->message('パスワードの設定に失敗しました。システム管理者にお問い合わせ下さい。');

            Log::alert('管理者のパスワード設定に失敗', ['StackTrace' => $e->getTraceAsString()]);
            return redirect('/login')->with('flash_msg', $flash);
        }
        DB::commit();

        $flash->type('success');
        $flash->message('パスワードの設定が完了しました。');
        return redirect('/login')->with('flash_msg', $flash);
    }

}