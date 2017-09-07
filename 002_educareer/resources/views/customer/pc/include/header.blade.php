<div class="globalHeader">
  <div class="globalHeader__sub">
    <div class="clearfix">
      <div class="logo"><a href="{{ url('/') }}"><i class="icon--logo">Education Career</i></a></div>
      <ul>
          <li class="{{ Request::is('job*') ? 'is-active' : '' }}"><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/job') }}">求人を探す</a></li>
        <li class="{{ Request::is('agent*') ? 'is-active' : '' }}"><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/agent') }}">転職エージェントに相談</a></li>
        <li><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/recruiter') }}">採用担当者様へ</a></li>
        <li><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/magazine') }}">コラム</a></li>
    @if ($user && isset($user->profile))
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="user" data-accordion="container">
          <ul class="user__profile">
            <li data-accordion="trigger"><a href="#">{{ $user->profile->username }}<i class="icon--arrowDown"></i></a></li>
          </ul>
          <ul class="user__nav" data-accordion="target">
            <li><a href="{{ url('/mypage') }}">マイページ</a></li>
            <li><a href="{{ url('/favorite') }}">気になるリスト</a></li>
            <li><a href="{{ url('/mypage/account') }}">アカウント設定</a></li>
            <li><a data-method="post" href="{{ url('/logout') }}">ログアウト</a></li>
          </ul>
        </div>
      @else
        <li class="signin">
          <ul class="clearfix login">
            <li><a class="m-button m-button--default" href="{{ url('/login') }}">ログイン</a></li>
            <li><a class="m-button m-button--primary" href="{{ url('/register') }}">会員登録</a></li>
          </ul>
        </li>
      @endif
      </ul>
    </div>
  </div>

  </div>
</div>
