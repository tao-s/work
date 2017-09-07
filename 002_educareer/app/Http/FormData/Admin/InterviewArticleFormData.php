<?php namespace App\Http\FormData\Admin;

use App\Http\FormData\FormData;

class InterviewArticleFormData extends FormData
{

    protected function set_data($data)
    {
        $this->data = $data;
    }

    public function image()
    {
        return '';
    }

    protected function old($key)
    {
        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return null;
    }
}