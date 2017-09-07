@extends('customer.mobile.layout')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')
    <div class="globalContents__titleBox">
        <h2>お問い合わせ</h2>
    </div>

    @include('customer.mobile.include.message')

    <form action="{{ url('/contact') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="formInput">
            <div class="formInput__label">
                <label for="inputName">お名前 <span class="m-label m-label--require">必須</span></label><br>
                <input type="text" id="inputName" name="name" value="{{ old('name') }}" placeholder="お名前">
            </div>
            <div class="formInput__label">
              <label for="inputCompany">貴社名/団体名 <span class="m-label m-label--require">必須</span></label><br>
              <input id="inputCompany" type="text" name="company" value="{{ old('company') }}" placeholder="貴社名/団体名">
            </div>
            <div class="formInput__label">
              <label for="inputTel">お電話番号 <span class="m-label m-label--require">必須</span></label><br>
              <input id="inputTel" type="text" name="tel" value="{{ old('tel') }}" placeholder="お電話番号">
            </div>
            <div class="formInput__email">
                <label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label><br>
                <input type="text" id="inputEmail" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
            </div>
            <div class="formInput__label">
              <label for="inputUrl">貴社サイトURL <span class="m-label m-label--optional">任意</span></label><br>
              <input id="inputUrl" type="text" name="url" value="{{ old('url') }}" placeholder="貴社サイトURL">
            </div>
            <div class="formInput__label">
                <label for="inputSubject">件名 <span class="m-label m-label--require">必須</span></label><br>
                <input type="text" id="inputSubjectj" name="subject" value="{{ old('subject') }}" placeholder="件名">
            </div>
            <div class="formInput__label l-row">
                <label for="inputBody">お問い合わせ内容 <span class="m-label m-label--require">必須</span></label><br>
                <textarea class="col-12" rows="10" id="inputBody" name="body" placeholder=""></textarea>
            </div>
            <input type="submit" value="お問い合わせ送信" class="m-button default">
        </div>

    </form>
@stop
