<?php namespace App\Http\Controllers\Customer;

use DB;
use Log;
use Mail;
use Auth;
use Config;
use App\Job;
use App\Favorite;
use App\Custom\FlashMessage;
use App\Custom\S3;

use Illuminate\Http\Request;
use App\Http\Requests\Customer\StoreFavoriteRequest;
use App\Http\Controllers\Controller;

class FavoriteController extends BaseCustomerController
{

    public function index()
    {
        $customer_id = Auth::customer()->get()->id;
        $favs = Favorite::where('customer_id', $customer_id)->with('job.client')->paginate(10);
        $thumbnail_path = S3::getJobThumnbNailPath();
        return view($this->template('mypage.favorite'))->with(compact(
          'favs',
          'thumbnail_path'
        ));
    }

    public function store(StoreFavoriteRequest $req)
    {
        $job = Job::where('id', $req->job_id)->first();
        if (!$job) {
            abort(404);
        }

        $fav = new Favorite();
        $fav->customer_id = Auth::customer()->get()->id;
        $fav->job_id = $job->id;
        $fav->save();

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('求人をお気に入り登録しました。');

        return redirect()->back()->with('flash_msg', $flash);;
    }

    public function destroy($id)
    {
        $fav = Favorite::where('id', $id)->first();
        $fav->delete();

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message('お気に入りを削除しました。');

        return redirect()->back()->with('flash_msg', $flash);;
    }

}
