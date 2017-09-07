<?php namespace App\Http\FormData\Admin;

use App\Http\FormData\FormData;

class EditCustomerProfileFormData extends FormData
{

    protected function set_data($data)
    {
        $this->data = $data;
    }

    public function year()
    {
        if ($this->data->birthday) {
            return $this->data->birthday->year;
        }

        return '';
    }

    public function month()
    {
        if ($this->data->birthday) {
            return $this->data->birthday->month;
        }

        return '';
    }

    public function day()
    {
        if ($this->data->birthday) {
            return $this->data->birthday->day;
        }

        return '';
    }

}