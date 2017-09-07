@extends('admin.layout')

@section('title')
    {{ '求人管理 | ' }}
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

            <div class="col-xs-12 col-xs-offset-1 main">

                <h1 class="page-header">求人管理</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">
                    <a class="btn btn-success" role="button" href="{{ url('/job/create') }}">新規作成</a>
                </div>

                <div class="table-responsive" style="overflow-x: visible; ">
                    {!! $jobs->render() !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>求人ID</th>
                            <th>クライアント名</th>
                            <th>求人タイトル</th>
                            <th>応募数</th>
                            <th>メインスライド</th>
                            <th>Pickup求人</th>
                            <th>公開ステータス</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td>
                                    <div class="td">{{ $job->id }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ str_limit($job->client->company_name, 25, '...') }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ str_limit($job->title, 25, '...') }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ $job->applications->count() }}件</div>
                                </td>
                                <td>
                                    @if($job->main_slide_flag)
                                        <div class="td"><span class="label label-info">表示する</span></div>
                                    @else
                                        <div class="td"><span class="label label-default">表示しない</span></div>
                                    @endif
                                </td>
                                <td>
                                    @if($job->pickup_flag)
                                        <div class="td"><span class="label label-info">表示する</span></div>
                                    @else
                                        <div class="td"><span class="label label-default">表示しない</span></div>
                                    @endif
                                </td>
                                <td>
                                    @if($job->can_publish)
                                        <div class="td"><span class="label label-success">公開中</span></div>
                                    @else
                                        <div class="td"><span class="label label-warning">非公開</span></div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            アクション
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li>
                                                @if($job->is_franchise)
                                                    <a data-method="post" href="{{ url('/preview/franchise') }}" target="_blank">
                                                        プレビュー
                                                        @foreach ($job->toArray() as $key => $val)
                                                            @if ($key != 'client' && $key != 'applications')
                                                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                                            @endif
                                                        @endforeach
                                                        <input type="hidden" name="main_image_filename" value="{{ $job->main_image }}">
                                                        <input type="hidden" name="side_image1_filename" value="{{ $job->side_image1 }}">
                                                        <input type="hidden" name="side_image2_filename" value="{{ $job->side_image2 }}">
                                                        <input type="hidden" name="side_image3_filename" value="{{ $job->side_image3 }}">
                                                    </a>
                                                @else
                                                    <a data-method="post" href="{{ url('/preview') }}" target="_blank">
                                                        プレビュー
                                                        @foreach ($job->toArray() as $key => $val)
                                                            @if ($key != 'client' && $key != 'applications')
                                                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                                            @endif
                                                        @endforeach
                                                        <input type="hidden" name="main_image_filename" value="{{ $job->main_image }}">
                                                        <input type="hidden" name="side_image1_filename" value="{{ $job->side_image1 }}">
                                                        <input type="hidden" name="side_image2_filename" value="{{ $job->side_image2 }}">
                                                        <input type="hidden" name="side_image3_filename" value="{{ $job->side_image3 }}">
                                                    </a>
                                                @endif
                                            </li>
                                            <li>
                                                @if($job->can_publish)
                                                    <a data-method="put" href="{{ url('/job/'.$job->id.'/depublish') }}">非公開にする</a>
                                                @else
                                                    <a data-method="put" href="{{ url('/job/'.$job->id.'/publish') }}">公開する</a>
                                                @endif
                                            </li>
                                            @if($job->can_publish)
                                            <li>
                                                @if($job->main_slide_flag)
                                                    <a data-method="put" href="{{ url('/job/'.$job->id.'/slide') }}">メインスライド掲載取消</a>
                                                @else
                                                    <a data-method="put" href="{{ url('/job/'.$job->id.'/slide') }}">メインスライドに掲載</a>
                                                @endif
                                            </li>
                                            @endif
                                            @if($job->can_publish)
                                            <li>
                                                @if($job->pickup_flag)
                                                    <a data-method="put" href="{{ url('/job/'.$job->id.'/pickup') }}">Pickup求人掲載取消</a>
                                                @else
                                                    <a data-method="put" href="{{ url('/job/'.$job->id.'/pickup') }}">Pickup求人に掲載</a>
                                                @endif
                                            </li>
                                            @endif
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="{{ url('/job/'.$job->id.'/edit') }}">編集</a>
                                            </li>
                                            <li>
                                                <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" href="{{ url('/job/'.$job->id) }}">削除</a>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"></li>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $jobs->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop