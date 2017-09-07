<?php namespace App\Http\Requests\Client;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

class StoreUpgradeRequest extends Request
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
            'company_name' => 'required',
            'plan_id' => 'required|exists:plans,id',
            'ceo' => 'required',
            'post_code' => 'required',
            'address' => 'required',
            'agreement' => 'required',
        ];
    }

    public function messages()
    {
        return array(
            'company_name.required' => '会社名を入力してください。',
            'plan_id.required' => 'プランを選択してください。',
            'plan_id.exists' => '不正なプランです。再度申請を行ってください。',
            'ceo.required' => '代表名を入力してください。',
            'post_code.required' => '郵便番号を入力してください。',
            'address.required' => '住所を入力してください。',
            'agreement.required' => '利用規約にチェックを入れてください。',
        );
    }

}
