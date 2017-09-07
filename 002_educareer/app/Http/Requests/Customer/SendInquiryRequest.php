<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;

class SendInquiryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return array(
            'name.required' => 'お名前を入力して下さい。',
            'email.required' => 'メールアドレスを入力して下さい。',
            'subject.required' => '件名を入力して下さい。',
            'body.required' => 'お問い合わせ内容を入力して下さい。',

        );
    }

}
