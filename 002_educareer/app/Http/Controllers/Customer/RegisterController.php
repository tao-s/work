<?php namespace App\Http\Controllers\Customer;

use App\IndustryType;
use App\OccupationCategory;
use DB;
use Mail;
use Auth;
use Session;
use Carbon\Carbon;
use App\Custom\FlashMessage;
use App\CustomerProfile;
use App\SchoolRecord;
use App\Customer;
use App\CustomerConfirmation;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\StoreCustomerProfileRequest;
use App\Http\Requests\Customer\ReActivationRequest;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\FormData\RegisterProfileFormData;

class RegisterController extends BaseCustomerController
{

    public function index(Request $req)
    {
        return view($this->template('register.index'));
    }

    public function completed()
    {
        return view($this->template('register.completed'));
    }

    public function thanks()
    {
        return view($this->template('register.thanks'));
    }

    public function reactivate()
    {
        $email = Session::get('re-activate.email');
        return view($this->template('register.re_activate'))->with(compact('email'));
    }

    public function resend(ReActivationRequest $req)
    {
        $customer = Customer::where('email', $req->email)
            ->where('is_activated', false)
            ->first();

        $customerConfirm = new CustomerConfirmation();
        $customerConfirm->customer_id = $customer->id;
        $customerConfirm->saveWithOnetimeUrl();

        // @mail 仮登録完了メール to Customer
        $limit_date = Carbon::now()->addHours(24);
        $data = [
            'confirmation_url' => url('/register/confirm/' . $customerConfirm->confirmation_token),
            'month' => $limit_date->month,
            'day' => $limit_date->day,
            'hour' => $limit_date->hour,
            'minute' => $limit_date->minute,
        ];
        Mail::queue(['text' => 'emails.customer.pre_register_customer'], $data, function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】会員登録のご案内');
        });

