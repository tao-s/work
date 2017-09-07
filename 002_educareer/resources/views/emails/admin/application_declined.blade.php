新たに不採用となった案件の詳細を以下の通り通知します。

【カスタマー】
{{ $customer['profile']['username'] }} 様

【クライアント】
{{ $client['company_name'] }} 様

【求人】
{{ $job['title'] }}
https://education-caerer.jp/job/{{$job['id'] }}/detail

@include('emails.admin.footer')