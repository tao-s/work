<?php namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Mail;
use View;
use App\Http\Controllers\Controller;
use App\Custom\FlashMessage;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Admin\StoreCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;

class CustomerController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'customer');
    }

    public function index(Request $req)
    {
        if ($req->all()) {
            $customers = Customer::search($req)->paginate(30);
        } else {
            $customers = Customer::with('profile', 'confirmation')->paginate(30);
        }
        $query = $req->except('page');
        $customers->appends($query);

        return view('admin.customer.index')->with(compact('customers', 'query'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(StoreCustomerRequest $req)
    {
        $customer = new Customer();
        $customer->email = $req->input('email');
        $customer->password = bcrypt($req->input('password'));

        $result = DB::transaction(function() use($customer) {
            return $customer->saveWithProfile();
        });

        $flash = new FlashMessage();
        if (!$result) {
            $flash->type('danger');
            $flash->message("カスタマー「{$customer->email}」の登録に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/customer')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("カスタマー「{$customer->email}」の登録に成功しました。");
        return redirect('/customer')->with('flash_msg', $flash);
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customer.edit')->with(compact('customer'));
    }

    public function update(UpdateCustomerRequest $req, $id)
    {
        $customer = Customer::where('id', $id)->first();
        $customer->email = $req->input('email');
        $email = $customer->email;
        $customer->password = bcrypt($req->input('password'));

        $ret = $customer->save();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("カスタマー {$email} の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/customer')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("カスタマー {$email} の変更に成功しました。");
        return redirect('/customer')->with('flash_msg', $flash);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $email = $customer->email;

        $flash = new FlashMessage();
        if (!$customer->delete()) {
            $flash->type('danger');
            $flash->message("カスタマー {$email} の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/customer')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("カスタマー {$email} の削除に成功しました。");
        return redirect('/customer')->with('flash_msg', $flash);
    }


}
