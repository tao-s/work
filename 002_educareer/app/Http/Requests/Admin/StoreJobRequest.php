<?php namespace App\Http\Requests\Admin;

use App\Client;
use App\Http\Requests\Request;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Factory as ValidationFactory;

class StoreJobRequest extends Request
{
    public function __construct(ValidationFactory $validationFactory)
    {
        // jobsテーブルのmain_slide_flag|pickup_flag用バリデーション
        $validationFactory->extend(
            'job_can_publish',
            function ($attribute, $value, $parameters) {
                if ($value) { // flagがtrueの場合
                    // 新規作成時はjob.can_publishは常に0
                    return false;
                } else { // flagがfalseの場合はバリデーション不要
                    return true;
                }
            }
        );

        // jobsテーブルのmain_slide_flag|pickup_flag用バリデーション
        $validationFactory->extend(
            'client_can_publish',
            function ($attribute, $value, $parameters) {
                if ($value) { // flagがtrueの場合、job->client->can_publishが1である必要がある
                    $client = Client::find(intval($this->get('client_id')));

                    return ($client instanceof Client && $client->can_publish);
                } else { // flagがfalseの場合はバリデーション不要
                    return true;
                }
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
            'client_id' => 'required',
            'title' => 'required',
            'job_category_id' => 'required',
            'job_title' => 'required',
            'employment_status_id' => 'required',
            'business_type_id' => 'required',
            'prefecture' => 'required',
            'main_slide_flag' => 'job_can_publish|client_can_publish',
            'pickup_flag' => 'job_can_publish|client_can_publish',
        ];
    }

    public function messages()
    {
        return array(
            'client_id.required' => 'クライアントを選択してください。',
            'title.required' => 'タイトルを入力してください。',
            'job_category_id.required' => '職種カテゴリーを選択してください。',
            'job_title.required' => '職種タイトルを入力してください。',
            'employment_status_id.required' => '働き方を選択してください。',
            'business_type_id.required' => '業態を選択してください。',
            'prefecture.required' => '勤務地（都道府県）を選択してください。',
            'main_slide_flag.job_can_publish' => 'メインスライドに表示するには求人を公開状態にしてください。',
            'main_slide_flag.client_can_publish' => 'メインスライドに表示するにはクライアントを承認済みにしてください。',
            'pickup_flag.job_can_publish' => 'PICKUP求人に表示するには求人を公開状態にしてください。',
            'pickup_flag.client_can_publish' => 'PICKUP求人に表示するにはクライアントを承認済みにしてください。',
        );
    }

}
