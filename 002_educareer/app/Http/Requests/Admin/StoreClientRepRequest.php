<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class StoreClientRepRequest extends Request
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
            'email' => 'required|unique:client_reps|email',
            'client_id' => 'required|exists:clients,id'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスはすでに登録されています。',
            'email.email' => 'メールアドレスの形式が不正です。',
            'client_id.required' => 'クライアントを選択して下さい。',
            'client_id.exists' => 'このクライアントは存在しません。',
        ];
    }

}
