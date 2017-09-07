<?php namespace App\Http\Requests\Customer;

use Auth;
use Hash;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Http\Requests\Request;

class UpdateCustomerPasswordRequest extends Request
{

    public function __construct(ValidationFactory $validationFactory)
    {

        // custom validation rule
        $validationFactory->extend(
            'password_correct',
            function ($attribute, $value, $parameters) {
                $password = Auth::customer()->get()->password;

                return Hash::check($value, $password);
            },
            'Customize this message in message() method.'
        );
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required|password_correct',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => '現在のパスワードを入力して下さい。',
            'current_password.password_correct' => '現在のパスワードが間違っています。',
            'password.required' => '新しいパスワードを入力してください。',
            'password.confirmed' => 'パスワードがマッチしません。',
            'password.min' => 'パスワードは:min文字以上に設定して下さい。',
            'password_confirmation.required' => '新しいパスワード（確認用）を入力して下さい。'
        ];
    }

}
