<?php namespace App\Http\Controllers\Admin;

use App\Http\FormData\Admin\CreateJobFormData;
use Config;
use View;
use Mail;
use App\Custom\S3;
use App\Http\Controllers\Controller;
use App\Custom\FlashMessage;
use App\Custom\PreviewImage;
use App\Tag;
use App\Job;
use App\Client;
use App\ClientRep;
use App\JobCategory;
use App\BusinessType;
use App\EmploymentStatus;
use App\Http\Requests;
use App\Http\Requests\Admin\StoreJobRequest;
use App\Http\Requests\Admin\UpdateJobRequest;
use App\Http\Requests\Admin\StoreFranchiseJobRequest;
use App\Http\Requests\Admin\UpdateFranchiseJobRequest;
use Illuminate\Http\Request;

class JobController extends Controller {

    public function __construct()
    {
        View::share('module_key', 'job');
    }

	public function index(Request $req)
	{
        $q = Job::with('client');
        if ($client_id = $req->get('client_id')) {
            $q->where('client_id', $client_id);
        }
		$jobs = $q->orderBy('created_at', 'desc')->paginate(30);
		return view('admin.job.index')->with(compact('jobs'));
	}

	public function create(Request $req, CreateJobFormData $data)
	{
        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $clients = Client::all();
        $prefectures = Config::get('prefecture');
        $thumbnail_path = S3::getJobThumnbNailPath();
        $side_image_path = S3::getJobSideImagePath();

        $data->load(['tags' => []]);

        $template = 'admin.job.create';
        if ($req->get('franchise')) {
            $template = 'admin.job.franchise.create';
        }

        return view($template)->with(compact(
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
        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $clients = Client::all();
        $prefectures = Config::get('prefecture');
        $thumbnail_path = S3::getJobThumnbNailPath();
        $side_image_path = S3::getJobSideImagePath();

        $data->load($req->except('_token'));

        $template = 'admin.job.create';
        if ($req->get('franchise')) {
            $template = 'admin.job.franchise.create';
        }

        return view($template)->with(compact(
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

    public function preview(Request $req)
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

        $client_id = $data['client_id'];
        $client = Client::where('id', $client_id)->first();
        $job_category = JobCategory::where('id', $data['job_category_id'])->first();
        $employment_status = EmploymentStatus::where('id', $data['employment_status_id'])->first();
        $business_type = BusinessType::where('id', $data['business_type_id'])->first();
        // Customerサイドとテンプレートを共有しているため、$user変数を定義しておく必要がある。
        $user = null;

        $side_image_path = S3::getJobSideImagePath();

        return view('admin.job.preview')->with(compact(
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

        $client_id = $data['client_id'];
        $client = Client::where('id', $client_id)->first();
        $job_category = JobCategory::where('id', JobCategory::Other)->first();
        $employment_status = EmploymentStatus::where('id', EmploymentStatus::Franchise)->first();
        $business_type = BusinessType::where('id', $data['business_type_id'])->first();
        // Customerサイドとテンプレートを共有しているため、$user変数を定義しておく必要がある。
        $user = null;

        $side_image_path = S3::getJobSideImagePath();

        return view('admin.job.franchise.preview')->with(compact(
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
        $job->setRequestValues($req, false);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("通常求人の作成に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/job')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("通常求人の作成に成功しました。");
        return redirect('/job')->with('flash_msg', $flash);
    }

    public function store_franchise(StoreFranchiseJobRequest $req)
    {
        $job = new Job();
        $job->setRequestValues($req, true);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();
        if (!$ret) {
            $flash->type('danger');
            $flash->message("フランチャイズ求人の作成に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/job')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("フランチャイズ求人の作成に成功しました。");
        return redirect('/job')->with('flash_msg', $flash);
    }

    public function edit($id)
    {
        $job = Job::with('tags')->where('id', $id)->first();
        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $clients = Client::all();
        $prefectures = Config::get('prefecture');

        $thumbnail_path = S3::getJobThumnbNailPath();
        $side_image_path = S3::getJobSideImagePath();

        $template = 'admin.job.edit';
        if ($job->is_franchise) {
            $template = 'admin.job.franchise.edit';
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
        $job->setRequestValues($req, false);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人 [ID: {$job->id}] の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/job')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人 [ID: {$job->id}] の変更に成功しました。");
        return redirect('/job')->with('flash_msg', $flash);
    }

    public function update_franchise(UpdateFranchiseJobRequest $req, $id)
    {
        $job = Job::where('id', $id)->first();
        $job->setRequestValues($req, true);
        $ret = $job->saveClientJob($req);

        $flash = new FlashMessage();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人 [ID: {$job->id}] の変更に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/job')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("求人 [ID: {$job->id}] の変更に成功しました。");
        return redirect('/job')->with('flash_msg', $flash);
    }

    public function publish($id)
    {
        $flash = new FlashMessage();
        $job = Job::where('id', $id)->first();
        if (!$job) {
            $flash->type('danger');
            $flash->message("リクエストされた求人は見つかりませんでした。");
            return redirect('/job')->with('flash_msg', $flash);
        }

        $job->can_publish = true;

        if (!$job->save()) {
            $flash->type('danger');
            $flash->message("求人の公開に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/job')->with('flash_msg', $flash);
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
        return redirect('/job')->with('flash_msg', $flash);
    }

    public function depublish($id)
    {
        $flash = new FlashMessage();
        $job = Job::where('id', $id)->first();
        if (!$job) {
            $flash->type('danger');
            $flash->message("リクエストされた求人は見つかりませんでした。");
            return redirect('/job')->with('flash_msg', $flash);
        }

        $job->can_publish = false;
        // 求人非公開求人時には下記フラグもfalseにする。
        $job->main_slide_flag = false;
        $job->pickup_flag = false;
        $ret = $job->save();

        if (!$ret) {
            $flash->type('danger');
            $flash->message("求人の非公開処理に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/job')->with('flash_msg', $flash);
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
        return redirect('/job')->with('flash_msg', $flash);
    }

    public function destroy($id)
	{
		$job = Job::where('id', $id);

		$flash = new FlashMessage();
		if (!$job->delete()) {
			$flash->type('danger');
			$flash->message("求人の削除に失敗しました。システム管理者にお問い合わせ下さい。");
			return redirect('/job')->with('flash_msg', $flash);
		}

		$flash->type('success');
		$flash->message("求人 の削除に成功しました。");
		return redirect('/job')->with('flash_msg', $flash);
	}

    /**
     * メインスライド掲載フラグを切り替える
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_slide($id)
    {
        $job = Job::where('id', $id)->first();

        if (!$job) {
            return $this->error('/job', 'リクエストされた求人は見つかりませんでした。');
        }

        $job->main_slide_flag = !$job->main_slide_flag;

        if (!$job->save()) {
            return $this->error('/job', '求人の保存に失敗しました。システム管理者にお問い合わせ下さい。');
        }

        $message = $job->main_slide_flag ? '求人をメインスライドに掲載しました。' : '求人のメインスライド掲載を取り消しました。';

        return $this->success('/job', $message);
    }

    /**
     * Pickup掲載フラグを切り替える
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_pickup($id)
    {
        $job = Job::where('id', $id)->first();

        if (!$job) {
            return $this->error('/job', 'リクエストされた求人は見つかりませんでした。');
        }

        $job->pickup_flag = !$job->pickup_flag;

        if (!$job->save()) {
            return $this->error('/job', '求人の保存に失敗しました。システム管理者にお問い合わせ下さい。');
        }

        $message = $job->pickup_flag ? '求人をPickupに掲載しました。' : '求人のPickup掲載を取り消しました。';

        return $this->success('/job', $message);
    }
}