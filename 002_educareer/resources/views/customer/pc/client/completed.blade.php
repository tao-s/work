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
      <div class="l-group">
        <h2 class="m-heading m-heading--h2">法人アカウント申請完了</h2>
        <p>
          法人用アカウントの申請ありがとうございます。<br><br>

          ご入力頂いたメールアドレス宛に、確認メールをお送りしております。<br>
          そちらのURLをクリックして頂き、管理画面をご利用下さい。<br>

          管理画面上から原稿作成が可能になっております。<br><br>
          ※情報の公開は弊社で一度情報を確認させて頂いてから可能になります。<br>
          掲載をお断りさせていただく場合もございますので、ご了承ください。
        </p>
    </div>
  </div>
@stop
