カスタマーから応募がありましたのでお知らせします。

【カスタマー】
{{ $customer['profile']['username'] }}様

【企業名】
{{ $job['client']['company_name'] }}

【求人(ID:{{ $job['id'] }})】
{{ $job['title'] }}

@include('emails.admin.footer')