@extends('customer.pc.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')
  <div class="globalViewport l-row">
    <div class="globalMain globalMain--narrow">
      @include('customer.pc.include.message')
      <div class="l-group">
        <h2 class="m-heading m-heading--h2">会員登録</h2>
        <p>
          会員登録の申し込みありがとうございます。<br>

          会員登録はまだ完了しておりません。<br>
          会員登録のご案内メール内のURLをクリックし、会員情報登録画面へ進んでください。<br>
          ※URLの有効期限は24時間です。
        </p>
    </div>
  </div>
@stop
