<?php namespace App\Http\Requests\Client;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class UpdateClientRequest extends Request
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
        $id = Auth::client()->get()->client_id;
        return [
            'company_name' => 'required|unique:clients,company_name,'.$id,
            'company_id' => 'required|unique:clients,company_id,'.$id,
            'url' => 'url',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => '会社名を入力してください。',
            'company_name.unique' => 'この会社名は既に登録されています。',
            'company_id.required' => '会社IDを入力してください。',
            'company_id.unique' => '会社IDは既に登録されています。',
            'url.url' => '「http(s)://」から始まる正しいURLを入力してください。'
        ];
    }

}
