<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerProfile extends Model {

    protected $table = 'customer_profiles';
    protected $fillable = ['username', 'sex', 'birthday', 'prefecture', 'school_record_id', 'school_name', 'graduate_year', 'job_record'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function school_record()
    {
        return $this->belongsTo('App\SchoolRecord');
    }

    public function industry_types()
    {
        return $this->belongsToMany(IndustryType::class);
    }

    public function occupation_categories()
    {
        return $this->belongsToMany(OccupationCategory::class);
    }

    protected $dates = array('birthday');

    public function getGender() {
        if ($this->sex == 1) {
            return '男性';
        }
        return '女性';
    }

    public function formatBirthday($format = 'Y-m-d') {
        return (new \DateTime($this->birthday))->format($format);
    }

    /**
     * @param int $index
     * @param int $industry_type_id
     * @return bool
     */
    public function hasIndustryType($index, $industry_type_id)
    {
        if (isset($this->industry_types[$index])) {
            return $this->industry_types[$index]['id'] == $industry_type_id;
        } else {
            return false;
        }
    }

    /**
     * @param int $index
     * @return int|null
     */
    public function occupationCategoryId($index)
    {
        if (isset($this->occupation_categories[$index])) {
            return $this->occupation_categories[$index]['id'];
        } else {
            return null;
        }
    }

    /**
     * @param int $index
     * @return string
     */
    public function occupationCategoryFreeWord($index)
    {
        $categories = $this->occupation_categories()->withPivot(['free_word'])->get()->toArray();

        if (isset($categories[$index])) {
            return $categories[$index]['pivot']['free_word'];
        } else {
            return '';
        }
    }

    /**
     * @return array
     */
    public function occupationCategoryNames()
    {
        $categories = $this->occupation_categories()->withPivot(['free_word'])->get();
        $result = [];

        /** @var OccupationCategory $category */
        foreach ($categories as $category) {
            $result[] = $category->nameWithParentCategory($category->pivot->free_word);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function workLocationName()
    {
        $prefectures = \Config::get('prefecture');
        $prefectures['48'] = '海外';

        if (isset($prefectures[$this->work_location_id])) {
            return $prefectures[$this->work_location_id];
        } else {
            '';
        }
    }
}
