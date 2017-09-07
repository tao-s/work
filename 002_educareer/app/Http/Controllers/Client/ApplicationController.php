<?php namespace App\Http\Controllers\Client;

use App\ClientRep;
use App\EmploymentStatus;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Log;
use Mail;
use Auth;
use Config;
use View;
use App\Custom\FlashMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job;
use App\Application;
use App\ApplicationCheck;
use App\ApplicationStatus;
use App\Http\Requests;
use App\Admin;

class ApplicationController extends Controller {

    public function __construct()
    {
        View::share('module_key', 'application');
    }

    public function index()
    {
        $client_id = Auth::client()->get()->client_id;
        $apps = Application::getWithoutFullTimeByClientId($client_id);

        $app_statuses = ApplicationStatus::all();
        $count_by_status = DB::table('applications')
            ->join('jobs', function($join) use ($client_id) {
                $join->on('applications.job_id', '=', 'jobs.id')
                    ->where('jobs.client_id', '=', $client_id)
                    ->where('jobs.employment_status_id', '<>', EmploymentStatus::FullTime); // フルタイムは除外
            })
            ->select('applications.status_id', DB::raw('count(1) as count'))
            ->groupBy('applications.status_id')
            ->lists('count','applications.status_id');
        $app_checks = ApplicationCheck::where('client_id', $client_id)->get();
        $client_reps = ClientRep::query()->where('client_id', '=', $client_id)->get();

        return view('client.application.index')->with(compact(
            'apps',
            'app_statuses',
            'count_by_status',
            'app_checks',
            'client_reps'
        ));
    }
    
    public function indexByStatusId($id)
    {
        $app_status = ApplicationStatus::where('id', $id)->first();
        if (!$app_status) {
            abort(404);
        }

        $client_id = Auth::client()->get()->client_id;
        $apps = Application::getWithoutFullTimeByClientId($client_id, $id);

        $app_statuses = ApplicationStatus::all();
        $count_by_status = DB::table('applications')
            ->join('jobs', function($join) use ($client_id) {
                $join->on('applications.job_id', '=', 'jobs.id')
                    ->where('jobs.client_id', '=', $client_id)
                    ->where('jobs.employment_status_id', '<>', EmploymentStatus::FullTime); // フルタイムは除外
            })
            ->select('applications.status_id', DB::raw('count(1) as count'))
            ->groupBy('applications.status_id')
            ->lists('count','applications.status_id');

        $app_checks = ApplicationCheck::where('client_id', $client_id)->get();
        $client_reps = ClientRep::query()->where('client_id', '=', $client_id)->get();

        return view('client.application.index')->with(compact(
            'apps',
            'app_statuses',
            'count_by_status',
            'app_status',
            'app_checks',
            'client_reps'
        ));
    }

    public function indexByJobId($id)
    {
        $client_id = Auth::client()->get()->client_id;
        $job = Job::where('id', $id)->where('client_id', $client_id)->first();
        if (!$job) {
            abort(404);
        }

        $job->load('employment_status');

        $apps = Application::with('customer.profile')
            ->with('status')
            ->where('job_id', $job->id)
            ->whereHas('job.employment_status', function (Builder $q) {
                $q->where('id', '<>', EmploymentStatus::FullTime);
            })
            ->paginate(10);

        $app_statuses = ApplicationStatus::all();
        $count_by_status = DB::table('applications')
            ->join('jobs', function($join) use ($client_id) {
                $join->on('applications.job_id', '=', 'jobs.id')
                    ->where('jobs.client_id', '=', $client_id)
                    ->where('jobs.employment_status_id', '<>', EmploymentStatus::FullTime); // フルタイムは除外
            })
            ->select('applications.status_id', DB::raw('count(1) as count'))
            ->where('applications.job_id', $job->id)
            ->groupBy('applications.status_id')
            ->lists('count','applications.status_id');
        $app_checks = ApplicationCheck::where('client_id', $client_id)->get();

        return view('client.job.application.index')->with(compact(
            'apps',
            'app_statuses',
            'count_by_status',
            'job',
            'app_checks'
        ));
    }

