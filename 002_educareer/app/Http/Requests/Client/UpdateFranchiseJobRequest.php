<?php namespace App\Http\Requests\Client;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class UpdateFranchiseJobRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'job_title' => 'required',
            'business_type_id' => 'required',
            'prefecture' => 'required',
        ];
    }

    public function messages()
    {
        return array(
            'title.required' => '募集タイトルを入力してください。',
            'job_title.required' => '職種タイトルを入力してください。',
            'business_type_id.required' => '業態を選択してください。',
            'prefecture.required' => '勤務地（都道府県）を選択してください。',
        );
    }

}
