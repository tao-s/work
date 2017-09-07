<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;

class UpdateCustomerAccountRequest extends Request
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
            'username' => 'required',
            'email' => 'required|email',
            'sex' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'prefecture' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'ユーザ名を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が不正です。',
            'sex.required' => '性別を入力してください。',
            'year.required' => '年を選択してください。',
            'month.required' => '月を選択してください。',
            'day.required' => '日を選択してください。',
            'prefecture.required' => '都道府県を選択してください。',
            'phone.required' => '電話番号を入力してください。',
        ];
    }

}
