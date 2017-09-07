<?php namespace App\Http\Controllers\Client;

use DB;
use Log;
use Mail;
use Auth;
use Config;
use View;
use App\Http\Controllers\Controller;
use App\Custom\FlashMessage;
use App\Custom\S3;
use App\Custom\LocalImageStorage;
use App\Tag;
use App\Job;
use App\Client;
use App\JobCategory;
use App\BusinessType;
use App\EmploymentStatus;
use App\ClientRep;
use App\Custom\PreviewImage;
use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreJobRequest;
use App\Http\Requests\Client\UpdateJobRequest;
use App\Http\Requests\Client\StoreFranchiseJobRequest;
use App\Http\Requests\Client\UpdateFranchiseJobRequest;
use App\Http\Requests\Client\PreviewJobRequest;
use App\Http\FormData\Client\CreateJobFormData;

class JobController extends Controller
{

    public function __construct()
    {
        View::share('module_key', 'posting');
    }

    public function index()
    {
        $client_id = Auth::client()->get()->client_id;
        $jobs = Job::with('client')->with('applications')->where('client_id', $client_id)->orderBy('created_at', 'desc')->paginate(10);

        return view('client.job.index')->with(compact('jobs', 'client_id'));
    }

    public function create(Request $req, CreateJobFormData $data)
    {
        /** @var Client $client */
        $client = Auth::client()->get()->load('client.upgrade')->client;

        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $clients = Client::all();
        $prefectures = Config::get('prefecture');
        $thumbnail_path = S3::getJobThumnbNailPath();
        $side_image_path = S3::getJobSideImagePath();

        $data->load(['tags' => []]);

        $template = 'client.job.create';
        if ($req->get('franchise')) {
            $template = 'client.job.franchise.create';
        }

        return view($template)->with(compact(
            'client',
            'job_categories',
            'employment_status',
            'business_types',
            'tags',
            'prefectures',
            'clients',
            'data',
            'thumbnail_path',
            'side_image_path'
        ));
    }

    public function copy_and_create(Request $req, CreateJobFormData $data)
    {
        $client = Auth::client()->get()->load('client.upgrade')->client;

        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $clients = Client::all();
        $prefectures = Config::get('prefecture');
        $thumbnail_path = S3::getJobThumnbNailPath();
        $side_image_path = S3::getJobSideImagePath();

        $data->load($req->except('_token'));

        $template = 'client.job.create';
        if ($req->get('franchise')) {
            $template = 'client.job.franchise.create';
        }

        return view($template)->with(compact(
            'copied_data',
            'client',
            'job_categories',
            'employment_status',
            'business_types',
            'tags',
            'prefectures',
            'clients',
            'data',
            'thumbnail_path',
            'side_image_path'
        ));
    }

    public function preview(PreviewJobRequest $req)
    {
        $data = $req->all();
        $job = New Job();
        $job->title = $data['title'];
        $job->main_message = $data['main_message'];
        $job->job_title = $data['job_title'];
        $job->background = $data['background'];
        $job->job_description = $data['job_description'];
        $job->qualification = $data['qualification'];
        $job->work_place = $data['work_place'];
        $job->work_hour = $data['work_hour'];
        $job->salary = $data['salary'];
        $job->holiday = $data['holiday'];
        $job->benefit = $data['benefit'];
        $job->company_business = $data['company_business'];
        $job->company_description = $data['company_description'];
        $job->company_characteristics = $data['company_characteristics'];
        $job->side_image1_caption = $req->side_image1_caption;
        $job->side_image2_caption = $req->side_image2_caption;
        $job->side_image3_caption = $req->side_image3_caption;

        $pi = new PreviewImage();
        $job->main_image_filepath = $pi->uploadMainImage($req);
        $job->side_image1_filepath = $pi->uploadSideImage($req, 'side_image1');
        $job->side_image2_filepath = $pi->uploadSideImage($req, 'side_image2');
        $job->side_image3_filepath = $pi->uploadSideImage($req, 'side_image3');

        $client_id = Auth::client()->get()->client_id;
        $client = Client::where('id', $client_id)->first();
        $job_category = JobCategory::where('id', $data['job_category_id'])->first();
        $employment_status = EmploymentStatus::where('id', $data['employment_status_id'])->first();
        $business_type = BusinessType::where('id', $data['business_type_id'])->first();
        // Customerサイドとテンプレートを共有しているため、$user変数を定義しておく必要がある。
        $user = null;

        $side_image_path = S3::getJobSideImagePath();

        return view('client.job.preview')->with(compact(
            'user',
            'job',
            'client',
            'job_category',
            'employment_status',
            'business_type',
            'thumbnail_path',
            'side_image_path'
        ));
    }

