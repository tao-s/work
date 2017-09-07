@extends('client.layout')

@section('title')
    {{ '担当者管理 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/bootstrap-select.min.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/bootstrap-select.js') !!}
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')

    @include('client.header')

    <div class="container-fluid">
        <div class="row">

            @include('client.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


                <h1 class="page-header">担当者管理</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">

                    <form class="form-inline" method="post" action="{{ url('rep') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            @foreach($errors->all() as $error)
                                <div>
                                    <label class="error-msg">{{ $error }}</label>
                                </div>
                            @endforeach
                            <input name="email" type="email" class="form-control" placeholder="メールアドレス"
                                   value="{{ old('email') }}">
                            <button type="submit" class="btn btn-success">新規作成</button>
                        </div>
                    </form>

                </div>

                <div class="table-responsive" style="overflow-x: visible; ">
                    {!! $client_reps->render() !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>クライアント名</th>
                            <th>担当者名</th>
                            <th>メールアドレス</th>
                            <th>ステータス</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($client_reps as $client_rep)
                            <tr>
                                <td>
                                    <div class="td">{{ $client_rep->id }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ $client_rep->client->company_name }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ $client_rep->name ? $client_rep->name : '編集画面から担当者名を入力して下さい。' }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ $client_rep->email }}</div>
                                </td>
                                <td>
                                    <div class="td">
                                        <span class="label label-{{ ViewHelper::label($client_rep->status()) }}">{{ $client_rep->status() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            アクション
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li>
                                                <a href="{{ url('/rep/'.$client_rep->id.'/edit') }}">編集</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/rep/password/'.$client_rep->id) }}">パスワード変更</a>
                                            </li>
                                            <li>
                                                <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" href="{{ url('/rep/'.$client_rep->id) }}">削除</a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $client_reps->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop