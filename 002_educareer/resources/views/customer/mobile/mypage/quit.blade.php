@extends('customer.mobile.layout')

@section('custom_js')
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')
  <h1 class="m-heading m-heading--h2">Education Careerを退会しますか？</h1>
  <div class="l-group l-box s">


    @include('customer.mobile.include.message')

    <form action="{{ url('/mypage/quit') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="customer_id" value="{{ $user->id }}">

      <div class="l-group">

        <p>
          Education Careerを退会すると、ご記入頂いたプロフィール、お気に入りの履歴等は全て失われます。<br>
          メールマガジンの送付有無は別途マイページで設定が可能です。<br>
          本当にEducation Careerを退会されますか？
        </p>

        <div class="l-row">
          <div class="col-6"><a href="{{ url('/mypage') }}" class="m-button negative col-12">戻る</a></div>
          <div class="col-6"><input type="submit" value="退会する" class="m-button default"></div>
        </div>
      </div>
    </form>

  </div>
@stop