    public function indexByJobIdAndStatusId($job_id, $status_id)
    {
        $client_id = Auth::client()->get()->client_id;
        $job = Job::where('id', $job_id)->where('client_id', $client_id)->first();
        $app_status = ApplicationStatus::where('id', $status_id)->first();
        if (!$job || !$app_status) {
            abort(404);
        }

        $job->load('employment_status');
        $app_statuses = ApplicationStatus::all();
        $apps = Application::with('customer.profile')
            ->with('status')
            ->where('job_id', $job->id)
            ->where('status_id', $app_status->id)
            ->whereHas('job.employment_status', function (Builder $q) {
                $q->where('id', '<>', EmploymentStatus::FullTime);
            })
            ->paginate(10);
        $count_by_status = DB::table('applications')
            ->join('jobs', function($join) use ($client_id) {
                $join->on('applications.job_id', '=', 'jobs.id')
                    ->where('jobs.client_id', '=', $client_id)
                    ->where('jobs.employment_status_id', '<>', EmploymentStatus::FullTime); // フルタイムは除外
            })
            ->select('applications.status_id', DB::raw('count(1) as count'))
            ->where('applications.job_id', $job->id)
            ->groupBy('applications.status_id')
            ->lists('count','applications.status_id');
        $app_checks = ApplicationCheck::where('client_id', $client_id)->get();

        return view('client.job.application.index')->with(compact(
            'apps',
            'app_statuses',
            'count_by_status',
            'app_status',
            'job',
            'app_checks'
        ));
    }

	public function show($id)
    {
        $app = Application::with('customer.profile')->with('status')->where('id', $id)->first();
        if (!$app) {
            abort(404);
        }

        // クライアントが案件を見た数をカウント（無料プランの閲覧制限に利用する）
        ApplicationCheck::count($app);

        return view('client.job.application.show')->with(compact('app'));
	}

    public function update(Request $req, $app_id)
    {
        $app = Application::where('id', $app_id)->first();
        $app_status = ApplicationStatus::where('id', $req->get('status_id'))->first();
        $flash = new FlashMessage();
        if (!$app || !$app_status) {
            $flash->type('danger');
            $flash->message("不正なリクエストを検知しました。ページをリロードし、再度操作を行ってください。");
            return redirect()->back();
        }

        $app->status_id = $app_status->id;
        $app->save();

        $app->load('customer.profile')->load('job')->load('status');
        if ($app_status->id == ApplicationStatus::StatusDeclined) {
            // @mail 不採用通知メール to Customer
            $data = ['customer' => $app->customer, 'job' => $app->job];
            Mail::queue(['text' => 'emails.customer.application_declined'], $data, function ($message) use ($app) {
                $message->from('info@education-career.jp')
                    ->to($app->customer->email)
                    ->subject('【Education Career】選考結果のご連絡');
            });

            // @mail 不採用通知メール to Admin
            $rep = Auth::client()->get()->load('client');
            $data = ['customer' => $app->customer, 'job' => $app->job, 'client' => $rep->client];
            $admin_emails = Admin::getAllAdminEmails();
            Mail::queue(['text' => 'emails.admin.application_declined'], $data, function ($message) use ($admin_emails) {
                $message->from('info@education-career.jp')
                    ->to($admin_emails)
                    ->subject('【Education Career】応募者が不採用になりました');
            });
        }

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message("{$app->customer->profile->username}様のステータスを「{$app->status->label}」に変更しました。");

        if ($req->get('job_id')) {
            return redirect('/application/job/'.$req->get('job_id'))->with('flash_msg', $flash);
        }

        return redirect('/application')->with('flash_msg', $flash);
    }

    /**
     * 担当者を変更する
     *
     * @param int $app_id 応募ID
     * @param int $rep_id クライアント担当者ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRep($app_id, $rep_id)
    {
        /** @var Application $app */
        $app = Application::where('id', $app_id)->first();

        if (!$app) {
            return redirect()->back();
        }

        $app->client_reps_id = $rep_id ? $rep_id : null;

        if ($app->save()) {
            return $this->success('/application', '担当者を変更しました。');
        } else {
            return $this->error('/application', '担当者の保存に失敗しました。システム管理者にお問い合わせ下さい。');
        }
    }
}