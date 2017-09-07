<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    const StatusFreePlan = '無料プラン';
    const StatusWatingForApproval = '承認待ち';
    const StatusApproved = '承認済み';
    const StatusNearExpire = '期限切れ間近';
    const StatusExpired = '期限切れ';


    protected $table = 'clients';

    public function upgrade()
    {
        return $this->hasOne('App\Upgrade');
    }

    public function application_checks()
    {
        return $this->hasMany('App\ApplicationCheck');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public static function getPublishableClients()
    {
        return self::where('can_publish', true)->get();
    }

    /**
     * フランチャイズ求人を行えるか
     *
     * @return bool
     */
    public function canPublishFranchise()
    {
        if (is_null($this->upgrade)) {
            return false;
        }

        return (bool)$this->upgrade->plan->franchise;
    }

    public function getStatusLabel()
    {
        if (is_null($this->upgrade)) {
            return self::StatusFreePlan;
        }

        if ($this->upgrade->getStatusLabel() == Upgrade::StatusNotApproved) {
            return self::StatusWatingForApproval;
        }

        return $this->upgrade->getStatusLabel();
    }

    public function shouldShowUpgradeButton()
    {
        if ($this->getStatusLabel() == self::StatusWatingForApproval || $this->getStatusLabel() == self::StatusApproved) {
            return false;
        }

        return true;
    }

    public function getPlanName()
    {
        $upgrade = Upgrade::with('plan')
            ->where('client_id', $this->id)
            ->where('is_approved', 1)
            ->where('deleted_at', null)
            ->first();
        return $upgrade->plan->plan_name;
    }

    public function getPlanExpireDate()
    {
        $upgrade = Upgrade::where('client_id', $this->id)
            ->where('is_approved', 1)
            ->where('deleted_at', null)
            ->first();
        return $upgrade->expire_date->format('Y年m月d日');
    }

    /**
     * @deprecated 2016/1/23 現在使用されていない
     * @return int
     */
    public function getRemainingJobCreations()
    {
        $diff = 1 - Job::where('client_id', $this->id)->count();
        return $diff >= 0 ? $diff : 0;
    }

    /**
     * @deprecated 2016/1/23 現在使用されていない
     * @return int
     */
    public function getRemainingJobPublications()
    {
        $diff = 1 - Job::where('client_id', $this->id)->where('can_publish', 1)->count();
        return $diff >= 0 ? $diff : 0;
    }

    /**
     * @deprecated 2016/1/23 現在使用されていない
     * @return int
     */
    public function getRemainingApplicationChecks()
    {
        return 10 - self::select('*')->whereHas('application_checks', function($q) {
            $q->where('client_id', $this->id);
        })->count();
    }

    /**
     * @depracated 2016/1/30 現在使用されていない
     * @return bool
     */
    public function canPublishAnotherJob()
    {
        $this->load('upgrade')->load('jobs');
        if (!$this->upgrade) {
            return $this->jobs->where('can_publish', 1)->count() == 0;
        }

        return true;
    }

}
