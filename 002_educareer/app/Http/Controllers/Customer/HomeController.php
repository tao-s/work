<?php namespace App\Http\Controllers\Customer;


use Config;
use App\Job;
use App\Tag;
use App\JobCategory;
use App\BusinessType;
use App\GrandBusinessType;
use App\Area;
use App\EmploymentStatus;
use App\Custom\RecentlyCheckedJobs;
use App\InterviewArticle;
use App\Custom\S3;
use Jenssegers\Agent\Agent;

class HomeController extends BaseCustomerController
{
    public function index()
    {
        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::whereNotIn('slug', ['contract', 'employment-status-other'])->get();
        $grand_business_types = GrandBusinessType::with('business_types')->get();
        $tags = Tag::all();
        $areas = Area::with('prefectures')->get();
        $prefectures = Config::get('prefecture');
        $main_slides = Job::where('main_slide_flag', true)->get();
        $pickups = Job::pickups();
        $recent_jobs = RecentlyCheckedJobs::get();
        $interviews = InterviewArticle::getForTopPage();
        $interview_image_path = S3::getInterviewImagePath();

        return view($this->template('index'))->with(compact(
            'main_slides',
            'pickups',
            'recent_jobs',
            'interviews',
            'job_categories',
            'employment_status',
            'grand_business_types',
            'tags',
            'areas',
            'prefectures',
            'interview_image_path'
        ));
    }

    public function search()
    {
        $agent = new Agent();
        if (!$agent->isMobile()) {
            abort(404);
        }
        $job_categories = JobCategory::all();
        $employment_status = EmploymentStatus::whereNotIn('slug', ['contract', 'employment-status-other'])->get();
        $grand_business_types = GrandBusinessType::with('business_types')->get();
        $areas = Area::with('prefectures')->get();

        return view($this->template('search'))->with(compact(
            'job_categories',
            'employment_status',
            'grand_business_types',
            'areas'
        ));
    }

}
