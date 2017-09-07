@extends('customer.mobile.layout')

@section('title', 'ログイン｜教育業界特化の転職・求人サイト 教育業界に特化した求人・転職サービス「Education Career」のログイン用ページです。')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>ログイン</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/login') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="formInput">
      <div class="formInput__email">
        <label for="inputEmail">メールアドレス</label>
        <input type="text" id="inputEmail" name="email" value="" placeholder="メールアドレス">
      </div>
      <div class="formInput__pass">
        <label for="inputpassword">パスワード</label>
        <input type="password" id="inputpassword" name="password" value="" placeholder="パスワード">
        <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上</p>
      </div>
      <input type="submit" value="ログイン" class="m-button default">
      <p><a href="{{ url('/password/reset') }}">&gt; パスワードを忘れた方はこちら</a></p>
    </div>

    <div class="snslogin">
      <p>外部アカウントでログイン</p>
      <div class="l-row">
        <a href="{{ url('/auth/facebook') }}" class="col-6 m-button facebook">Facebook</a>
        <a href="{{ url('/auth/google') }}" class="col-6 m-button googleplus">Google</a>
      </div>
    </div>
  </form>
  <div class="newRegister">
    <p>まだ会員登録していない方はこちら</p>
    <a href="{{ url('/register') }}" class="m-button primary">無料会員登録</a>
  </div>
@stop
