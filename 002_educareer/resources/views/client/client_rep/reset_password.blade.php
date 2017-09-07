@extends('client.layout')

@section('title')
    {{ '担当者管理 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')

    @include('client.header')

    <div class="container-fluid">
        <div class="row">

            @include('client.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">担当者パスワード編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <form action="{{ url('/rep/password') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="client_rep_id" value="{{ $client_rep->id }}">

                    <div class="col-xs-5 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputPassword">新しいパスワード</label>
                        <input name="password" type="password" id="inputPassword" class="form-control"
                               placeholder="新しいパスワード">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputPasswordConfirmation">新しいパスワード（確認用）</label>
                        <input name="password_confirmation" type="password" id="inputPasswordConfirmation"
                               class="form-control"
                               placeholder="新しいパスワード（確認用）">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-3 form-adjust">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">変更を保存</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop