<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

use Auth;
use App\Favorite;

class StoreCustomerProfileRequest extends Request
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
            'prefecture' => 'required',
            'graduate_year' => 'digits:4',
            'password' => 'sometimes|required|confirmed|min:8',
            'password_confirmation' => 'sometimes|required',
            'phone' => 'required',
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
            'prefecture.required' => '都道府県を選択して下さい。',
            'graduate_year.digits' => '卒業年度には:digits桁の数字のみ入力して下さい。',
            'password.required' => 'パスワードを入力して下さい。',
            'password.confirmed' => 'パスワードがマッチしません。',
            'password.min' => 'パスワードは:min文字以上に設定して下さい。',
            'password_confirmation.required' => 'パスワード（確認用）を入力して下さい。',
            'phone.required' => '電話番号を入力してください。',
        );
    }

}
