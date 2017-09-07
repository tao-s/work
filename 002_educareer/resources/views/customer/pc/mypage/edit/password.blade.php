@extends('customer.pc.layout_mypage')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')
<div class="globalMain globalMain--hook l-group col-8">
  <div class="l-group">
    <div class="breadcrumbs">
      <a href="{{ url('/') }}">ホーム</a>
      <span>&gt;</span>
      <a href="{{ url('/mypage') }}">マイページ</a>
      <span>&gt;</span>
      <strong>パスワード設定</strong>
    </div>

    @include('customer.pc.include.message')

    <form action="{{ url('/mypage/password') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="_method" value="put">

      <div class="l-group">
        <table class="m-table">
          <tbody>
            <tr>
              <th><label for="inputCurrentPassword">現在のパスワード</label></th>
              <td><input name="current_password" type="password" id="inputCurrentPassword" placeholder="現在のパスワード"></td>
            </tr>

            <tr>
              <th><label for="inputPassword">新しいパスワード</label></th>
              <td><input name="password" type="password" id="inputPassword" placeholder="新しいパスワード"></td>
            </tr>

            <tr>
              <th><label for="inputPasswordConfirmation">新しいパスワード（確認用）</label></th>
              <td><input name="password_confirmation" type="password" id="inputPasswordConfirmation" placeholder="新しいパスワード（確認用）"></td>
            </tr>
          </tbody>
        </table>
        
        <div class="l-row l-row--xs">
          <div class="col-6"><a href="{{ url('/mypage') }}" class="m-button m-button--negative">戻る</a></div>
          <div class="col-6"><input type="submit" value="変更する" class="m-button m-button--default"></div>
        </div>
      </div>
    </form>

  </div>
</div>
@stop
