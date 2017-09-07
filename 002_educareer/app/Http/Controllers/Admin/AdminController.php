<?php namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Mail;
use View;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Admin;
use App\Custom\FlashMessage;
use App\AdminConfirmation;
use App\Http\Requests;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\PasswordConfirmRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use Psy\Exception\RuntimeException;

class AdminController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'admin');
    }

    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.admin.index')->with(compact('admins'));
    }

    public function store(StoreAdminRequest $req)
    {
        $admin = new Admin();
        $admin->email = $req->input('email');

        $flash = new FlashMessage();
        if (!$admin->save()) {
            $flash->type('danger');
            $flash->message('オペレータの登録に失敗しました。システム管理者にお問い合わせ下さい。');
            return redirect('/admin')->with('flash_msg', $flash);
        }

        $adminConfirm = new AdminConfirmation();
        $adminConfirm->admin_id = $admin->id;
        $adminConfirm->setOnetimeUrl();
        $data = ['confirmation_url' => url('/admin/confirm/' . $adminConfirm->confirmation_token)];
        Mail::queue('emails.admin.create_admin', $data, function ($message) use ($admin) {
            $message->from('info@education-career.jp')
                ->to($admin->email)
                ->subject('仮登録お知らせメール: EducationCareer管理画面');
        });

        $flash->type('success');
        $flash->message("{$admin->email} に登録用メールを送信しました。");
        return redirect('/admin')->with('flash_msg', $flash);
    }

    public function checkUrl($token)
    {
        if (!$conf = AdminConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/login')->with('flash_msg', $flash);
        }

        return view('admin.admin.create_confirm')->with('token', $conf->confirmation_token);
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
        return redirect('/admin')->with('flash_msg', $flash);
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        // @todo 見つからなかった場合の処理
        return view('admin.admin.edit')->with(compact('admin'));
    }

    public function update(UpdateAdminRequest $req, $id)
    {
        $admin = Admin::find($id);
        $admin->password = bcrypt($req->input('password'));
        $email = $admin->email;
        $ret = $admin->save();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("オペレーター {$email} のパスワードの変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/admin')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("オペレーター {$email} のパスワード変更に成功しました。");
        return redirect('/admin')->with('flash_msg', $flash);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        $email = $admin->email;
        $ret = $admin->delete();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("オペレーター {$email} の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/admin')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("オペレーター {$email} の削除に成功しました。");
        return redirect('/admin')->with('flash_msg', $flash);
    }

}
