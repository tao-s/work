<?php namespace App\Http\Controllers\Customer;

use App\IndustryType;
use App\OccupationCategory;
use Auth;
use Mail;
use Config;
use Carbon\Carbon;
use App\Custom\FlashMessage;
use App\Http\Requests\Customer\StoreAgentProfileInfoRequest;
use App\AgentInquiry;
use App\SchoolRecord;
use App\Http\FormData\AgentProfileInfoFormData;
use App\Admin;

class AgentController extends BaseCustomerController
{

    public function thanks()
    {
        return view($this->template('agent.thanks'));
    }
  
    public function index(AgentProfileInfoFormData $data)
    {
        $data->load(Auth::customer()->get());
        $school_records = SchoolRecord::all();
        $industry_types = IndustryType::all();
        $occupation_categories = OccupationCategory::all();
        $prefectures = Config::get('prefecture');
        $prefectures['48'] = '海外';

        return view($this->template('agent.index'))->with(compact(
            'school_records',
            'industry_types',
            'occupation_categories',
            'prefectures',
            'data'
        ));
    }

    public function store(StoreAgentProfileInfoRequest $req)
    {
        $ret = AgentInquiry::saveWithCustomer($req);

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('error');
            $flash->message("エージェントへの個別相談申請に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。");
            return redirect('/agent')->with('flash_msg', $flash);
        }

        // @mail エージェント相談完了通知メール to Customer
        $data = ['username' => $req->username];
        $email = $req->email;
        Mail::queue(['text' => 'emails.customer.register_agent'], $data, function ($message) use ($email) {
            $message->from('info@education-career.jp')
                ->to($email)
                ->subject('【Education Career】相談フォームへのご記入ありがとうございました');
        });
        // @mail エージェント相談完了通知メール to Admin
        $admins = Admin::getAllAdminEmails();
        $pref = Config::get('prefecture');
        $school_record = SchoolRecord::where('id', $req->school_record_id)->first();
        $data = [
            'username' => $req->username,
            'email' => $req->email,
            'phone' => $req->phone,
            'school_record' => ($school_record instanceof SchoolRecord) ? $school_record->title : '',
            'school_name' => $req->school_name,
            'graduate_year' => $req->graduate_year,
            'sex' => $req->sex == 1 ? '男性' : '女性',
            'birthday' => $req->year . '年' . $req->month . '月' . $req->day . '日',
            'prefecture' => $pref[$req->prefecture],
            'job_record' => $req->job_record,
            'inquiry' => $req->inquiry,
        ];
        Mail::queue(['text' => 'emails.admin.register_agent'], $data, function ($message) use ($admins) {
            $message->from('info@education-career.jp')
                ->to($admins)
                ->subject('【Education Career】相談フォームから問い合わせがありました');
        });

        $flash->type('success');
        $flash->message("エージェントへの個別相談のリクエストを送信しました。お問い合わせいただきありがとうございました。");
        return redirect('/agent/thanks');
    }

    public function confirm($token)
    {
        if (!$conf = CustomerConfirmation::validUrl($token)->first()) {
            $flash = new FlashMessage();
            $flash->type('error');
            $flash->message('有効期限切れのURLにアクセスしました。');
            return redirect('/agent')->with('flash_msg', $flash);
        }

        // @todo トランザクション
        $conf->confirmed_at = Carbon::now()->setTimezone('jst');
        $conf->save();

        $customer = Customer::where('id', $conf->customer_id)->first();
        $customer->is_activated = true;
        $customer->save();

        // @mail 登録完了メール to Cusotmer
        Mail::queue(['text' => 'emails.customer.register_customer'], [], function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】会員登録手続きが完了しました');
        });

        Auth::customer()->loginUsingId($customer->id);

        return redirect('/register/'.$conf->customer_id.'/profile');
    }

}