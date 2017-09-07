<?php namespace App;

use Auth;
use Carbon\Carbon;
use DB;
use Mail;
use Illuminate\Database\Eloquent\Model;

class AgentInquiry extends Model {

	protected $table = 'agent_inquiries';

    public static function saveWithCustomer($req)
    {
        $login_customer = Auth::customer()->get();

        // 既存カスタマー（ログイン済み）
        if ($login_customer) {
            $inquiry = new self();
            $inquiry->customer_id = $login_customer->id;
            $login_customer->phone = $req->phone;
            $profile = self::setProfileValues($login_customer->profile, $req);

            return DB::transaction(function () use ($login_customer, $inquiry, $profile) {
                $ret1 = $login_customer->save();
                $ret2 = $inquiry->save();
                $ret3 = $profile->save();

                return $ret1 && $ret2 && $ret3;
            });

        }

        // 既存カスタマー（未ログインなのでメールアドレスで検索）
        if ($customer = Customer::where('email', $req->email)->first())
        {
            $inquiry = new self();
            $inquiry->customer_id = $customer->id;
            $customer->phone = $req->phone;
            $profile = self::setProfileValues($customer->profile, $req);

            return DB::transaction(function () use ($customer, $inquiry, $profile) {

                $ret1 = $customer->save();
                $ret2 = $inquiry->save();
                $ret3 = $profile->save();

                return $ret1 && $ret2 && $ret3;
            });

        }
        // 新規カスタマー
        else
        {
            $customer = new Customer();
            $customer->email = $req->email;
            $customer->phone = $req->phone;

            $inquiry = new self();
            $inquiry->inquiry = $req->inquiry;

            $save_customer = DB::transaction(function () use ($customer, $req, $inquiry) {
                $carbon = Carbon::create($req->year, $req->month, $req->day);

                $ret1 = $customer->saveWithProfile([
                    'username' => $req->username,
                    'sex' => $req->sex,
                    'birthday' => $carbon,
                    'prefecture' => $req->prefecture,
                    'school_record_id' => $req->school_record_id,
                    'school_name' => $req->school_name,
                    'graduate_year' => $req->graduate_year,
                    'job_record' => $req->job_record,
                    'company_name' => $req->company_name,
                    'work_location' => $req->work_location,
                    'industry_types' => $req->industry_types,
                    'occupation_category' => $req->occupation_category,
                    'occupation_category_free_word' => $req->occupation_category_free_word,
                ]);
                $inquiry->customer_id = $customer->id;
                $ret2 = $inquiry->save();

                if ($ret1 && $ret2) {
                    return $customer;
                }

                return false;
            });

            // saveに失敗した場合
            if (!$save_customer) {
                return false;
            }

            $customerConfirm = new CustomerConfirmation();
            $customerConfirm->customer_id = $save_customer->id;
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

            Mail::queue(['text' => 'emails.customer.pre_register_customer'], $data, function ($message) use ($save_customer) {
                $message->from('info@education-career.jp')
                    ->to($save_customer->email)
                    ->subject('【Education Career】会員登録のご案内');
            });

            return true;

        }
    }

    /**
     * CustomerProfileに値をセットして返す
     *
     * @param CustomerProfile $profile
     * @param $req
     * @return CustomerProfile
     */
    private static function setProfileValues(CustomerProfile $profile, $req)
    {
        $profile->company_name = $req->company_name;
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

        return $profile;
    }
}
