{{ $client['company_name'] }}
ご担当者様

Education Careerをご利用いただきありがとうございます。

「{{ $job['title'] }}」に{{ $customer['profile']['username'] }}様から応募がありました。
応募から{{ $hours }}時間が経過しています。
早期のご連絡が採用成功の鍵ですので、ご対応下さいませ。

以下URLより、応募者の管理が可能です。
https://client.education-career.jp/application

※ ご連絡済みの場合でも管理画面でステータスに変化がない場合、本メールは自動で配信されます。
※ このお知らせはカスタマーの応募から24時間、48時間、72時間が経過した際に自動で配信されます。

@include('emails.client.footer')