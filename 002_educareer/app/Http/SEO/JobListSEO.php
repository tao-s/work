<?php namespace App\Http\SEO;

use App\Client;
use Config;
use App\JobCategory;
use App\EmploymentStatus;
use App\BusinessType;

class JobListSEO extends SEO
{
    private $companyName = '教育関連';

    protected function configure()
    {
        // 会社名が存在する場合
        if ($this->req->company) {
            $client = Client::find($this->req->company);

            if ($client instanceof Client) {
                $this->companyName = $client->company_name;
            }

        }
    }

    protected function set_title()
    {
        $req = $this->req;

        $pre_title = '%prefecture%%business_type%%job_category%%employment_status%%company_name%求人情報一覧';

        // 勤務地が存在する場合
        $prefecture = isset(Config::get('prefecture')[$req->prefecture]) ? Config::get('prefecture')[$req->prefecture] : '';
        if ($prefecture) {
            $pre_title = str_replace('%prefecture%', "{$prefecture}の", $pre_title);
        } else {
            $pre_title = str_replace('%prefecture%', '', $pre_title);
        }

        // 業態が存在する場合
        if ($bt = BusinessType::find($req->business_type)) {
            $pre_title = str_replace('%business_type%', "{$bt->title}の", $pre_title);
        } else {
            $pre_title = str_replace('%business_type%', '', $pre_title);
        }

        // 職種が存在する場合
        if ($job_category = JobCategory::find($req->job_category)) {
            $pre_title = str_replace('%job_category%', "{$job_category->title}の", $pre_title);
        } else {
            $pre_title = str_replace('%job_category%', '', $pre_title);
        }

        // 働き方が存在する場合
        if ($employment_status = EmploymentStatus::seoTitle($req->employment_status)) {
            $pre_title = str_replace('%employment_status%', "{$employment_status}の", $pre_title);
        } else {
            $pre_title = str_replace('%employment_status%', '', $pre_title);
        }

        if (is_null($bt) &&
            is_null($job_category) &&
            is_null($req->business_type) &&
            is_null($req->job_category) &&
            $prefecture == ''
        ) {
            $pre_title = str_replace('%company_name%', "{$this->companyName}の", $pre_title);
        } else {
            $pre_title = str_replace('%company_name%', '', $pre_title);
        }


        $this->title = $pre_title;
    }

    protected function set_description()
    {
        $req = $this->req;
        $pre_description = '%prefecture%%employment_status%' . $this->companyName . 'の%job_category%求人一覧。';

        // 職種が存在する場合
        if ($job_category = JobCategory::find($req->job_category)) {
            $pre_description = str_replace('%job_category%', $job_category->title . 'の', $pre_description);
        } else {
            $pre_description = str_replace('%job_category%', '', $pre_description);
        }

        // 働き方が存在する場合
        if ($employment_status = EmploymentStatus::seoTitle($req->employment_status)) {
            $pre_description = str_replace('%employment_status%', $employment_status, $pre_description);
        } else {
            $pre_description = str_replace('%employment_status%', '', $pre_description);
        }

        // 勤務地が存在する場合
        if ($req->prefecture) {
            $prefecture = isset(Config::get('prefecture')[$req->prefecture]) ? Config::get('prefecture')[$req->prefecture] : '';
            $pre_description = str_replace('%prefecture%', $prefecture . '、', $pre_description);
        } else {
            $pre_description = str_replace('%prefecture%','', $pre_description);
        }

        $this->description = $pre_description . '教育業界に特化した求人サービスEducation Career（エデュケーションキャリア）であなたにあった求人を見つけましょう。';
    }

    protected function set_keywords()
    {
        $req = $this->req;
        $keywords = '教育%job_category%,転職,求人,教育業界%prefecture%%employment_status%';

        // 職種が存在する場合
        if ($req->job_category) {
            $job_category = JobCategory::seoKeywords($req->job_category);
            $keywords = str_replace('%job_category%', $job_category, $keywords);
        } else {
            $keywords = str_replace('%job_category%', '', $keywords);
        }

        // 働き方が存在する場合
        if ($req->employment_status) {
            $employment_status = EmploymentStatus::seoKeywords($req->employment_status);
            $keywords = str_replace('%employment_status%', $employment_status, $keywords);
        } else {
            $keywords = str_replace('%employment_status%', '', $keywords);
        }

        // 勤務地が存在する場合
        if ($req->prefecture) {
            $prefecture = isset(Config::get('prefecture')[$req->prefecture]) ? Config::get('prefecture')[$req->prefecture] : '';
            $keywords = str_replace('%prefecture%', ','.$prefecture, $keywords);
        } else {
            $keywords = str_replace('%prefecture%','', $keywords);
        }

        $this->keywords = $keywords;
    }

}