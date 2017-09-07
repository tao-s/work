@extends('admin.layout')

@section('title')
    {{ 'クライアント管理 | ' }}
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

            <div class="col-xs-12 col-lg-offset-1">

                <h1 class="page-header">クライアント管理</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">
                    <a class="btn btn-success" role="button" href="{{ url('/client/create') }}">新規作成</a>
                </div>


                <div class="table-responsive">
                    {!! $clients->render() !!}
                    <table class="table table-striped" style="overflow-x: scroll">
                        <thead>
                        <tr>
                            <th>クライアント名</th>
                            <th>URL</th>
                            <th>掲載求人数</th>
                            {{--<th>応募数</th>--}}
                            <th>プラン</th>
                            <th>承認ステータス</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>
                                    <div class="td">{{ $client->company_name }}</div>
                                </td>
                                <td>
                                    <div class="td"><a href="{{ $client->url }}" target="_blank">{{ $client->url }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="td">
                                        <a href="{{ url('/job/?client_id='.$client->id) }}">{{ $client->jobs->count() }}件</a>
                                    </div>
                                </td>
                                {{--<td>{{ '未実装' }}</td>--}}
                                <td>
                                    <div class="td">
                                        @if(is_null($client->upgrade))
                                            無料プラン
                                        @elseif($client->upgrade->isExpired())
                                            {{ $client->upgrade->getStatusLabel() }}
                                        @else
                                            <a href="{{ url('/upgrade/'.$client->upgrade->id) }}">{{ $client->upgrade->getStatusLabel() }}</a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="td">
                                        @if($client->can_publish == 0)
                                            未承認
                                        @else
                                            承認済み
                                        @endif
                                    </div>
                                </td>
                                <td class="td">
                                    <form action="{{ url('/client/'.$client->id.'/permit') }}" method="post"
                                          class="pull-left margin-right5">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="put">
                                        @if($client->can_publish == 1)
                                            <input type="hidden" name="permission" value="0">
                                            <button class="btn btn-success" type="submit">承認取消</button>
                                        @else
                                            <input type="hidden" name="permission" value="1">
                                            <button class="btn btn-success" type="submit">公開承認</button>
                                        @endif

                                    </form>
                                    <a class="btn btn-info" role="button"
                                       href="{{ url('/client/'.$client->id.'/edit') }}">更新</a>
                                    <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" class="btn btn-danger"
                                       role="button" href="{{ url('/client/'.$client->id) }}">削除</a>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $clients->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop