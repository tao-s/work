<?php namespace App\Http\SEO;

use Illuminate\Http\Request;
use App\Job;
use App\EmploymentStatus;

class JobDetailSEO extends SEO
{
    protected function configure()
    {
        $req = $this->req;
        $job_id = $req->route()->getParameter('job_id');
        $job = Job::with('client','employment_status')->where('id', $job_id)->first();
        $this->job = $job;
    }

    protected function set_title()
    {
        $job = $this->job;
        if ($job) {
            $this->title = $job->title . ' - ' . $job->client->company_name;
        }
    }

    protected function set_description()
    {
        $job = $this->job;
        if ($job) {
            $this->description = "{$job->client->company_name}の{$job->job_title}の求人情報詳細ページです。Education Career（エデュケーションキャリア）は、教育業界に特化した求人サービスです。";
        }
    }

    protected function set_keywords()
    {
        $job = $this->job;
        if ($job) {
            $employment_status = EmploymentStatus::seoKeywords($job->employment_status->id);
            $this->keywords = "{$job->job_title},{$job->client->company_name},転職{$employment_status},求人,求人情報";
        }
    }

}