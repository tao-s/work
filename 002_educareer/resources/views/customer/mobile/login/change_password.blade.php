@extends('customer.mobile.layout')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>パスワード再設定</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/password/confirm') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="formInput">
      <div class="formInput__pass">
        <label for="inputPassword">パスワード <span class="m-label m-label--require">必須</span></label>
        <input name="password" type="password" id="inputPassword" placeholder="新しいパスワード">
        <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上</p>
      </div>
      <div class="formInput__pass">
        <label for="inputPasswordConfirmation">パスワード（確認用） <span class="m-label m-label--require">必須</span></label>
        <input name="password_confirmation" type="password" id="inputPasswordConfirmation" placeholder="新しいパスワード（確認用）">
      </div>

      <input type="submit" value="パスワードを再設定" class="m-button default">
    </div>
  </form>

@stop