    public function preview_franchise(Request $req)
    {
        $data = $req->all();
        $job = New Job();
        $job->title = $data['title'];
        $job->main_message = $data['main_message'];
        $job->job_title = $data['job_title'];
        $job->work_place = $data['work_place'];
        $job->company_description = $data['company_description'];
        $job->company_business = $data['company_business'];
        $job->company_characteristics = $data['company_characteristics'];
        $job->fr_about_product = $data['fr_about_product'];
        $job->fr_about_market = $data['fr_about_market'];
        $job->fr_pre_support = $data['fr_pre_support'];
        $job->fr_post_support = $data['fr_post_support'];
        $job->fr_flow_to_open = $data['fr_flow_to_open'];
        $job->fr_business_model = $data['fr_business_model'];
        $job->fr_contract_type = $data['fr_contract_type'];
        $job->fr_contract_period = $data['fr_contract_period'];
        $job->fr_initial_fund_amount = $data['fr_initial_fund_amount'];
        $job->fr_royalty = $data['fr_royalty'];
        $job->fr_seminar_info = $data['fr_seminar_info'];
        $job->side_image1_caption = $req->side_image1_caption;
        $job->side_image2_caption = $req->side_image2_caption;
        $job->side_image3_caption = $req->side_image3_caption;

        $pi = new PreviewImage();
        $job->main_image_filepath = $pi->uploadMainImage($req);
        $job->side_image1_filepath = $pi->uploadSideImage($req, 'side_image1');
        $job->side_image2_filepath = $pi->uploadSideImage($req, 'side_image2');
        $job->side_image3_filepath = $pi->uploadSideImage($req, 'side_image3');

        $client_id = Auth::client()->get()->client_id;
        $client = Client::where('id', $client_id)->first();
        $job_category = JobCategory::where('id', JobCategory::Other)->first();
        $employment_status = EmploymentStatus::where('id', EmploymentStatus::Franchise)->first();
        $business_type = BusinessType::where('id', $data['business_type_id'])->first();
        // Customerサイドとテンプレートを共有しているため、$user変数を定義しておく必要がある。
        $user = null;

        $side_image_path = S3::getJobSideImagePath();

        return view('client.job.franchise.preview')->with(compact(
            'user',
            'job',
            'client',
            'job_category',
            'employment_status',
            'business_type',
            'thumbnail_path',
            'side_image_path'
        ));
    }

    public function store(StoreJobRequest $req)
    {
        $job = new Job();
        $req->client_id = Auth::client()->get()->client_id;
        $job->setRequestValues($req, false);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人の作成に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人の作成に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

    public function store_franchise(StoreFranchiseJobRequest $req)
    {
        $job = new Job();
        $req->client_id = Auth::client()->get()->client_id;
        $job->setRequestValues($req, true);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人の作成に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人の作成に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

    public function edit($id)
    {
        $job = Job::with('tags')->where('id', $id)->first();
        if (!$job || $job->client_id != Auth::client()->get()->client_id) {
            $flash = new FlashMessage();
            $flash->type('danger');
            $flash->message("権限のないページにアクセスしました。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $clients = Client::all();
        $prefectures = Config::get('prefecture');

        $thumbnail_path = S3::getJobThumnbNailPath();
        $side_image_path = S3::getJobSideImagePath();

        $template = 'client.job.edit';
        if ($job->is_franchise) {
            $template = 'client.job.franchise.edit';
        }

        return view($template)->with(compact(
            'job_categories',
            'employment_status',
            'business_types',
            'tags',
            'prefectures',
            'clients',
            'job',
            'thumbnail_path',
            'side_image_path'
        ));
    }

    public function update(UpdateJobRequest $req, $id)
    {
        $job = Job::where('id', $id)->first();
        $req->client_id = Auth::client()->get()->client_id;
        $job->setRequestValues($req, $job->is_franchise);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人 [ID: {$job->id}] の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人 [ID: {$job->id}] の変更に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

    public function update_franchise(UpdateFranchiseJobRequest $req, $id)
    {
        $job = Job::where('id', $id)->first();
        $req->client_id = Auth::client()->get()->client_id;
        $job->setRequestValues($req, $job->is_franchise);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人 [ID: {$job->id}] の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人 [ID: {$job->id}] の変更に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

    public function publish($id)
    {
        $flash = new FlashMessage();
        $client = Auth::client()->get()->client;

        $job = Job::where('id', $id)->first();
        if (!$job) {
            $flash->type('danger');
            $flash->message("リクエストされた求人は見つかりませんでした。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $job->can_publish = true;

        if (!$job->save()) {
            $flash->type('danger');
            $flash->message("求人の公開に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        // @mail 求人公開お知らせメール to Client
        $job->load('client');
        $data = ['job' => $job];
        $emails = ClientRep::getAllRepEmails($job->client->id);
        Mail::queue(['text' => 'emails.client.job_published'], $data, function ($message) use ($emails) {
            $message->from('info@education-career.jp')
                ->to($emails)
                ->subject('【Education Career】求人が公開されました');
        });

        $flash->type('success');
        $flash->message("求人の公開に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

    public function depublish($id)
    {
        $flash = new FlashMessage();
        $job = Job::where('id', $id)->first();
        if (!$job) {
            $flash->type('danger');
            $flash->message("リクエストされた求人は見つかりませんでした。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $job->can_publish = false;
        $ret = $job->save();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人の非公開処理に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        // @mail 求人非公開お知らせメール to Client
        $job->load('client');
        $data = ['job' => $job];
        $emails = ClientRep::getAllRepEmails($job->client->id);
        Mail::queue(['text' => 'emails.client.job_depublished'], $data, function ($message) use ($emails) {
            $message->from('info@education-career.jp')
                ->to($emails)
                ->subject('【Education Career】求人が非公開になりました');
        });

        $flash->type('success');
        $flash->message("求人の非公開処理に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

    public function destroy($id)
    {
        $job = Job::where('id', $id)->first();

        $flash = new FlashMessage();
        if (!$job->delete()) {
            $flash->type('danger');
            $flash->message("求人の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/posting')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人の削除に成功しました。");
        return redirect('/posting')->with('flash_msg', $flash);
    }

}