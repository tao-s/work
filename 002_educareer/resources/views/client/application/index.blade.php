@extends('client.layout')

@section('title')
    {{ '応募管理 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/bootstrap-select.min.css') !!}
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

            <div class="col-xs-12  col-xs-offset-1 main">
                
                <h1 class="page-header">応募管理</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                @include('client.upgrade_modal')

                <div class="row margin-vert20">
                    <ul class="nav nav-tabs">
                        <?php $is_all = isset($app_status) ? false : true; ?>
                        <li role="presentation" class="{{ $is_all ? 'active' : '' }}">
                            <a href="{{ url('/application/') }}">全て ( {{ array_sum($count_by_status) }} )</a>
                        </li>
                        @foreach ($app_statuses as $as)
                            <?php $active = (isset($app_status) && $app_status->id == $as->id) ? 'active' : '' ?>
                            <li role="presentation" class="{{ $is_all ? '' : $active }}">
                                <a href="{{ url('/application/status/'.$as->id)}}">
                                    {{ $as->label }} ( {{ isset($count_by_status[$as->id]) ? $count_by_status[$as->id] : 0 }} )
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="row">
                    <div class="table-responsive" style="overflow-x: visible;">
                        {!! $apps->render() !!}
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>確認済み</th>
                                <th>求人</th>
                                <th>応募ユーザ</th>
                                <th>応募日</th>
                                <th>ステータス</th>
                                <th>担当者</th>
                                <th>アクション</th>
                                <th>ステータス変更</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($apps as $app)
                                <tr>
                                    <td>
                                        <div class="td">
                                            @if ($app_checks->where('application_id', $app->id)->count())
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            <a href="{{ url('/application/job/'.$app->job->id) }}">{{ str_limit($app->job->title, 20, '...') }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            @if ($app->customer)
                                                {{ $app->customer->profile->username }}
                                            @else
                                                この会員は既に退会しています。
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            {{ $app->created_at->format('Y-m-d') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            {{ $app->status->label }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            <div class="btn-group">
                                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                                    {{ $app->getAssignedRepName(10) ?: '担当者なし' }}
                                                    <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu" style="z-index: 99999999;">
                                                    <li>
                                                        <a data-method="put" href="{{ url('/application/'.$app->id.'/rep/0')}}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="rep_id" value="0">
                                                            担当者なし
                                                        </a>
                                                    </li>
                                                    @foreach ($client_reps as $rep)
                                                        <li>
                                                            <a data-method="put" href="{{ url('/application/'.$app->id.'/rep/'.$rep->id)}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="hidden" name="rep_id" value="{{ $rep->id }}">
                                                                {{ $rep->getNameOrEmail() }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            <a class="btn btn-info check_detail" role="button" data-href="{{ url('/api/application/check/'.$app->id) }}" href="{{ url('/application/'.$app->id.'/check') }}">この応募者の情報を見る</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td">
                                            <div class="btn-group">
                                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                                    ステータス
                                                    <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu" style="z-index: 99999999;">
                                                    @foreach ($app_statuses as $as)
                                                        <li>
                                                            <a data-method="put" href="{{ url('/application/'.$app->id)}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="hidden" name="status_id" value="{{ $as->id }}">
                                                                {{ $as->label }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $apps->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop