<?php namespace App\Http\Requests\Customer;

use Auth;
use Hash;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Http\Requests\Request;

class DeleteCustomerRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|in:'.Auth::customer()->get()->id,
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => '不正なアクセスを検出しました。再度ページをリロードし、操作をやり直してください。',
            'customer_id.in' => '不正なアクセスを検出しました。再度ページをリロードし、操作をやり直してください。'
        ];
    }

}
