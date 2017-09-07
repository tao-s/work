<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

use Auth;
use App\Favorite;

class StoreAgentProfileInfoRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'sex' => 'required|in:1,2',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'prefecture' => 'required',
        ];
    }

    public function messages()
    {
        return array(
            'username.required' => '名前を入力して下さい。',
            'sex.required' => '性別を選択して下さい。',
            'sex.in' => '男性または女性を選択して下さい。',
            'year.required' => '年を選択して下さい。',
            'month.required' => '月を選択して下さい。',
            'day.required' => '日を選択して下さい。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が不正です。',
            'phone.required' => '電話番号を入力してください。',
            'prefecture.required' => '都道府県を入力してください。',
        );
    }

}
