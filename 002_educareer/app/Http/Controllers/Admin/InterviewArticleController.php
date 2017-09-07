<?php namespace App\Http\Controllers\Admin;

use DB;
use View;
use App\InterviewArticle;
use App\Client;
use App\Custom\S3;
use App\Custom\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInterviewArticleRequest;
use App\Http\Requests\Admin\UpdateInterviewArticleRequest;
use App\Http\Requests\Admin\UpdateInterviewArticleOrderRequest;
use App\Http\FormData\Admin\InterviewArticleFormData;

class InterviewArticleController extends Controller
{
    public function __construct()
    {
        View::share('module_key', 'interview');
    }

    public function index()
    {
        $interviews = InterviewArticle::with('client')->paginate(100);
        return view('admin.interview.index')->with(compact('interviews'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('admin.interview.create')->with(compact('clients'));
    }

    public function store(StoreInterviewArticleRequest $req)
    {
        $interview = new InterviewArticle();
        $interview->title = $req->title;
        $interview->url = $req->url;
        $interview->client_id = $req->client_id;

        $custom_s3 = new S3();
        $filename = $custom_s3->uploadInterviewImage($req->file('image'));
        $flash = new FlashMessage();

        if (!$filename) {
            $flash->type('danger');
            $flash->message('インタビュー記事の保存に失敗しました。');
            return redirect()->back()->with('flash_msg', $flash);
        }

        $interview->image = $filename;
        $ret = $interview->save();

        if (!$ret) {
            $flash->type('danger');
            $flash->message('インタビュー記事の保存に失敗しました。');
            return redirect()->back()->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message('インタビュー記事の保存に成功しました。');
        return redirect('/interview')->with('flash_msg', $flash);
    }

    public function edit(InterviewArticleFormData $data, $id)
    {
        $interview = InterviewArticle::where('id', $id)->first();
        $data->load($interview);

        $clients = Client::all();
        $interview_image_path = S3::getInterviewImagePath();
        return view('admin.interview.edit')->with(compact('interview', 'clients', 'data', 'interview_image_path'));
    }

    public function update(UpdateInterviewArticleRequest $req, $id)
    {
        $interview = InterviewArticle::where('id', $id)->first();
        $interview->title = $req->title;
        $interview->url = $req->url;
        $interview->client_id = $req->client_id;

        $flash = new FlashMessage();
        if ($req->file('image')) {
            $custom_s3 = new S3();
            $filename = $custom_s3->uploadInterviewImage($req->file('image'));


            if (!$filename) {
                $flash->type('danger');
                $flash->message('インタビュー記事の保存に失敗しました。');
                return redirect()->back()->with('flash_msg', $flash);
            }

            $interview->image = $filename;
        }

        $ret = $interview->save();

        if (!$ret) {
            $flash->type('danger');
            $flash->message('インタビュー記事の保存に失敗しました。');
            return redirect()->back()->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message('インタビュー記事の保存に成功しました。');
        return redirect('/interview')->with('flash_msg', $flash);

    }

    public function destroy($id)
    {
        $interview = InterviewArticle::where('id', $id);

        $flash = new FlashMessage();
        if (!$interview->delete()) {
            $flash->type('danger');
            $flash->message("インタビュー記事の削除に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/interview')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message("インタビュー記事の削除に成功しました。");
        return redirect('/interview')->with('flash_msg', $flash);
    }

    public function update_order(UpdateInterviewArticleOrderRequest $req)
    {
        $flash = new FlashMessage();

        if (!InterviewArticle::updateOrder($req->order)) {
            $flash->type('danger');
            $flash->message("インタビュー記事の順番の保存に失敗しました。システム管理者にお問い合わせ下さい。");
            return redirect('/interview')->with('flash_msg', $flash);
        }

        $flash->type('success');
        $flash->message('インタビュー記事の順番の保存に成功しました。');
        return redirect('/interview')->with('flash_msg', $flash);
    }
}
