<?php namespace App\Http\FormData\Admin;

use App\Http\FormData\FormData;

class CreateJobFormData extends FormData
{

    protected function set_data($data)
    {
        $this->data = $data;
    }

    public function tags()
    {
        if (isset($this->data['tags'])) {
            return $this->data['tags'];
        }

        return [];
    }

    protected function old($key)
    {
        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return null;
    }
}