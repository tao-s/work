<?php namespace App\Http\Controllers\Customer;

use Zendesk;
use App\Custom\FlashMessage;
use App\Http\Requests\Customer\SendInquiryRequest;

class StaticController extends BaseCustomerController
{

    public function educareer()
    {
        return view($this->template('static.educareer'));
    }

    public function terms()
    {
        return view($this->template('static.terms'));
    }

    public function policy()
    {
        return view($this->template('static.policy'));
    }

    public function contact()
    {
        return view($this->template('static.contact'));
    }

    public function send(SendInquiryRequest $req)
    {
        $query = [
            'subject' => $req->subject,
            'comment' => [
                'body' => $req->body
            ],
            'requester' => [
                'name' => $req->name,
                'email' => $req->email,
                'company' => $req->company,
                'tel' => $req->tel,
                'url' => $req->url
            ]
        ];
        Zendesk::tickets()->create($query);

        $flash = new FlashMessage();
        $flash->type('success');
        $flash->message("お問い合わせいただきありがとうございます。お問い合わせは正常に受付しました。");

        return redirect()->back()->with('flash_msg', $flash);
    }

}
