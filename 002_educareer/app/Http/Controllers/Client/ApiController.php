<?php namespace App\Http\Controllers\Client;

use App\ApplicationCheck;
use DB;
use Log;
use Mail;
use Auth;
use Config;
use App\Job;
use App\Upgrade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiController extends Controller {

    public function shouldUpgrade(Request $req, $id)
    {
        if (!$req->ajax()) {
            abort(404);
        }

        // 2016/1/31〜は無料プランでも作り放題なので常に'0'（アップグレード不要）を返す
        return '0';

//        $postings = Job::where('client_id', $id)->get();
//        $upgrade = Upgrade::where('client_id', $id)->get();
//
//        // 求人を1つ以上作成していて、無料プランの場合、アップグレードすべき
//        if (count($postings) > 0 && $upgrade->count() == 0) {
//            return '1';
//        }
//
//        return '0';
	}

    public function shouldPublish(Request $req, $id)
    {
        if (!$req->ajax()) {
            abort(404);
        }

        // 2016/1/31〜は無料プランでも作り放題なので常に'0'（アップグレード不要）を返す
        return '0';

//        $postings = Job::where('client_id', $id)->where('can_publish', true)->get();
//        $upgrade = Upgrade::where('client_id', $id)->get();
//
//        // 公開可能求人が1つ以上あり、無料プランの場合、新たな求人の公開は不可
//        if (count($postings) > 0 && $upgrade->count() == 0) {
//            return '0';
//        }
//
//        return '1';
    }

    public function canCheckDetail(Request $req, $app_id)
    {
        if (!$req->ajax()) {
            abort(404);
        }

        // 2016/1/31〜は無料プランでも作り放題なので常に'0'（アップグレード不要）を返す
        return '0';

//        $client_id = Auth::client()->get()->id;
//        $app = ApplicationCheck::where('application_id', $app_id)->where('client_id', $client_id)->get();
//        $app_checks = ApplicationCheck::where('client_id', $client_id)->count();
//        $upgrade = Upgrade::where('client_id', $client_id)->get();
//
//        // 1. 無料プランのクライアント
//        // 2. 10件以上の応募を見ている
//        // 3. 対象の応募はまだ見たことがない
//        // => この条件が当てはまった場合、新たな応募の閲覧は許可しない
//        if ($upgrade->count() == 0 && $app_checks >= 10 && $app->count() == 0) {
//            return '0';
//        }
//
//        return '1';
    }
}