@extends('admin.layout')

@section('title')
    {{ 'クライアント担当者管理 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/login.css') !!}
@stop

@section('custom_js')

@stop


@section('content')

    <form class="form-login" action="{{ url('/client_rep/confirm') }}" method="post">
        <h4 class="form-login-heading">パスワードを設定して下さい</h4>
        @foreach($errors->all() as $error)
            <label class="error-msg">{{ $error }}</label>
        @endforeach
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="inputPassword" class="sr-only">新しいパスワード</label>
        <input name="password" type="password" id="inputPassword" class="form-control"
               placeholder="新しいパスワード" autofocus>
        <label for="inputPasswordConfirmation" class="sr-only">新しいパスワード（確認用）</label>
        <input name="password_confirmation" type="password" id="inputPasswordConfirmation" class="form-control"
               placeholder="新しいパスワード（確認用）">

        <button class="btn btn-lg btn-primary btn-block" type="submit">パスワードを設定</button>
    </form>

@stop