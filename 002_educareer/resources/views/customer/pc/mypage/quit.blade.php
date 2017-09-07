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

    <form action="{{ url('/mypage/quit') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="customer_id" value="{{ $user->id }}">

      <div class="l-group">
        <strong class="m-heading m-heading--h2">Education Careerを退会しますか？</strong>

        <p>
          Education Careerを退会すると、ご記入頂いたプロフィール、お気に入りの履歴等は全て失われます。<br>
          メールマガジンの送付有無は別途マイページで設定が可能です。 <br>
          本当にEducation Careerを退会されますか？
        </p>

        <div class="l-row l-row--xs">
          <div class="col-6"><a href="{{ url('/mypage') }}" class="m-button m-button--negative">戻る</a></div>
          <div class="col-6"><input type="submit" value="退会する" class="m-button m-button--default"></div>
        </div>
      </div>
    </form>

  </div>
</div>
@stop
