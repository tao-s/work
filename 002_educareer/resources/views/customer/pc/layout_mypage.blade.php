<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('titile', 'Education Career 教育業界に特化した求人サービス')</title>
  <meta name="description" content="EducationCareerは教育業界に関心のあるすべての方に向けた求人サービスです。正社員や業務委託、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。" />
  <meta name="keywords" content="教育,転職,求人,教育業界" />
  @if(env('APP_ENV') != 'production')
    <meta name="robots" content="noindex">
  @endif

  @if($__env->yieldContent('open_graph'))
    @yield('open_graph')
  @else
    <meta property="og:title" content="Education Career 教育業界に特化した求人サービス"/>
    <meta property="og:description" content="EducationCareerは教育業界に関心のあるすべての方に向けた求人サービスです。正社員や業務委託、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。"/>
    <meta property="og:image" content="{{ url('/') . '/images/og_image.jpg' }}"/>
    <meta property="og:url" content="{{ url('/') }}"/>
    <meta property="og:type" content="website"/>
  @endif




  <link rel="icon" href="/favicon.ico">
  <link href="/css/style.css" rel="stylesheet">
  @yield('custom_css')
  @if (env('GOOGLE_ANALYTICS_ON'))
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-66902539-1', 'auto');
      ga('send', 'pageview');

    </script>
  @endif
</head>
<body>
  @if(env('GTM_ON'))
    <!-- Google Tag Manager -->
    <noscript>
      <iframe src="//www.googletagmanager.com/ns.html?id=GTM-WHD4DX" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
              new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
              j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
              '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WHD4DX');
    </script>
    <!-- End Google Tag Manager -->
  @endif
  <div class="globalContainer">
    @include('customer.pc.include.header')
    <div class="globalContents">
      <div class="globalViewport l-row">
      @yield('content')
      <div class="globalSide globalSide--separator col-4">
        <div class="profileCard l-group l-group--xs">
          <!-- div class="profileCard__avatar"><img src="" alt="" /></div -->
          <p class="m-heading m-heading--h2">{{ $user->profile->username }}</p>
          <ul>
            <li>性別：{{ $user->profile->getGender() }}</li>
            @if ( !is_null($user->profile->birthday) )
              <li>生年月日：{{ $user->profile->birthday->format('Y年m月d日') }}</li>
              <li>年齢：{{ $user->profile->birthday->age }}歳</li>
            @endif
          </ul>
        </div>

        <div class="localNav">
          <ul>
            <li class="{{ Request::is('mypage') ? 'is-active' : '' }}"><a href="{{ url('/mypage') }}">マイページトップ</a></li>
            <li class="{{ Request::is('favorite') ? 'is-active' : '' }}"><a href="{{ url('/favorite') }}">気になるリスト</a></li>
            <li class="{{ Request::is('mypage/account') ? 'is-active' : '' }}"><a href="{{ url('/mypage/account') }}">アカウント設定</a></li>
            <li class="{{ Request::is('mypage/profile') ? 'is-active' : '' }}"><a href="{{ url('/mypage/profile') }}">プロフィール設定</a></li>
            <li class="{{ Request::is('mypage/password') ? 'is-active' : '' }}"><a href="{{ url('/mypage/password') }}">パスワード設定</a></li>
            <li class="{{ Request::is('mypage/quit') ? 'is-active' : '' }}"><a href="{{ url('/mypage/quit') }}">退会</a></li>
            <li class="{{ Request::is('logout') ? 'is-active' : '' }}"><a data-method="post" href="{{ url('/logout') }}">ログアウト</a></li>
          </ul>
        </div>
      </div>
    </div>
    @include('customer.pc.include.footer')
  </div>

  <script src="/js/app.js"></script>
  <script src="/js/request_sender.js"></script>
  @yield('custom_js')
</body>
</html>
