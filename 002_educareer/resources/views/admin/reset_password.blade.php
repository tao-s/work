@extends('admin.layout')

@section('title')
    {{ 'パスワード再設定 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/reset_password.css') !!}
@stop

@section('custom_js')

@stop


@section('content')

    <form class="form-login" action="{{ url('/reset_password') }}" method="post">
        <h4 class="form-login-heading">パスワードの再設定</h4>

        <p>※ パスワード再設定用のメールを送信します。</p>
        @foreach($errors->all() as $error)
            <label class="error-msg">{{ $error }}</label>
        @endforeach
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="inputEmail" class="sr-only">メールアドレス</label>
        <input name="email" value="{{ old('email') }}" type="email" id="inputEmail" class="form-control"
               placeholder="メールアドレス" autofocus>

        <button class="btn btn-lg btn-primary btn-block" type="submit">メール送信</button>
    </form>

@stop