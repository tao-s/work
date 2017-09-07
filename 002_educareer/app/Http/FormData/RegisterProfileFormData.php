<?php namespace App\Http\FormData;

use Auth;

class RegisterProfileFormData extends FormData
{

    protected function set_data($data)
    {
        $user = $data;
        if ($user) {
            $user->load('profile');
            $user->username = $user->profile->username;
            $user->sex = $user->profile->sex;
            $user->year = isset($user->profile->birthday) ? $user->profile->birthday->year : '';
            $user->month = isset($user->profile->birthday) ? $user->profile->birthday->month : '';
            $user->day = isset($user->profile->birthday) ? $user->profile->birthday->day : '';
            $user->prefecture = $user->profile->prefecture;
            $user->mail_magazine_flag = $user->profile->mail_magazine_flag;
            $user->scout_mail_flag = $user->profile->scout_mail_flag;
            $user->introduction = $user->profile->introduction;
            $user->school_record_id = $user->profile->school_record_id;
            $user->school_name = $user->profile->school_name;
            $user->graduate_year = $user->profile->graduate_year;
            $user->job_record = $user->profile->job_record;
            $user->skill = $user->profile->skill;
            $user->qualification = $user->profile->qualification;

            $industry_types = $user->profile->industry_types->toArray();
            $user->industry_type1 = isset($industry_types[0]['id']) ? $industry_types[0]['id'] : null;
            $user->industry_type2 = isset($industry_types[1]['id']) ? $industry_types[1]['id'] : null;

            $occupation_categories = $user->profile->occupation_categories()
                ->withPivot(['free_word'])
                ->get()
                ->toArray();

            for ($i = 0; $i <= 2; $i++) {
                if (isset($occupation_categories[$i])) {
                    $user->{'occupation_category' . ($i + 1)} = $occupation_categories[$i]['id'];
                    $user->{'occupation_category_free_word' . ($i + 1)} = $occupation_categories[$i]['pivot']['free_word'];
                } else {
                    $user->{'occupation_category' . ($i + 1)} = null;
                    $user->{'occupation_category_free_word' . ($i + 1)} = '';
                }
            }
        }

        $this->data = $user;
    }

    protected function old($key)
    {
        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return null;
    }
}