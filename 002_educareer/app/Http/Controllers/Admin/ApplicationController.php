<?php namespace App\Http\Controllers\Admin;

use App\Application;
use App\ApplicationStatus;
use App\Custom\FlashMessage;
use App\EmploymentStatus;
use DB;
use Illuminate\Http\Request;
use View;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'application');
    }

    /**
     * Admin Web 応募管理
     * フルタイム応募を一覧表示
     */
    public function index($status_id = null)
    {
        $app_status = $status_id ? ApplicationStatus::where('id', $status_id)->first() : null;

        $q = Application::with('job.employment_status')
            ->with('status')
            ->with('job.client')
            ->with('customer')
            ->with('customer.profile')
            ->whereHas('job.employment_status', function (\Illuminate\Database\Eloquent\Builder $q) {
                $q->where('id', '=', EmploymentStatus::FullTime); // フルタイムだけ取得
            })
            ->orderBy('created_at', 'desc');

        if ($status_id) {
            $q->where('status_id', '=', $status_id);
        }

        $apps = $q->paginate(30);

        $app_statuses = ApplicationStatus::all();
        $count_by_status = DB::table('applications')
            ->join('jobs', function($join) {
                $join->on('applications.job_id', '=', 'jobs.id')
                    ->where('jobs.employment_status_id', '=', EmploymentStatus::FullTime); // フルタイムのみ
            })
            ->select('applications.status_id', DB::raw('count(1) as count'))
            ->groupBy('applications.status_id')
            ->lists('count','applications.status_id');

        return view('admin.application.index')->with(compact(
            'apps',
            'app_status',
            'app_statuses',
            'count_by_status'
        ));
    }

    /**
     * Admin Web 応募管理 応募者詳細情報
     */
    public function show($app_id)
    {
        $app = Application::with('customer')->with('customer.profile')->whereId($app_id)->get()->first();

        if (!$app || !$app->customer) {
            abort(404);
        }

        $customer = $app->customer;

        return view('admin.application.show')->with(compact('customer'));
    }

    /**
     * Admin web 応募管理 ステータス変更
     */
    public function update(Request $req, $app_id)
    {
        /** @var Application $app */
        $app = Application::where('id', $app_id)->first();
        $app_status = ApplicationStatus::where('id', $req->get('status_id'))->first();

        if (!$app || !$app_status) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message("不正なリクエストを検知しました。ページをリロードし、再度操作を行ってください。");
            return redirect()->back();
        }

        $app->status_id = $app_status->id;
        $app->save();

        $app->load('customer.profile')->load('job')->load('status');

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message("{$app->customer->profile->username}様のステータスを「{$app->status->label}」に変更しました。");

        return redirect('/application')->with('flash_msg', $flash);
    }
}
