<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;
use App\Customer;

class StoreIpRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ip[1]' => 'ip',
            'ip[2]' => 'ip',
            'ip[3]' => 'ip',
            'ip[4]' => 'ip',
            'ip[5]' => 'ip',
            'ip[6]' => 'ip',
        ];
    }

    public function messages()
    {
        return array(
            'ip[1].ip' => 'IPアドレスを入力して下さい。',
            'ip[2].ip' => 'IPアドレスを入力して下さい。',
            'ip[3].ip' => 'IPアドレスを入力して下さい。',
            'ip[4].ip' => 'IPアドレスを入力して下さい。',
            'ip[5].ip' => 'IPアドレスを入力して下さい。',
            'ip[6].ip' => 'IPアドレスを入力して下さい。',
        );
    }

    protected function formatErrors(Validator $validator)
    {
        $errors = $validator->errors()->all();
        return array_unique($errors);
    }

}
