<?php namespace App\Http\Requests\Client;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class StoreJobRequest extends Request
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
            'title' => 'required',
            'job_category_id' => 'required',
            'job_title' => 'required',
            'employment_status_id' => 'required',
            'business_type_id' => 'required',
            'prefecture' => 'required',
        ];
    }

    public function messages()
    {
        return array(
            'title.required' => 'タイトルを入力してください。',
            'job_category_id.required' => '職種カテゴリーを選択してください。',
            'job_title.required' => '職種タイトルを入力してください。',
            'employment_status_id.required' => '働き方を選択してください。',
            'business_type_id.required' => '業態を選択してください。',
            'prefecture.required' => '勤務地（都道府県）を選択してください。',
        );
    }

}
