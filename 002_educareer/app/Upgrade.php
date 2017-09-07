<?php namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model {

    const StatusFreePlan = '無料プラン';
    const StatusNotApproved = '未承認';
    const StatusApproved = '承認済み';
    const StatusNearExpire = '期限切れ間近';
    const StatusExpired = '期限切れ';

    use SoftDeletes;

    protected $table = 'upgrades';
    protected $dates = ['expire_date'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function isExpired()
    {
        if (is_null($this->expire_date)) {
            return false;
        }

        return $this->expire_date < Carbon::today()->format('Y-m-d');
    }

    public function getStatusLabel()
    {
        if ($this->is_approved == 0) {
            return self::StatusNotApproved;
        }

        if ($this->isExpired()) {
            return self::StatusExpired;
        }

        if ($this->is_approved == 1) {
            return $this->plan->plan_name ?: self::StatusApproved;
        }

        return '申請なし';
    }

    public function saveWithEndOfJanSetting($company_name, $client_id)
    {
        $this->plan_id = Plan::EndOfJan;
        $this->company_name = $company_name;
        $this->client_id = $client_id;
        $this->ceo = '-';
        $this->post_code = '-';
        $this->address = '-';
        $this->expire_date = '2016-01-31';
        $this->is_approved = true;
        return $this->save();
    }

    /**
     * @param Plan $plan
     * @param Client $client
     * @param bool $doUpdatePlan
     * @return bool
     */
    public function saveWithPlanAndClient(Plan $plan, Client $client, $doUpdatePlan = true)
    {
        $this->company_name = $client->company_name;
        $this->client_id = $client->id;
        $this->ceo = '-';
        $this->post_code = '-';
        $this->address = '-';
        $this->is_approved = true;

        // プランを設定・変更する場合
        if ($this->plan_id != $plan->id) {
            $this->plan_id = $plan->id;
            $this->expire_date = $plan->getExpireDate();
        }

        // 「プランの有効期限を更新する」にチェックを入れた場合
        if ($doUpdatePlan) {
            $this->expire_date = $plan->getExpireDate();
        }

        return $this->save();
    }

    /**
     * @param string $format
     * @return string
     */
    public function getExpireDate($format = 'Y-m-d')
    {
        if ($this->expire_date) {
            return (new \DateTime($this->expire_date))->format($format);
        } else {
            return '-';
        }
    }
}