<?php namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Mail;
use View;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Custom\FlashMessage;
use App\Customer;
use App\CustomerProfile;
use App\SchoolRecord;
use App\Http\Requests;
use App\Http\Requests\Admin\UpdateCustomerProfileRequest;
use App\Http\FormData\Admin\EditCustomerProfileFormData;

class CustomerProfileController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'customer');
    }

    public function edit(EditCustomerProfileFormData $data, $id)
    {
        $customer = Customer::with('profile')->where('id', $id)->first();
        $profile = $customer->profile;
        $data->load($profile);
        $school_records = SchoolRecord::all();
        return view('admin.customer_profile.edit')->with(compact(
            'data',
            'customer',
            'profile',
            'school_records'
        ));
    }

    public function update(UpdateCustomerProfileRequest $req, $id)
    {
        $profile = CustomerProfile::where('customer_id', $id)->first();
        $profile->username = $req->username;
        $profile->birthday = Carbon::create($req->year, $req->month, $req->day);
        $profile->school_record_id = $req->school_record_id != '' ? $req->school_record_id : null;
        $profile->school_name = $req->school_name;
        $profile->graduate_year = $req->graduate_year != '' ? $req->graduate_year : null;
        $profile->job_record = $req->job_record;
        $profile->skill = $req->skill;
        $profile->qualification = $req->qualification;
        $profile->introduction = $req->introduction;
        $profile->future_plan = $req->future_plan;

        $ret = $profile->save();
        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("カスタマー {$profile->customer->email} の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/customer')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("カスタマー {$profile->customer->email} の変更に成功しました。");
        return redirect('/customer')->with('flash_msg', $flash);
    }


}
