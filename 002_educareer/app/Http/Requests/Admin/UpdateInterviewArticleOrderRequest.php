<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

class UpdateInterviewArticleOrderRequest extends Request
{
    public function __construct(ValidationFactory $validationFactory)
    {
        // orderが配列形式で、かつ、1件以上含まれるか
        $validationFactory->extend(
            'is_array',
            function ($attribute, $value, $parameters) {
                return (is_array($value) && count($value) !== 0);
            }
        );

        // orderの値が重複していないか
        $validationFactory->extend(
            'order_unique',
            function ($attribute, $value, $parameters) {
                $orders = [];

                foreach ($value as $id => $order) {
                    // $orderの値が0またはnullの場合はバリデーション対象ではない
                    if (!$order) {
                        continue;
                    }

                    if (in_array($order, $orders)) {
                        // $orderに重複している値がある場合はバリデーションエラー
                        return false;
                    } else {
                        $orders[] = $order;
                    }
                }

                return true;
            }
        );
    }

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
            'order' => 'required|is_array|order_unique',
        ];
    }

    public function messages()
    {
        return [
            'order.required' => '値が入力されていません。',
            'order.is_array' => '値の形式が不正です。',
            'order.order_unique' => '順番が重複しています。',
        ];
    }
}
