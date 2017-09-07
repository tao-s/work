@extends('customer.mobile.layout')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>パスワード再発行</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/password/reset') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="formInput">
      <div class="formInput__email">
        <label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label>
        <input type="text" id="inputEmail" name="email" value="" placeholder="メールアドレス">
      </div>
      <input type="submit" value="パスワードを再発行" class="m-button default">
    </div>
  </form>
@stop
