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
        <h2 class="m-heading m-heading--h2">ご応募ありがとうございます</h2>
        <p>
          ご登録いただきありがとうございます。会員登録が正常に完了しました。
        </p>

        

      </div>
  </div>
@stop
