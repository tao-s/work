@extends('customer.mobile.layout')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>登録手続用メールの再送信</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/register/re-activate') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="l-box s">
      <p>
        このメールアドレスで過去に会員登録手続きを行っていますが、会員登録手続が未完了のままになっております。<br>
        登録手続用のメールを再送信し、会員登録手続を完了してください。
      </p>
    </div>
    <div class="formInput">
      <div class="formInput__email">
        <label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label>
        <input type="text" id="inputEmail" name="email" value="{{ $email }}" placeholder="メールアドレス">
      </div>
      <input type="submit" value="再送信" class="m-button default">
    </div>
  </form>
@stop
