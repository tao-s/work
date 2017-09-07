<?php namespace App\Http\Controllers\Customer;

use App\Customer;
use App\EmploymentStatus;
use DB;
use Log;
use Jenssegers\Agent\Agent;
use Mail;
use Auth;
use Config;
use Carbon\Carbon;
use App\Custom\FlashMessage;

use App\Job;
use App\Application;
use App\Admin;
use App\Client;
use App\ClientRep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreApplicationRequest;

class ApplicationController extends BaseCustomerController
{

    public function store(StoreApplicationRequest $req)
    {
        $job = Job::where('id', $req->job_id)->first();
        if (!$job) {
            abort(404);
        }

        $customer = Auth::customer()->get();

        if ($customer instanceof Customer) {
            $customer->load('profile');
        } else { // 未ログイン => 登録済みか調べる
            $customer = Customer::whereEmail($req->email);

            if ($customer instanceof Customer) { // 登録済み
                $customer->load('profile');
            } else { // 未登録 => 新規会員登録
                $customer = Customer::createAndSendMail($req);

                if ($customer instanceof Customer) {
                    $customer->load('profile');
                } else {
                    \Log::error('Failed to create customer', $req->all());
                }
            }
        }

        $app = new Application();
        $app->customer_id = $customer->id;
        $app->job_id = $job->id;
        $app->save();

        // @mail 応募完了メール to Customer
        $job->load('client');
        $data = ['customer' => $customer, 'job' => $job];
        Mail::queue(['text' => 'emails.customer.application_complete'], $data, function ($message) use ($customer) {
            $message->from('info@education-career.jp')
                ->to($customer->email)
                ->subject('【Education Career】応募が完了しました');
        });

        if ($job->employment_status_id != EmploymentStatus::FullTime) {
            // @mail 応募完了メール to Client
            $client_rep_emails = ClientRep::getAllRepEmails($job->client_id);
            Mail::queue(['text' => 'emails.client.application_complete'], $data, function ($message) use ($client_rep_emails) {
                $message->from('info@education-career.jp')
                    ->to($client_rep_emails)
                    ->subject('【Education Career】求職者から応募がありました');
            });
        }
        // @mail 応募完了メール to Admin
        $admin_emails = Admin::getAllAdminEmails();
        Mail::queue(['text' => 'emails.admin.application_complete'], $data, function ($message) use ($admin_emails) {
            $message->from('info@education-career.jp')
                ->to($admin_emails)
                ->subject('【Education Career】カスタマーから応募がありました');
        });

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('この求人への応募が完了しました。');

        return redirect('/application/thanks')->with('job', $job);
    }

    public function thanks()
    {
        $customer = Auth::customer()->get();
        $job = session('job');
        if (!$job) {


            $jobs1 = Job::getDefaultJobQuery()->orderBy('random', 'asc')->limit(5)->get();


            $jobs2 = Job::getDefaultJobQuery()->orderBy('random', 'asc')->offset(5)->limit(5)->get();
        } else {
            $jobs1 = Job::getDefaultJobQuery()
                ->where(function($q) use ($job) {
                    $q->orWhere('employment_status_id', $job->employment_status_id)
                       ->orWhere('business_type_id', $job->business_type_id)
                       ->orWhere('job_category_id', $job->category_id);
                })
                ->orderBy('random', 'asc')
                ->limit(5)
                ->get();
            $jobs2 = Job::getDefaultJobQuery()
                ->where(function($q) use ($job) {
                    $q->orWhere('employment_status_id', $job->employment_status_id)
                        ->orWhere('business_type_id', $job->business_type_id)
                        ->orWhere('job_category_id', $job->category_id);
                })
                ->offset(5)
                ->orderBy('random', 'asc')
                ->limit(5)
                ->get();
        }
        return view($this->template('application.thanks'))->with(compact('customer', 'jobs1', 'jobs2'));
    }

}