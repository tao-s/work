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
        <h2 class="m-heading m-heading--h2">登録手続用メールの再送信</h2>

        @include('customer.pc.include.message')

        <form action="{{ url('/register/re-activate') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="l-group">
            <p>
              このメールアドレスで過去に会員登録手続きを行っていますが、会員登録手続が未完了のままになっております。<br>
              登録手続用のメールを再送信し、会員登録手続を完了してください。
            </p>
            <table class="m-table">
              <tbody>
              <tr>
                <th><label for="inputEmail">メールアドレス <span
                        class="m-label m-label--require">必須</span></label></th>
                <td><input id="inputEmail" type="text" name="email" value="{{ $email }}" placeholder="メールアドレス"></td>
              </tr>
              </tbody>
            </table>

            <div class="l-row l-row--xs">
              <div class="col-12"><input type="submit" value="再送信" class="m-button m-button--default">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
