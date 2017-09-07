<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class ReActivationRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|exists:customers,email|email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください。',
            'email.exists' => 'このメールアドレスはシステムに登録されていないので、登録手続用メールの再送信が行えません。',
            'email.email' => 'メールアドレスの形式が不正です。'
        ];
    }

}
