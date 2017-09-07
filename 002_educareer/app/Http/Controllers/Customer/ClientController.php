<?php namespace App\Http\Controllers\Customer;

use DB;
use Mail;
use Auth;
use App\Custom\FlashMessage;
use App\Admin;
use App\Client;
use App\ClientRep;
use App\ClientRepConfirmation;
use App\Upgrade;
use App\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\StoreClientRequest;

class ClientController extends BaseCustomerController
{

    public function index(Request $req)
    {
        return view($this->template('client.index'));
    }

    public function entry()
    {
        return view($this->template('client.entry'));
    }

    public function completed()
    {
        return view($this->template('client.completed'));
    }

    public function store(StoreClientRequest $req)
    {
        $rep = DB::transaction(function() use($req) {
            $client = new Client();
            $upgrade = new Upgrade();
            $rep = new ClientRep();

            $client->company_name = $req->company_name;
            $client->company_id = $req->company_id;
            $client->url = $req->company_url;
            $ret1 = $client->save();

            $ret2 = $upgrade->saveWithEndOfJanSetting($req->company_name, $client->id);

            $rep->client_id = $client->id;
            $rep->email = $req->email;
            $rep->phone = $req->phone;
            $rep->name = $req->name;
            $ret3 = $rep->save();

            if ($ret1 && $ret2 && $ret3) {
                return $rep;
            }

            return null;
        });

        $flash = new FlashMessage();
        if (!$rep) {
            $flash->type('error');
            $flash->message("法人アカウントの申請に失敗しました。お手数をおかけいたしますが、しばらくしてから再度ご送信ください。");
            return redirect('/recruiter/completed')->with('flash_msg', $flash);
        }

        $confirm = new ClientRepConfirmation();
        $confirm->client_rep_id = $rep->id;
        $confirm->saveWithOnetimeUrl();
        // @mail 掲載申込みのお知らせ to Client
        $data = ['name' => $rep->name, 'company_name' => $req->company_name, 'url' => route('client.confirm') . '/' . $confirm->confirmation_token];
        $email = $req->email;
        Mail::queue(['text' => 'emails.client.client_registered'], $data, function($message) use ($email) {
            $message->from('info@education-career.jp')
                ->to($email)
                ->subject('【Education Career】掲載のお申し込みありがとうございます');
        });

        // @mail 掲載申込みのお知らせ to Admin
        $data = ['company_name' => $req->company_name];
        $emails = Admin::getAllAdminEmails();
        Mail::queue(['text' => 'emails.admin.client_registered'], $data, function($message) use ($emails) {
            $message->from('info@education-career.jp')
                ->to($emails)
                ->subject('【Education Career】掲載の申し込みがありました');
        });

        $flash->type('success');
        $flash->message("法人アカウントの申請に成功しました。");
        return redirect('/recruiter/completed')->with('flash_msg', $flash);
    }

}