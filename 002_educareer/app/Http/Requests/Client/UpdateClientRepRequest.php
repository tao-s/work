<?php namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

class UpdateClientRepRequest extends Request
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
            'email' => 'email|unique:client_reps,email,'.$this->get('client_rep_id'),
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'メールアドレスの形式が不正です。',
            'email.unique' => 'このメールアドレスは既に登録されています。'
        ];
    }

}
