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

                <h1 class="page-header">担当者情報編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <form action="{{ url('/rep/'.$client_rep->id) }}" method="post">
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
                        <label for="inputName">担当者名</label>
                        <input name="name" type="text" id="inputName" class="form-control"
                               value="{{ $client_rep->name }}"
                               placeholder="担当者名" autofocus>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputEmail">メールアドレス</label>
                        <input name="email" type="text" id="inputEmail" class="form-control"
                               value="{{ $client_rep->email }}"
                               placeholder="メールアドレス" autofocus>
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