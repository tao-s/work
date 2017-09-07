<?php namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Jenssegers\Agent\Agent;

use View;
use Auth;
use Config;
use App\Job;
use App\Tag;
use App\JobCategory;
use App\BusinessType;
use App\EmploymentStatus;
use App\Custom\S3;

class BaseCustomerController extends BaseController
{

    public function __construct()
    {
        if ($user = Auth::customer()->get()) {
            $user->load('profile.school_record');
        }
        View::share('user', $user);
        
        View::share([
          'query' => [],//mobileの検索クエリ復元用
          'job_categories' => JobCategory::all(),
          'employment_status' => EmploymentStatus::all(),
          'business_types' => BusinessType::all(),
          'tags' => Tag::all(),
          'prefectures' => Config::get('prefecture'),
          'thumbnail_path' => S3::getJobThumnbNailPath(),
        ]);
    }

    public function template($path)
    {
        $template_prefix = 'pc';
        $agent = new Agent();
        if ($agent->isMobile()) {
            // 2015-10-30にスマホ対応をリリースするまではPC画面を表示
            if (env('MOBILE_ON')) {
                $template_prefix = 'mobile';
            }
        }

        return 'customer.' . $template_prefix . '.' . $path;
    }

}
