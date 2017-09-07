<?php namespace App\Http\Controllers\Customer;


use App\IndustryType;
use App\OccupationCategory;
use Mail;
use Auth;
use Carbon\Carbon;
use App\Custom\FlashMessage;
use App\Customer;
use App\CustomerProfile;
use App\SchoolRecord;
use App\Http\Requests\Customer\UpdateCustomerPasswordRequest;
use App\Http\Requests\Customer\UpdateCustomerAccountRequest;
use App\Http\Requests\Customer\DeleteCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerProfileRequest;

class MypageController extends BaseCustomerController
{

    public function index()
    {
        return view($this->template('mypage.index'));
    }

    public function editAccount()
    {
        $customer_id = Auth::customer()->get()->id;
        $customer = Customer::where('id', $customer_id)->with('profile')->first();
        return view($this->template('mypage.edit.account'))->with(compact('customer'));
    }

    public function updateAccount(UpdateCustomerAccountRequest $req)
    {
        $customer_id = Auth::customer()->get()->id;
        $customer = Customer::where('id', $customer_id)->first();

        $customer->email = $req->email;
        $customer->phone = $req->phone;
        $customer->profile->username = $req->username;
        $customer->profile->sex = $req->sex;
        $customer->profile->birthday = Carbon::create($req->year, $req->month, $req->day);
        $customer->profile->prefecture = $req->prefecture;
        $customer->profile->mail_magazine_flag = boolval($req->mail_magazine_flag);
        $customer->profile->scout_mail_flag = boolval($req->scout_mail_flag);

        $ret = $customer->push();

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('error');
            $flash->message("アカウント情報の変更に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。");
            return redirect('/mypage')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("アカウント情報の変更に成功しました。");
        return redirect('/mypage')->with('flash_msg', $flash);
    }

    public function editPassword()
    {
        return view($this->template('mypage.edit.password'));
    }

    public function updatePassword(UpdateCustomerPasswordRequest $req)
    {
        $customer_id = Auth::customer()->get()->id;
        $customer = Customer::where('id', $customer_id)->first();
        $customer->password = bcrypt($req->password);
        $ret = $customer->save();

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('error');
            $flash->message("パスワードの変更に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。");
            return redirect('/mypage')->with('flash_msg', $flash);
        }

        // @mail パスワード変更のお知らせ to Customer
        $data = ['customer' => $customer];
        Mail::queue(['text' => 'emails.customer.password_updated'], $data, function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】パスワードが変更されました');
        });

        $flash->type('success');
        $flash->message("パスワードの変更に成功しました。");
        return redirect('/mypage')->with('flash_msg', $flash);
    }

    public function editProfile()
    {
        $customer_id = Auth::customer()->get()->id;
        $customer = Customer::where('id', $customer_id)->with('profile')->first();
        $school_records = SchoolRecord::all();
        $industry_types = IndustryType::all();
        $occupation_categories = OccupationCategory::all();
        $prefectures = \Config::get('prefecture');
        $prefectures['48'] = '海外';

        return view($this->template('mypage.edit.profile'))
            ->with(compact('customer', 'school_records', 'industry_types', 'occupation_categories', 'prefectures'));
    }

    public function updateProfile(UpdateCustomerProfileRequest $req)
    {
        $customer_id = Auth::customer()->get()->id;
        /** @var CustomerProfile $profile */
        $profile = CustomerProfile::where('customer_id', $customer_id)->first();

        $profile->introduction = $req->introduction;
        $profile->future_plan = $req->future_plan;
        $profile->school_record_id = $req->school_record_id != '' ? $req->school_record_id : null;
        $profile->school_name = $req->school_name;
        $profile->graduate_year = $req->graduate_year != '' ? $req->graduate_year : null;
        $profile->job_record = $req->job_record;
        $profile->skill = $req->skill;
        $profile->qualification = $req->qualification;
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

        $ret = $profile->save();

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('error');
            $flash->message("プロフィールの変更に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。");
            return redirect('/mypage')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("プロフィールの変更に成功しました。");
        return redirect('/mypage')->with('flash_msg', $flash);
    }

    public function indexQuit()
    {
        return view($this->template('mypage.quit'));
    }

    public function quit(DeleteCustomerRequest $req)
    {
        $customer_id = Auth::customer()->get()->id;
        Auth::customer()->logout();
        $customer = Customer::where('id', $customer_id)->first();
        $customer->delete();

        return redirect('/');
    }

}