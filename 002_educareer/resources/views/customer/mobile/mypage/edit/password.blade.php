@extends('customer.mobile.layout')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>パスワード設定</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/mypage/password') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="put">
    <div class="formInput">
      <div class="formInput__pass">
        <label for="inputCurrentPassword">現在のパスワード</label>
        <input name="current_password" type="password" id="inputCurrentPassword" placeholder="現在のパスワード">
      </div>
      <div class="formInput__pass">
        <label for="inputPassword">新しいパスワード</label>
        <input name="password" type="password" id="inputPassword" placeholder="新しいパスワード">
        <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上</p>
      </div>
      <div class="formInput__pass">
        <label for="inputPasswordConfirmation">新しいパスワード（確認用）</label>
        <input name="password_confirmation" type="password" id="inputPasswordConfirmation" placeholder="新しいパスワード（確認用）">
      </div>

      <div class="l-row l-box s">
        <div class="col-6">
          <a href="{{ url('/mypage') }}" class="m-button negative col-12">戻る</a>
        </div>
        <div class="col-6">
          <input type="submit" value="変更する" class="m-button default">
        </div>
      </div>
    </div>
  </form>

@stop
