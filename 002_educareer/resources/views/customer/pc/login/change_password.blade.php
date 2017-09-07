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
        <h2 class="m-heading m-heading--h2">パスワード再設定</h2>

        @include('customer.pc.include.message')

        <form action="{{ url('/password/confirm') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="l-group">
            <table class="m-table">
              <tbody>
              <tr>
                <th><label for="inputPassword">パスワード <span class="m-label m-label--require">必須</span></label></th>
                <td>
                  <div class="l-group l-group--xs">
                    <input id="inputpassword" type="password" name="password" value="" placeholder="パスワード">
                    <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上 </p>
                  </div>
                </td>
              </tr>

              <tr>
                <th><label for="inputPasswordConfirmation">パスワード（確認用） <span class="m-label m-label--require">必須</span></label></th>
                <td>
                  <input id="inputPasswordConfirmation" type="password" name="password_confirmation" value="" placeholder="パスワード（確認用）">
                </td>
              </tr>
              </tbody>
            </table>


            <div class="l-row l-row--xs">
              <div class="col-12"><input type="submit" value="パスワードを再設定" class="m-button m-button--default">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
