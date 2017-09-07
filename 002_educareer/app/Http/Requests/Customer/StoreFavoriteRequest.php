<?php namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

use Auth;
use App\Favorite;

class StoreFavoriteRequest extends Request
{

    public function __construct(ValidationFactory $validationFactory)
    {

        // custom validation rule
        $validationFactory->extend(
            'not_yet_favored',
            function ($attribute, $value, $parameters) {
                $job_id = $value;
                $customer_id = Auth::customer()->get()->id;
                $app = Favorite::where('job_id', $job_id)->where('customer_id', $customer_id)->get();

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
            'job_id' => 'not_yet_favored',
        ];
    }

    public function messages()
    {
        return array(
            'job_id.not_yet_favored' => 'この求人は既にお気に入りに登録されています。'
        );
    }

}
