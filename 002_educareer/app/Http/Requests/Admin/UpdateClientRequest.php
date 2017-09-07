<?php namespace App\Http\Requests\Admin;

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
        $id = $this->route('client');
        return [
            'company_name' => 'required|unique:clients,company_name,'.$id,
            'company_id' => 'required|unique:clients,company_id,'.$id,
            'url' => 'url',
            'plan' => 'required',
            'plan_update' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => '会社名を入力してください。',
            'company_name.unique' => 'この会社名は既に登録されています。',
            'company_id.required' => '会社IDを入力してください。',
            'url.url' => '「http(s)://」から始まる正しいURLを入力してください。',
            'plan.required' => 'プランを選択してください。',
            'plan_update.boolean' => '不正な値です',
        ];
    }

}
