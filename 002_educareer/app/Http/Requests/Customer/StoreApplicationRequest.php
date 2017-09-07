<?php namespace App\Http\Requests\Customer;

use App\Customer;
use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

use Auth;
use App\Application;

class StoreApplicationRequest extends Request
{

    public function __construct(ValidationFactory $validationFactory)
    {
        // custom validation rule
        $validationFactory->extend(
            'not_yet_applied',
            function ($attribute, $value, $parameters) {
                $job_id = $value;
                $customer = Auth::customer()->get();

                if ($customer instanceof Customer) {
                    $customer_id = $customer->id;
                } else {
                    return true;
                }

                $app = Application::where('job_id', $job_id)->where('customer_id', $customer_id)->get();

                return $app->count() === 0;
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
            'job_id' => 'not_yet_applied',
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
            'job_id.not_yet_applied' => 'この求人には既に応募しています。',
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
