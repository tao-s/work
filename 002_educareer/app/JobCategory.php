<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model {

    protected $table = 'job_categories';
    public $timestamps = false;

    const Sales = 1;
    const Engineer = 2;
    const Designer = 3;
    const Marketing = 4;
    const Teacher = 5;
    const BackOffice = 6;
    const Clerk = 7;
    const Other = 8;

    public static function seoKeywords($job_category_id)
    {
        switch ($job_category_id) {
            case self::Sales:
                return ',営業';
                break;
            case self::Engineer:
                return ',エンジニア';
                break;
            case self::Designer:
                return ',デザイナ';
                break;
            case self::Marketing:
                return ',企画,マーケティング';
                break;
            case self::Teacher:
                return ',講師,教員,教室長';
                break;
            case self::BackOffice:
                return ',事務';
                break;
            case self::Other:
                return '';
                break;
            default:
                return '';
        }
    }

}
