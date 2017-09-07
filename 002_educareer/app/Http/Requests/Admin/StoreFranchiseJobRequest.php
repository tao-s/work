<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class StoreFranchiseJobRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required',
            'title' => 'required',
            'job_title' => 'required',
            'business_type_id' => 'required',
        ];
    }

    public function messages()
    {
        return array(
            'client_id.required' => 'クライアントを選択してください。',
            'title.required' => '募集タイトルを入力してください。',
            'job_title.required' => '職種タイトルを入力してください。',
            'business_type_id.required' => '業態を選択してください。',
        );
    }

}
