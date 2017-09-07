@extends('customer.mobile.layout')

@section('title', '会員登録｜教育業界特化の転職・求人サイト　 教育業界に特化した求人・転職サービス「Education Career」の会員登録用ページです。')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>会員登録</h2>
  </div>
  <div class="l-box s">
    <p>サービス登録前に<a href="{{ url('/terms') }}" class="m-text m-text--primary">利用規約</a>をお読みいただき、同意された上で登録をお願い致します。</p>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/register') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="formInput">
      <div class="formInput__email">
        <label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label>
        <input id="inputEmail" type="text" name="email" value="" placeholder="メールアドレス">
      </div>
      <div class="formInput__pass">
        <label for="inputPassword">パスワード <span class="m-label m-label--require">必須</span></label>
        <input id="inputpassword" type="password" name="password" value="" placeholder="パスワード">
        <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上</p>
      </div>
      <div class="formInput__pass">
        <label for="inputPasswordConfirmation" >パスワード（確認用） <span class="m-label m-label--require">必須</span></label>
        <input id="inputPasswordConfirmation" type="password" name="password_confirmation" value="" placeholder="パスワード（確認用）">
      </div>

      <input type="submit" value="次へ" class="m-button default">
      <div class="snslogin">
        <p>外部アカウントで登録</p>
        <div class="l-row">
          <a href="{{ url('/auth/facebook') }}" class="col-6 m-button facebook">Facebook</a>
          <a href="{{ url('/auth/google') }}" class="col-6 m-button googleplus">Google</a>
        </div>
      </div>
    </div>
  </form>

@stop
