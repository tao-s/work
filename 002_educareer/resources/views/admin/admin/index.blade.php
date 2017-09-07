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

                <h1 class="page-header">オペレーター管理</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">

                    <form class="form-inline" method="post" action="{{ url('admin') }}">
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

                <div class="table-responsive">
                    {!! $admins->render() !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>メールアドレス</th>
                            <th>ステータス</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>
                                    <div class="td">{{ $admin->id }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ $admin->email }}</div>
                                </td>
                                <td>
                                    <div class="td">
                                        <span class="label label-{{ ViewHelper::label($admin->status()) }}">{{ $admin->status() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info" role="button"
                                       href="{{ url('/admin/'.$admin->id.'/edit') }}">更新</a>
                                    <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" class="btn btn-danger"
                                       role="button" href="{{ url('/admin/'.$admin->id) }}">削除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $admins->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop