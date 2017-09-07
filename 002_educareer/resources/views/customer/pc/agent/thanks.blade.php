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
        <h2 class="m-heading m-heading--h2">個別相談ありがとうございます</h2>
        <p>
          エージェントへの個別相談のリクエストを送信しました。お問い合わせいただきありがとうございました。
        </p>

      </div>
  </div>
@stop
