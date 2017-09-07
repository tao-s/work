<?php namespace App\Http\Controllers\Customer;

use DB;
use Log;
use Auth;
use Mail;
use Session;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use App\Customer;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\ResetPasswordRequest;
use App\Http\Requests\Customer\PasswordConfirmRequest;
use App\CustomerConfirmation;
use App\Custom\FlashMessage;
use Illuminate\Http\Request;

class LoginController extends BaseCustomerController {

    public function index(Request $req)
    {
        return view($this->template('login.index'));
	}

    public function login(LoginRequest $req)
    {
        $credentials = ['email' => $req->email, 'password' => $req->password];

        if (Auth::customer()->attempt($credentials)) {

            if (!Auth::customer()->get()->is_activated) {
                // @todo アクティベーション送信画面を表示
                Session::put('re-activate.email', $req->email);
                return redirect('/register/re-activate');
            }

            if ($path = Session::get('last_get_request')) {
                return redirect($path);
            }

            return redirect('/');
        } else {
            $errors = ['login_failed' => 'ユーザ名またはパスワードが間違っています。'];
            return redirect('/login')->withErrors($errors);
        }
    }

    public function logout()
    {
        Auth::customer()->logout();

        return redirect('/');
    }

    public function reset_password()
    {
        return view($this->template('login.reset_password'));
    }

    public function send_reset(ResetPasswordRequest $req)
    {
        $customer = Customer::where('email', $req->input('email'))->first();

        $conf = new CustomerConfirmation();
        $conf->customer_id = $customer->id;
        $conf->saveWithOnetimeUrl($customer);
        $data = ['confirmation_url' => url('/password/confirm/' . $conf->confirmation_token)];

        // @mail パスワード再設定メール to Customer
        Mail::queue(['text' => 'emails.customer.password_reset'], $data, function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】パスワード再設定に関するお知らせ');
        });

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('指定したメールアドレスに登録用メールを送信しました。');
        return redirect()->back()->with('flash_msg', $flash);
    }

    public function check_url($token)
    {
        if (!$conf = CustomerConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('error');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/password/reset')->with('flash_msg', $flash);
        }

        return view($this->template('login.change_password'))->with('token', $conf->confirmation_token);
    }

    public function confirm(PasswordConfirmRequest $req)
    {
        $flash = new FlashMessage();

        DB::beginTransaction();
        try {
            $conf = CustomerConfirmation::where('confirmation_token', $req->token)->first();
            $conf->confirmed_at = Carbon::now()->setTimezone('jst');
            $conf->save();

            $customer = Customer::where('id', $conf->customer_id)->first();
            $customer->password = bcrypt($req->password);
            $customer->save();
        } catch (RuntimeException $e) {
            DB::rollBack();

            $flash->type('error');
            $flash->message('パスワードの設定に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。');

            Log::alert('担当者のパスワード設定に失敗', ['StackTrace' => $e->getTraceAsString()]);
            return redirect('/login')->with('flash_msg', $flash);
        }
        DB::commit();

        $flash->type('success');
        $flash->message('パスワードの設定が完了しました。');
        return redirect('/login')->with('flash_msg', $flash);
    }

    public function facebookLogin()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function facebookCallback(Request $req)
    {
        if ($req->error) {
            $flash = new FlashMessage('error', 'Facebookアカウント連携に失敗しました。');
            return redirect('/login')->with('flash_msg', $flash);
        }
        if ($req->get('state') != session('state')) {
            $flash = new FlashMessage('error', 'Facebookアカウント連携に失敗しました。ブラウザのキャッシュを消してから再度お試しください。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        $facebook_user = Socialite::with('facebook')->user();
        $customer = Customer::where('email', $facebook_user->email)->first();

        // 未登録ユーザなので、登録フローへ遷移
        if (!$customer) {
            $customer = new Customer();
            $customer->email = $facebook_user->email;
            $customer->is_activated = true;

            if (!$customer->email) {
                $flash = new FlashMessage('error', 'Facebookアカウント連携に失敗しました。ブラウザのキャッシュを消してから再度お試しください。');
                return redirect('/login')->with('flash_msg', $flash);
            }

            $customer->saveWithProfile([
                'username' => $facebook_user->name,
            ]);

            Auth::customer()->loginUsingId($customer->id);
            return redirect('/register/'.$customer->id.'/profile');
        }

        // 既に登録されているユーザなので、トップへ遷移
        Auth::customer()->loginUsingId($customer->id);

        // セッションに最後のGETリクエストがあればそちらにリダイレクト
        if ($path = Session::get('last_get_request')) {
            return redirect($path);
        }

        return redirect('/');
    }

    public function googleLogin()
    {
        return Socialite::with('google')->redirect();
    }

    public function googleCallback(Request $req)
    {
        if ($req->error) {
            $flash = new FlashMessage('error', 'Googleログインに失敗しました');
            return redirect('/login')->with('flash_msg', $flash);
        }
        if ($req->get('state') != session('state')) {
            $flash = new FlashMessage('error', 'Googleアカウント連携に失敗しました。ブラウザのキャッシュを消してから再度お試しください。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        $google_user = Socialite::with('google')->user();
        $customer = Customer::where('email', $google_user->email)->first();

        // 未登録ユーザなので、登録フローへ遷移
        if (!$customer) {
            $customer = new Customer();
            $customer->email = $google_user->email;

            if (!$customer->email) {
                $flash = new FlashMessage('error', 'Googleアカウント連携に失敗しました。ブラウザのキャッシュを消してから再度お試しください。');
                return redirect('/login')->with('flash_msg', $flash);
            }

            $customer->is_activated = true;
            $customer->saveWithProfile([
                'username' => $google_user->name,
            ]);

            Auth::customer()->loginUsingId($customer->id);
            return redirect('/register/'.$customer->id.'/profile');
        }

        // 既に登録されているユーザなので、トップへ遷移
        Auth::customer()->loginUsingId($customer->id);

        // セッションに最後のGETリクエストがあればそちらにリダイレクト
        if ($path = Session::get('last_get_request')) {
            return redirect($path);
        }

        return redirect('/');
    }
    
}
