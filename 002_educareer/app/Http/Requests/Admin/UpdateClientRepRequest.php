<?php namespace App\Http\Requests\Admin;

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
            'client_id' => 'required|exists:clients,id',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'クライアントを選択してください。',
            'client_id.exists' => 'このクライアントは存在しません。',
        ];
    }

}
