@extends('admin.layout')

@section('title')
    {{ 'クライアント担当者管理 | ' }}
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

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


                <h1 class="page-header">クライアント担当者</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">

                    <form class="form-inline" method="post" action="{{ url('client_rep') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            @foreach($errors->all() as $error)
                                <div>
                                    <label class="error-msg">{{ $error }}</label>
                                </div>
                            @endforeach
                            <select class="form-control margin-right10 pull-left" data-title="クライアントを選択して下さい"
                                    data-width="240px" name="client_id">
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                            <input name="email" type="email" class="form-control" placeholder="メールアドレス"
                                   value="{{ old('email') }}">
                            <button type="submit" class="btn btn-success">新規作成</button>
                        </div>
                    </form>

                </div>


                <div class="table-responsive">
                    {!! $client_reps->render() !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>クライアント名</th>
                            <th>担当者名</th>
                            <th>電話番号</th>
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
                                    <div class="td"><a href="{{ url('/client/'.$client->id.'/edit') }}">{{ $client_rep->client->company_name }}</a></div>
                                </td>
                                <td>
                                    <div class="td">{{ $client_rep->name ? $client_rep->name : '未設定' }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ $client_rep->phone ? $client_rep->phone : '未設定' }}</div>
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
                                    <a class="btn btn-info" role="button"
                                       href="{{ url('/client_rep/'.$client_rep->id.'/edit') }}">更新</a>
                                    <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" class="btn btn-danger"
                                       role="button" href="{{ url('/client_rep/'.$client_rep->id) }}">削除</a>
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