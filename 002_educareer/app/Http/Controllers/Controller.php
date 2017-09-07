<?php namespace App\Http\Controllers;

use App\Custom\FlashMessage;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * コントローラーで共通に使用するメソッドを定義
 */
abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    /**
     * 指定したパスにリダイレクトし、成功のメッセージを表示する
     *
     * @param string $to      リダイレクト先のパス
     * @param string $message フラッシュメッセージ
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function success($to, $message)
    {
        return redirect($to)->with('flash_msg', new FlashMessage('success', $message));
    }

    /**
     * 指定したパスにリダイレクトし、エラーメッセージを表示する
     *
     * @param string $to      リダイレクト先のパス
     * @param string $message フラッシュメッセージ
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function error($to, $message)
    {
        return redirect($to)->with('flash_msg', new FlashMessage('danger', $message));
    }
}
