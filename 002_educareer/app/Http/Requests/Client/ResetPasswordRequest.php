<?php namespace App\Http\Requests\Client;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class ResetPasswordRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:client_reps,email|email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください。',
            'email.exists' => 'このメールアドレスはシステムに登録されていません。',
            'email.email' => 'メールアドレスの形式が不正です。'
        ];
    }

}
