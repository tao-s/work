<?php namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

class UpdateClientRepPasswordRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => '新しいパスワードを入力してください。',
            'password.confirmed' => 'パスワードがマッチしません。',
            'password.min' => 'パスワードは:min文字以上に設定して下さい。',
            'password_confirmation.required' => '新しいパスワード（確認用）を入力して下さい。'
        ];
    }

}
