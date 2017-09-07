@extends('admin.layout')

@section('title')
    {{ 'オペレーター管理 | ' }}
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

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">オペレーター編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="col-sm-5 col-sm-offset-3 col-md-5 col-md-offset-0">
                    <div class="panel panel-info" style="margin-bottom: 40px">
                        <div class="panel-heading">
                            <h3 class="panel-title">対象アカウント</h3>
                        </div>
                        <div class="panel-body">
                            {{ $admin->email }}
                        </div>
                    </div>
                    <form action="{{ url('/admin/'.$admin->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="put">

                        <h3>パスワードの変更</h3>
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label>
                        @endforeach
                        <div class="form-adjust">
                            <label for="inputPassword" class="sr-only">新しいパスワード</label>
                            <input name="password" type="password" id="inputPassword" class="form-control"
                                   placeholder="新しいパスワード" autofocus>
                        </div>
                        <div class="form-adjust">
                            <label for="inputPasswordConfirmation" class="sr-only">新しいパスワード（確認用）</label>
                            <input name="password_confirmation" type="password" id="inputPasswordConfirmation"
                                   class="form-control"
                                   placeholder="新しいパスワード（確認用）">
                        </div>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">変更を保存</button>
                    </form>
                </div>


            </div>
        </div>
    </div>
@stop