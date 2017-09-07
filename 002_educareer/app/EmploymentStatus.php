<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model {

    protected $table = 'employment_statuses';
    public $timestamps = false;

    const FullTime = 1;
    const PartTime = 2;
    const Entrust = 3;
    const Volunteer = 4;
    const Franchise = 5;
    const Other = 6;

    public static function seoTitle($employment_status_id)
    {
        switch ($employment_status_id) {
            case self::FullTime:
                return '正社員・契約社員';
                break;
            case self::PartTime:
                return 'パート・アルバイト・インターン';
                break;
            case self::Entrust:
                return '業務委託';
                break;
            case self::Volunteer:
                return 'プロボノ・ボランティア';
                break;
            case self::Franchise:
                return 'フランチャイズオーナー';
                break;
            case self::Other:
                return '';
                break;
            default:
                return '';
        }
    }

    public static function seoKeywords($employment_status_id)
    {
        switch ($employment_status_id) {
            case self::FullTime:
                return ',正社員,契約社員,フルタイム';
                break;
            case self::PartTime:
                return ',パート,アルバイト,インターン';
                break;
            case self::Entrust:
                return ',業務委託';
                break;
            case self::Volunteer:
                return ',プロボノ,ボランティア';
                break;
            case self::Franchise:
                return ',フランチャイズオーナー';
                break;
            case self::Other:
                return '';
                break;
            default:
                return '';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getWithoutFullTime()
    {
        return self::query()->where('id', '<>', self::FullTime)->get();
    }
}
