<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

use Auth;
use App\Favorite;

class UpdateCustomerProfileRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'graduate_year' => 'digits:4',
        ];
    }

    public function messages()
    {
        return array(
            'graduate_year.digits' => '卒業年度には:digits桁の数字のみ入力して下さい。',
        );
    }

}
