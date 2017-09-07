<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

use Auth;
use App\Favorite;

class StoreClientRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name' => 'required|unique:clients',
            'company_id' => 'required|unique:clients|regex:/^[a-z0-9_-]+$/|max:100',
            'company_url' => 'required|url',
            'email' => 'required|email|unique:client_reps',
            'phone' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => '会社名を入力してください。',
            'company_name.unique' => 'この会社名は既に登録されています。',
            'company_id.required' => '会社IDを入力してください。',
            'company_id.unique' => 'この会社IDは既に登録されています。',
            'company_id.max' => '会社IDは:max以内で入力してください。',
            'company_id.regex' => '会社IDには半角小文字英数字、_（アンダースコア）、または-（ハイフン）を使用してください。',
            'company_url.required' => 'コーポレートサイトURLを入力してください。',
            'company_url.url' => '「http(s)://」から始まる正しいURLを入力してください。',
            'email.required' => '担当者メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が不正です。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'phone.required' => '担当者電話番号を入力してください。',
            'name.required' => '担当者名を入力してください。',
        ];
    }


}
