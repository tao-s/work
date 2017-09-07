@extends('customer.pc.layout')

@section('title', 'ログイン｜教育業界特化の転職・求人サイト 教育業界に特化した求人・転職サービス「Education Career」のログイン用ページです。')

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
        <h2 class="m-heading m-heading--h2">ログイン</h2>

        @include('customer.pc.include.message')

        <form action="{{ url('/login') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="l-group">
            <table class="m-table">
              <tbody>
              <tr>
                <th><label for="inputEmail">メールアドレス <span
                        class="m-label m-label--require">必須</span></label></th>
                <td><input id="inputEmail" type="text" name="email" value="" placeholder="メールアドレス"></td>
              </tr>

              <tr>
                <th><label for="inputPassword">パスワード <span
                        class="m-label m-label--require">必須</span></label></th>
                <td>
                  <div class="l-group l-group--xs">
                    <input id="inputpassword" type="password" name="password" value=""
                         placeholder="パスワード">

                    <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上</p>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>

            <div class="l-group l-group--xs">
              <p><a href="{{ url('/password/reset') }}">&gt; パスワードを忘れた方はこちら</a></p>
              <p><a href="{{ url('/register') }}">&gt; 会員登録がお済みではない方はこちら</a></p>
            </div>

            <div class="l-row l-row--xs">
              <div class="col-12"><input type="submit" value="ログイン" class="m-button m-button--default">
              </div>
            </div>
            <h2 class="m-heading m-heading--h2">外部アカウントでログイン</h2>
            <div class="l-row l-row--s">
              <a href="{{ url('/auth/facebook') }}" class="col-6 m-button m-button--facebook">Facebook</a>
              <a href="{{ url('/auth/google') }}" class="col-6 m-button m-button--googleplus">Google</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
