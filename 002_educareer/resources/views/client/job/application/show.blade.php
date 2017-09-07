@extends('admin.layout')

@section('title')
    {{ '応募者情報 | ' }}
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

            <div class="col-sm-14 col-sm-offset-2 col-md-14 col-md-offset-2 main">

                <h1 class="page-header">応募者情報</h1>

                <div class="table-responsive">

                    <div class="row">
                        <div class="col-md-12">

                            @if(!$app->customer)
                                この会員は既に退会しています。
                            @else
                                <table class="table table-bordered">
                                    <tbody>

                                    <tr>
                                        <th style="width: 130px;background-color: #F7F7F7">名前</th>
                                        <td>{{ $app->customer->profile->username }}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">メールアドレス</th>
                                        <td>{{ $app->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">電話番号</th>
                                        <td>{{ $app->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">性別</th>
                                        <td>{{ $app->customer->profile->sex }}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">生年月日</th>
                                        @if ($app->customer->profile->birthday == null)
                                            <td>年齢未設定</td>
                                        @else
                                            <td>{{ $app->customer->profile->birthday->age }}歳 / {{ $app->customer->profile->birthday->format('Y年m月d日') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th style="width: 160px; background-color: #F7F7F7">自己紹介/キャリアサマリー</th>
                                        <td>{!! nl2br(e($app->customer->profile->introduction)) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">取り組みたいこと/関心トピック</th>
                                        <td>{!! nl2br(e($app->customer->profile->future_plan)) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">学校名</th>
                                        <td>{!! nl2br(e($app->customer->profile->school_name)) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">卒業年度</th>
                                        <td>{!! nl2br(e($app->customer->profile->graduate_year ? $app->customer->profile->graduate_year . '年' : '')) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">職歴</th>
                                        <td>{!! nl2br(e($app->customer->profile->job_record)) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">活かせる経験・スキル</th>
                                        <td>{!! nl2br(e($app->customer->profile->skill)) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">保有資格</th>
                                        <td>{!! nl2br(e($app->customer->profile->qualification)) !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">直近の勤務先企業名</th>
                                        <td>{{ $app->customer->profile->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #F7F7F7">直近の勤務先業種</th>
                                        <td>
                                            @foreach ($app->customer->profile->industry_types as $industry_type)
                                                {{ $industry_type->name }}<br>
                                            @endforeach
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style="background-color: #F7F7F7">直近の経験職種</th>
                                        <td>
                                            @foreach ($app->customer->profile->occupationCategoryNames() as $occupationCategoryName)
                                                {{ $occupationCategoryName }}<br>
                                            @endforeach
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style="background-color: #F7F7F7">希望勤務地</th>
                                        <td>{{ $app->customer->profile->workLocationName() }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop