<?php namespace App;

use DB;
use App\Custom\S3;
use App\Customer;
use App\GrandBusinessType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Job extends Model {

    const FUN_OF_LIFE = 2;
    const PRIVATE_JOB = 4;

    protected $table = 'jobs';
    protected $fillable = ['can_publish', 'random', 'main_slide_flag', 'pickup_flag'];

    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function employment_status()
    {
        return $this->belongsTo('App\EmploymentStatus');
    }

    public function business_type()
    {
        return $this->belongsTo('App\BusinessType');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public static function getDefaultJobQuery()
    {
        return Job::with('employment_status')->with('client')
            ->where('can_publish', 1)
            ->whereHas('client', function($q) {
                $q->where('can_publish', 1);
            });
    }

    public static function search(Request $req)
    {
        $q = self::select('*')->with('employment_status')->with('business_type');

        $jc = $req->get('job_category');
        if (is_numeric($jc)) {
            $q->where('job_category_id', $jc);
        }

        $es = $req->get('employment_status');
        if (is_numeric($es)) {
            $q->where('employment_status_id', $es);
        }

        $gbt = $req->get('grand_business_type');
        if (is_numeric($gbt)) {
            $gbt = GrandBusinessType::with('business_types')->where('id', $gbt)->first()->business_types()->get();
            $business_types = [];
            foreach ($gbt as $bt) {
                $business_types[] = $bt->id;
            }
            $q->whereIn('business_type_id', $business_types);
        }

        $bt = $req->get('business_type');
        if (is_numeric($bt)) {
            $q->where('business_type_id', $bt);
        }

        $pf = $req->get('prefecture');
        if (is_numeric($pf)) {
            $q->where('prefecture', $pf);
        }

        if ($req->get('tags')) {
            $q->whereHas('tags', function($q) use ($req) {
                $q->whereIn('id', $req->get('tags'));
            });
        }

        $client_id = $req->get('company');
        if ($client_id) {
            $q->where('client_id', $client_id);
        }

        if ($keyword = $req->get('keyword')) {
            $like = '%'.$keyword.'%';
            $q->where(function($q) use ($like) {
                $q->orWhere('title', 'LIKE', $like);
                $q->orWhere('main_message', 'LIKE', $like);
                $q->orWhere('job_description', 'LIKE', $like);
                $q->orWhere('work_place', 'LIKE', $like);
                $q->orWhereHas('client', function($q) use ($like) {
                    $q->where('company_name', 'LIKE', $like);
                });
            });
        }

        // 共通のフィルタリング条件
        $q->orderBy('random', 'asc')
          ->where('can_publish', 1)
          ->whereHas('client', function($q) {
                $q->where('can_publish', 1);
          });
        return $q;
    }

    public static function prepareFroFreePlan($client_id)
    {
        $jobs = self::select('id')
            ->where('client_id', $client_id)
            ->where('can_publish', true)
            ->orderBy('created_at', 'desc')
            ->take(1844674407370955161)
            ->skip(1)
            ->get();

        return self::whereIn('id', explode(',', $jobs->implode('id', ',')))
            ->update(['can_publish' => false]);
    }

    public static function pickups()
    {
        $pickups = self::where('pickup_flag', true)->with('client')->get();
        if ($pickups->count() == 0) {
            return [];
        }
        $rows = intval(ceil($pickups->count() / 2));
        $bucket = array_fill(1, $rows, []);
        for ($i = 1; $i <= $rows; $i++) {
            $bucket[$i][] = $pickups->pop();
            $bucket[$i][] = $pickups->pop();
            $bucket[$i] = array_filter($bucket[$i], function($result) {
                if (is_null($result)) {
                    return false;
                }

                return true;
            });
        }

        return $bucket;
    }

    public static function relatedJobs($client_id)
    {
        return self::with('client')
            ->where('client_id', $client_id)
            ->where('can_publish', true)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();
    }

    /**
     * 同じクライアントの雇用形態が同一の求人のうち、ランダムで2件取得
     *
     * @param int $client_id
     * @param int $employment_status_id
     * @param int $limit
     * @return Collection
     */
    public static function relatedJobsOfSameEmploymentStatus($client_id, $employment_status_id, $limit = 2)
    {
        return self::with('client')
            ->where('client_id', $client_id)
            ->where('employment_status_id', $employment_status_id)
            ->where('can_publish', true)
            ->orderBy('random', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * 「この求人を見ている人が見ている他の求人」
     * 職種 > 雇用形態 > 勤務地の順で絞込を行って求人を取得
     *
     * @param int $job_id 現在閲覧中の求人
     * @param int $job_category_id 職種
     * @param int $employment_status_id 雇用形態
     * @param int $prefecture 勤務地
     * @param int $limit
     * @return Collection
     */
    public static function interestedJobs($job_id, $job_category_id, $employment_status_id, $prefecture, $limit = 2)
    {
        $base_query = static::getDefaultJobQuery();
        $base_query->whereHas('client', function($q) {
            $q->whereNotIn('id', [Job::FUN_OF_LIFE, Job::PRIVATE_JOB]);
        });

        $query1 = $base_query->with('client')->where('id', '<>', $job_id)->where('job_category_id', $job_category_id);
        $query2 = clone $query1;
        $query2->where('employment_status_id', $employment_status_id);
        $query3 = clone $query2;
        $query3->where('prefecture', $prefecture);

        if ($query3->getQuery()->count() >= $limit) {
            return $query3->take($limit)->get();
        }

        if ($query2->getQuery()->count() >= $limit) {
            return $query2->take($limit)->get();
        }

        return $query1->take($limit)->get();
    }

    public static function getPublishableJobs()
    {
        return self::with('client')
                ->where('can_publish', 1)
                ->whereHas('client', function($q) {
                    $q->where('can_publish', 1);
                })->get();
    }

    public function setRequestValues($req, $is_franchise = false)
    {
        $this->client_id = $req->client_id;
        $this->title = $req->title;
        $this->job_title = $req->job_title;
        $this->main_message = $req->main_message;
        $this->work_place = $req->work_place;
        $this->side_image1_caption = $req->side_image1_caption;
        $this->side_image2_caption = $req->side_image2_caption;
        $this->side_image3_caption = $req->side_image3_caption;
        $this->company_description = $req->company_description;
        $this->company_business = $req->company_business;
        $this->company_characteristics = $req->company_characteristics;
        $this->is_franchise = $is_franchise;
        $this->main_slide_flag = boolval($req->main_slide_flag);
        $this->pickup_flag = boolval($req->pickup_flag);
        if ($req->main_image_filename) {
            $this->main_image = $req->main_image_filename;
        }
        if ($req->side_image1_filename) {
            $this->side_image1 = $req->side_image1_filename;
        }
        if ($req->side_image2_filename) {
            $this->side_image2 = $req->side_image2_filename;
        }
        if ($req->side_image3_filename) {
            $this->side_image3 = $req->side_image3_filename;
        }

        $excludes = [Job::FUN_OF_LIFE, Job::PRIVATE_JOB];

        if (in_array($this->client_id, $excludes)) {
            $this->random = mt_rand(1, 10000) * 10000;
        } else {
            $this->random = mt_rand(1, 10000);
        }

        if ($is_franchise) {
            $this->setFranchiseJobValues($req);
        } else {
            $this->setStandardJobValues($req);
        }

        return $this;
    }

    protected function setStandardJobValues($req)
    {
        $this->job_category_id = $req->job_category_id;
        $this->employment_status_id = $req->employment_status_id;
        $this->business_type_id = $req->business_type_id;

        $this->job_description = $req->job_description;
        $this->background = $req->background;
        $this->qualification = $req->qualification;
        $this->prefecture = $req->prefecture;
        $this->work_hour = $req->work_hour;
        $this->salary = $req->salary;
        $this->benefit = $req->benefit;
        $this->holiday = $req->holiday;
    }

    protected function setFranchiseJobValues($req)
    {
        $this->job_category_id = JobCategory::Other;
        $this->employment_status_id = EmploymentStatus::Franchise;
        $this->business_type_id = $req->business_type_id;
        $this->fr_about_product = $req->fr_about_product;
        $this->fr_about_market = $req->fr_about_market;
        $this->fr_pre_support = $req->fr_pre_support;
        $this->fr_post_support = $req->fr_post_support;
        $this->fr_flow_to_open = $req->fr_flow_to_open;
        $this->fr_business_model = $req->fr_business_model;
        $this->fr_contract_type = $req->fr_contract_type;
        $this->fr_contract_period = $req->fr_contract_period;
        $this->fr_initial_fund_amount = $req->fr_initial_fund_amount;
        $this->fr_royalty = $req->fr_royalty;
        $this->fr_seminar_info = $req->fr_seminar_info;
    }

    public function saveWithTags($tag_list)
    {
        $ret1 = $this->save();
        $ret2 = true;

        if ($tag_list) {
            $ret2 = $this->tags()->sync($tag_list);
        }

        if ($ret1 && $ret2) {
            return true;
        }

        return false;
    }

    public function saveClientJob($req)
    {
        return DB::transaction(function () use ($req) {
            $custom_s3 = new S3();

            if ($main_image = $req->file('main_image')) {
                $filename = $custom_s3->uploadMainImage($main_image);
                $this->main_image = $filename == false ? null : $filename;
            }

            if ($side_image1 = $req->file('side_image1')) {
                $filename = $custom_s3->uploadSideImage($side_image1);
                $this->side_image1 = $filename == false ? null : $filename;
            }

            if ($side_image2 = $req->file('side_image2')) {
                $filename = $custom_s3->uploadSideImage($side_image2);
                $this->side_image2 = $filename == false ? null : $filename;
            }

            if ($side_image3 = $req->file('side_image3')) {
                $filename = $custom_s3->uploadSideImage($side_image3);
                $this->side_image3 = $filename == false ? null : $filename;
            }

            $ret = $this->saveWithTags($req->tag_id);

            return $ret;
        });
    }

    public function hasAppliedBy($customer)
    {
        if (!$customer) {
            return false;
        }

        $this->load('applications');
        if ($this->applications->count() == 0) {
            return false;
        }

        return $this->applications->where('customer_id', $customer->id)->count() > 0;
    }

    public function hasFavoredBy($customer)
    {
        if (!$customer) {
            return false;
        }

        $this->load('favorites');
        if ($this->favorites->count() == 0) {
            return false;
        }

        return $this->favorites->where('customer_id', $customer->id)->count() > 0;
    }

}