        return redirect('/register/completed');
    }

    public function store(StoreCustomerRequest $req)
    {
        // 既にメールアドレスでの登録があり、confirmされていなければ、そちらのレコードを使って登録する。
        // 上記の際パスワードは今回送られてきたものを使う。
        $customer = Customer::where('email', $req->email)
                            ->where('is_activated', false)
                            ->first();

        if (!$customer) {
            $customer = new Customer();
            $customer->email = $req->input('email');
        }

        $customer->password = bcrypt($req->input('password'));

        if (!$customer->save()) {
            $flash = new FlashMessage();
            $flash->type('error');
            $flash->message('会員登録に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。');
            return redirect('/register')->with('flash_msg', $flash);
        }

        $customerConfirm = new CustomerConfirmation();
        $customerConfirm->customer_id = $customer->id;
        $customerConfirm->saveWithOnetimeUrl();

        // @mail 仮登録完了メール to Customer
        $limit_date = Carbon::now()->addHours(24);
        $data = [
            'confirmation_url' => url('/register/confirm/' . $customerConfirm->confirmation_token),
            'month' => $limit_date->month,
            'day' => $limit_date->day,
            'hour' => $limit_date->hour,
            'minute' => $limit_date->minute,
        ];
        Mail::queue(['text' => 'emails.customer.pre_register_customer'], $data, function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】会員登録のご案内');
        });

        return redirect('/register/completed');
    }

    public function confirm($token)
    {
        if (!$conf = CustomerConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('error');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/register')->with('flash_msg', $flash);
        }

        // @todo トランザクション
        $conf->confirmed_at = Carbon::now()->setTimezone('jst');
        $conf->save();

        $customer = Customer::where('id', $conf->customer_id)->first();
        $customer->is_activated = true;
        $customer->saveWithProfile();

        Auth::customer()->loginUsingId($customer->id);

        return redirect('/register/'.$conf->customer_id.'/profile');
    }

    public function profile(RegisterProfileFormData $data, $id)
    {

        $customer = Auth::customer()->get();
        $customer->load('profile');
        if ($id != $customer->id) {
            return redirect('/login');
        }

        $data->load($customer);
        $should_input_password = false;
        if ($customer->password == null) {
            $should_input_password = true;
        }

        $school_records = SchoolRecord::all();
        $industry_types = IndustryType::all();
        $occupation_categories = OccupationCategory::all();
        $prefectures = \Config::get('prefecture');
        $prefectures['48'] = '海外';

        return view($this->template('register.profile'))->with(compact(
            'data',
            'customer',
            'should_input_password',
            'school_records',
            'industry_types',
            'occupation_categories',
            'prefectures'
        ));
    }

    public function storeProfile(StoreCustomerProfileRequest $req, $id)
    {
        $customer = Auth::customer()->get();
        $customer->load('profile');
        if ($id != $customer->id) {
            return abort(404);
        }

        // ソーシャル経由の場合、パスワードが未入力になるので、パスワードを保存する。
        $ret = DB::transaction(function() use ($req, $id, $customer) {

            $ret1 = true;
            if ($req->password) {
                $customer->password = bcrypt($req->password);
                $customer->phone = $req->phone;
                $ret1 = $customer->save();
            }

            /** @var CustomerProfile $profile */
            $profile = CustomerProfile::where('customer_id', $id)->first();
            $profile->username = $req->username;
            $profile->sex = $req->sex;
            $profile->birthday = Carbon::create($req->year, $req->month, $req->day);
            $profile->prefecture = $req->prefecture;
            $profile->introduction = $req->introduction;
            $profile->future_plan = $req->future_plan;
            $profile->school_record_id = $req->school_record_id != '' ? $req->school_record_id : null;
            $profile->school_name = $req->school_name;
            $profile->graduate_year = $req->graduate_year != '' ? $req->graduate_year : null;
            $profile->job_record = $req->job_record;
            $profile->skill = $req->skill;
            $profile->qualification = $req->qualification;
            $profile->mail_magazine_flag = boolval($req->mail_magazine_flag);
            $profile->scout_mail_flag = boolval($req->scout_mail_flag);
            $profile->company_name = $req->company_name ?: '';
            $profile->work_location_id = $req->work_location ?: null;

            $profile->industry_types()->detach($profile->industry_types()->getRelatedIds());

            if (is_array($req->industry_type)) {
                $profile->industry_types()->attach(array_filter($req->industry_type));
            }

            $profile->occupation_categories()->detach($profile->occupation_categories()->getRelatedIds());

            for ($i = 0; $i < 3; $i++) {
                if (!empty($req->occupation_category[$i])) {
                    $profile->occupation_categories()
                        ->attach($req->occupation_category[$i], ['free_word' => $req->occupation_category_free_word[$i]]);
                } elseif ($req->occupation_category_parent[$i] == 8) {
                    // 「その他」の場合は専用のIDを使い、free_wordを設定する
                    $profile->occupation_categories()
                        ->attach(OccupationCategory::ID_OTHERS, ['free_word' => $req->occupation_category_free_word[$i]]);
                }
            }

            $ret2 = $profile->save();

            return $ret1 && $ret2;
        });

        if (!$ret) {
            //@todo log or flash or email or all?
        }

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('ご登録いただきありがとうございます。会員登録が正常に完了しました。');

        // @mail 登録完了メール to Cusotmer
        Mail::queue(['text' => 'emails.customer.register_customer'], [], function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】会員登録手続きが完了しました');
        });
        // @mail 登録完了メール to Admin
        $admin_emails = Admin::getAllAdminEmails();
        $data = ['count' => Customer::all()->count(), 'customer' => $customer];
        $customer->load('profile');
        Mail::queue(['text' => 'emails.admin.register_customer'], $data, function ($message) use ($admin_emails) {
            $message->from('info@education-career.jp')
                ->to($admin_emails)
                ->subject('【Education Career】カスタマーが会員登録手続きを完了しました');
        });


        return redirect('/register/thanks');
    }

}
