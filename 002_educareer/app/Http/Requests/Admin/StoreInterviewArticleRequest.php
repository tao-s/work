<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class StoreInterviewArticleRequest extends Request
{

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
            'client_id' => 'required|exists:clients,id',
            'title' => 'required',
            'url' => 'required|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,bmp,svg',
        ];
    }

    public function messages()
    {
        return array(
            'client_id.required' => 'クライアントを選択してください。',
            'client_id.exists' => '存在しないクライアントです。',
            'title.required' => '記事タイトルを入力してください。',
            'url.required' => 'URLを入力してください。',
            'url.url' => '「http(s)://」から始まる正しいURLを入力してください。',
            'image.required' => '画像を選択してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => 'ファイルの拡張子は次のものにしてください: jpeg, jpg, png, bmp, gif, svg',
        );
    }

}
