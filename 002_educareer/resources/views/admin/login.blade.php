@extends('admin.layout')

@section('title')
    {{ 'ログイン | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/login.css') !!}
@stop

@section('custom_js')

@stop


@section('content')

    @if(Session::has('flash_msg'))
        <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
            {{ Session::get('flash_msg')->message() }}
        </div>
    @endif

    <form class="form-login" action="{{ url('/login') }}" method="post">
        <h2 class="form-login-heading">Education Career</h2>
        @if($errors->any())
            <label class="error-msg">{{ $errors->first() }}</label>
        @endif
        <label for="inputEmail" class="sr-only">メールアドレス</label>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input name="email" value="{{ old('email') }}" type="email" id="inputEmail" class="form-control"
               placeholder="メールアドレス" autofocus>
        <label for="inputPassword" class="sr-only">パスワード</label>
        <input name="password" value="{{ old('password') }}" type="password" id="inputPassword" class="form-control"
               placeholder="パスワード">

        <div class="checkbox">
            <label>
                <input name="remember_me" type="checkbox" value="true">次回から自動的にログイン
            </label>
        </div>
        <div>
            <label>
                <a href="{{ url('/reset_password') }}"> >> パスワードを忘れた方はこちら</a>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
    </form>

@stop