<?php namespace App\Http\Controllers\Customer;

use App\Client;
use App\Customer;
use App\CustomerProfile;
use App\Http\FormData\AgentProfileInfoFormData;
use App\Http\SEO\JobDetailSEO;
use App\IndustryType;
use App\OccupationCategory;
use App\SchoolRecord;
use App\Prefecture;
use DB;
use Log;
use Mail;
use Auth;
use Config;
use Carbon\Carbon;
use App\Custom\S3;
use App\Custom\RecentlyCheckedJobs;
use App\Job;
use App\Tag;
use App\JobCategory;
use App\BusinessType;
use App\EmploymentStatus;
use App\InterviewArticle;
use App\Http\SEO\JobListSEO;
use Illuminate\Http\Request;

class JobController extends BaseCustomerController
{

    public function search(Request $req, JobListSEO $seo)
    {
        if ($req->all()) {
            $jobs = Job::search($req)->paginate(10);
        } else {
            $jobs = Job::getDefaultJobQuery()
                ->orderBy('random', 'asc')
                ->paginate(10);
        }
        $query = $req->except('page');
        $jobs->appends($query);

        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::all();
        $business_types = BusinessType::all();
        $tags = Tag::all();
        $prefectures = Prefecture::orderBy('sort', 'asc')->get();

        if ($client_id = $req->get('company')) {
            $client = Client::find($client_id);
            $header_company_name = $client instanceof Client ? $client->company_name : '';
        } else {
            $header_company_name = '';
        }

        return view($this->template('job.list'))->with(compact(
            'query',
            'jobs',
            'job_categories',
            'employment_status',
            'business_types',
            'tags',
            'prefectures',
            'seo',
            'header_company_name'
        ));
    }

    public function detail(JobDetailSEO $seo, AgentProfileInfoFormData $data, $id)
    {
        // 求人が存在しない場合は404
        if (!$job = Job::with('client')->with('employment_status')->where('id', $id)->first()) {
            abort(404);
        }
        // 非公開の場合は404
        if (!$job->client->can_publish || !$job->can_publish) {
            abort(404);
        }

        $customer = Auth::customer()->get();

        if ($customer instanceof Customer) {
            $data->load($customer);
        }

        RecentlyCheckedJobs::put($job);
        $side_image_path = S3::getJobSideImagePath();
        $interview_image_path = S3::getInterviewImagePath();
        $related_interviews = InterviewArticle::relatedInterviews($job->client_id);
        $related_jobs = Job::relatedJobsOfSameEmploymentStatus($job->client_id, $job->employment_status_id, 4);
        $interested_jobs = Job::interestedJobs($job->id, $job->job_category_id, $job->employment_status_id, $job->prefecture, 6);
        $school_records = SchoolRecord::all();
        $industry_types = IndustryType::all();
        $occupation_categories = OccupationCategory::all();
        $prefectures = Config::get('prefecture');
        $prefectures['48'] = '海外';

        $template = 'job.detail';

        if ($job->is_franchise) {
            $template = 'job.franchise.detail';
        }

        return view($this->template($template))->with(compact(
            'job',
            'related_jobs',
            'interested_jobs',
            'related_interviews',
            'side_image_path',
            'interview_image_path',
            'seo',
            'data',
            'school_records',
            'industry_types',
            'occupation_categories',
            'prefectures'
        ));
    }

}
