@extends('admin.layout')

@section('title')
    {{ 'インタビュー記事 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/request_sender.js') !!}
    {!! Html::script('js/admin_interview_index.js') !!}
@stop

@section('content')

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')

            <div class="col-xs-12 col-xs-offset-1 main">

                <h1 class="page-header">インタビュー記事管理</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">
                    <a class="btn btn-success" role="button" href="{{ url('/interview/create') }}">新規作成</a>
                </div>

                <div>
                    @foreach($errors->all() as $error)
                        <label class="error-msg">{{ $error }}</label><br>
                    @endforeach
                </div>

                <div class="table-responsive" style="overflow-x: visible;">
                    {!! Form::open(['url' => '/interview/order', 'method' => 'put']) !!}
                        {!! $interviews->render() !!}
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>クライアント</th>
                                <th>記事タイトル</th>
                                <th>URL</th>
                                <th>掲載順</th>
                                <th>アクション</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($interviews as $interview)
                                <tr>
                                    <td>
                                        <div class="td">{{ str_limit($interview->client->company_name, 20, '...')  }}</div>
                                    </td>
                                    <td>
                                        <div class="td">{{ str_limit($interview->title, 30, '...')  }}</div>
                                    </td>
                                    <td>
                                        <div class="td"><a href="{{ $interview->url }}" target="_blank">{{ str_limit($interview->url, 30, '...') }}</a></div>
                                    </td>
                                    <td>
                                        {!! Form::select(
                                            'order[' . $interview->id . ']',
                                            [0 => '掲載なし', 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                                            $interview->order,
                                            ['class' => 'form-control interview-order', 'style' => 'width:100px;']
                                        )!!}
                                    </td>
                                    <td>
                                        <a role="button" class="btn btn-info" href="{{ url('/interview/'.$interview->id.'/edit') }}">編集</a>
                                        <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" class="btn btn-danger"
                                           role="button" href="{{ url('/interview/'.$interview->id) }}">削除</a>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $interviews->render() !!}
                        <div style="text-align: right;">
                            <button type="button" id="interview-order-reset" class="btn btn-default">掲載順をリセット</button>
                            <input class="btn btn-success" type="submit" value="ソートを保存">
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop