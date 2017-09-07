<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use App\Customer;
use Illuminate\Validation\Factory as ValidationFactory;


class StoreCustomerRequest extends Request
{

    public function __construct(ValidationFactory $validationFactory)
    {
        // custom validation rule
        $validationFactory->extend(
            'not_member',
            function ($attribute, $value, $parameters) {
                $email = $value;
                $customer = Customer::where('email', $email)->where('is_activated', 1)->where('deleted_at', null)->get();

                // アクティベートされていて、未退会のemailが存在している場合、NG
                if ($customer->count() > 0) {
                    return false;
                }

                return true;
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
            'email' => 'required|email|not_member',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return array(
            'email.required' => 'メールアドレスを入力して下さい。',
            'email.email' => 'メールアドレスの形式が不正です。',
            'email.not_member' => 'このメールアドレスはすでに登録されています。',
            'password.required' => '新しいパスワードを入力してください。',
            'password.confirmed' => 'パスワードがマッチしません。',
            'password.min' => 'パスワードは:min文字以上に設定して下さい。',
            'password_confirmation.required' => '新しいパスワード（確認用）を入力して下さい。'
        );
    }

}
