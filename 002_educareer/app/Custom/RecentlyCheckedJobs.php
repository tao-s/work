<?php namespace App\Custom;

use Aws\Common\Facade\Ses;
use Session;
use App\Job;
use Illuminate\Http\Request;

class RecentlyCheckedJobs
{
    const key = 'recently_checked_jobs';

    static public function put($job)
    {
        $jobs = Session::get(self::key);
        if (!$jobs) {
            $jobs = collect([]);
        }

        // 直近2つ目までに同様のIDのアイテムがない場合のみpush
        if ($jobs->take(-2)->where('id', $job->id)->count() == 0) {
            $jobs->push($job);
        }

        Session::put(self::key, $jobs->take(-2));
    }

    static public function get()
    {
        $jobs = Session::get(self::key);
        if (!$jobs) {
            return collect([]);
        }

        return $jobs->reverse();
    }

}