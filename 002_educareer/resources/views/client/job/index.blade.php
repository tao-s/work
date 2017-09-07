@extends('client.layout')

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

    @include('client.header')

    <div class="container-fluid">
        <div class="row">

            @include('client.sidebar')

            <div class="col-xs-12 col-xs-offset-1 main">

                <h1 class="page-header">求人管理</h1>

                @if(Auth::client()->get()->load('client')->client->can_publish == 0)
                    <div class="alert alert-danger" role="alert">
                        現在、お客様の求人公開審査を行っております。公開承認が下りるまでしばらくお待ちください。
                    </div>
                @endif

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="well">
                    <a id="new" class="btn btn-success" role="button" data-href="{{ url('/api/posting/upgrade/'.$client_id) }}" href="{{ url('/posting/create') }}">新規作成</a>
                </div>
                <!-- Modal -->
                @include('client.upgrade_modal')

                <div class="table-responsive" style="overflow-x: visible; ">
                    {!! $jobs->render() !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>求人ID</th>
                            <th>求人タイトル</th>
                            <th>応募数</th>
                            <th>最終更新日</th>
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
                                    <div class="td">{{ str_limit($job->title, 25, '...') }}</div>
                                </td>
                                <td>
                                    <div class="td">
                                        @if($job->employment_status_id == \App\EmploymentStatus::FullTime)
                                            <span style="display:inline-block;padding-left:10px;">-</span>
                                        @else
                                            <a href="{{ url('/application/job/'.$job->id) }}">
                                                {{ $job->applications->count() }}件
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td><div class="td">{{ $job->updated_at->format('Y年m月d日') }}</div></td>
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
                                                    <a data-method="put" href="{{ url('posting/'.$job->id.'/depublish') }}">非公開にする</a>
                                                @else
                                                    <a class="publish" data-method="put" data-href="{{ url('/api/posting/publish/'.$client_id) }}" href="{{ url('posting/'.$job->id.'/publish') }}">公開する</a>
                                                @endif
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="{{ url('posting/'.$job->id.'/edit') }}">編集</a>
                                            </li>
                                            <li>
                                                <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" href="{{ url('/posting/'.$job->id) }}">削除</a>
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