<?php namespace App;

use App\EmploymentStatus;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Application extends Model {

    protected $table = 'applications';

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function status() {
        return $this->belongsTo('App\ApplicationStatus');
    }

    public function client_rep()
    {
        return $this->belongsTo(ClientRep::class, 'client_reps_id');
    }

    /**
     * 応募の担当者名を取得する
     * 担当者名が未設定の場合はemailを取得する
     *
     * @param int|null $limit 表示する文字数の上限 nullの場合は無制限
     * @return string
     */
    public function getAssignedRepName($limit = null)
    {
        if ($this->client_rep instanceof ClientRep) {
            return $this->client_rep->getNameOrEmail($limit);
        } else {
            return '';
        }
    }

    /**
     * フルタイムを除外して応募を取得する
     *
     * @param int $client_id
     * @param int $application_status_id
     * @param int $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getWithoutFullTimeByClientId($client_id, $application_status_id = null, $per_page = 10)
    {
        $q = self::with('job.employment_status')
            ->with('status')
            ->with('job.client')
            ->with('client_rep')
            ->whereHas('job.client', function(Builder $q) use ($client_id) {
                $q->where('client_id', $client_id);
            })
            ->whereHas('job.employment_status', function (Builder $q) {
                $q->where('id', '<>', EmploymentStatus::FullTime);
            });

        if ($application_status_id) {
            $q->where('status_id', '=', $application_status_id);
        }

        return $q->paginate($per_page);
    }
}
