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
        <h2 class="m-heading m-heading--h2">パスワード再発行</h2>

        @include('customer.pc.include.message')

        <form action="{{ url('/password/reset') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="l-group">
            <table class="m-table">
              <tbody>
              <tr>
                <th><label for="inputEmail">メールアドレス <span
                        class="m-label m-label--require">必須</span></label></th>
                <td><input id="inputEmail" type="text" name="email" value="" placeholder="メールアドレス"></td>
              </tr>
              </tbody>
            </table>

            <div class="l-row l-row--xs">
              <div class="col-12"><input type="submit" value="パスワードを再発行" class="m-button m-button--default">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
