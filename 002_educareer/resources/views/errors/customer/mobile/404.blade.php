<!DOCTYPE html>
  <html lang="ja">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="keywords" content="転職,エントリー,転職情報,転職サイト,求人,求人情報" />
    <meta name="description" content="Education Career 教育業界に特化した求人サービス">

    <meta property="og:title" content="Education Career 教育業界に特化した求人サービス"/>
    <meta property="og:description" content="EducationCareerは教育業界に関心のあるすべての方に向けた求人サービスです。正社員や業務委託、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。"/>
    <meta property="og:image" content="{{ url('/') . '/images/og_image.jpg' }}"/>
    <meta property="og:url" content="{{ url('/') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="Education Career"/>

    <title>Education Career</title>
    <link rel="icon" href="/favicon.ico">
    <link href="/mobile/css/style.css" rel="stylesheet">
    <link href="/mobile/css/lib/slidebars/slidebars.css" rel="stylesheet">
    @yield('custom_css')
  </head>
  <body>

  <div id="sb-site" class="globalContainer">
    <div class="globalHeader">

      <div class="globalHeader__logo">
        <a href="{{ url('/') }}"><img src="/mobile/images/logo.png" alt="Education Career"></a>
      </div>

    </div>
    <div class="globalContents">
      <div class="globalViewport l-row">
        <div class="globalMain globalMain--narrow">
          <div class="httpStatus">
            <p class="httpStatus__code">404</p>
            <p>お探しのページは見つかりません。</p>
          </div>
        </div>
      </div>
    </div>
    @include('customer.mobile.include.footer')
  </div>
  </body>
  </html>
