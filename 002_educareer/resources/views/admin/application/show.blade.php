@extends('admin.layout')

@section('title')
    {{ '応募管理 | ' }}
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

                <h1>応募者情報</h1>

                <table class="table table-bordered">
                    <tr>
                        <th>名前</th>
                        <td>{{ $customer->profile->username }}</td>
                    </tr>
                    <tr>
                        <th>Eメール</th>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                    <tr>
                        <th>性別</th>
                        <td>{{ $customer->profile->getGender() }}</td>
                    </tr>
                    <tr>
                        <th>生年月日</th>
                        <td>{{ $customer->profile->formatBirthday('Y年n月d日') }}</td>
                    </tr>
                    <tr>
                        <th>自己紹介/キャリアサマリー</th>
                        <td>{!! nl2br(e($customer->profile->introduction ? $customer->profile->introduction : '')) !!}</td>
                    </tr>
                    <tr>
                        <th>取り組みたいこと/関心トピック</th>
                        <td>{!! nl2br(e($customer->profile->future_plan ? $customer->profile->future_plan : '')) !!}</td>
                    </tr>
                    <tr>
                        <th>学校名</th>
                        <td>{{ $customer->profile->school_name }}</td>
                    </tr>
                    <tr>
                        <th>卒業年度</th>
                        <td>{{ $customer->profile->graduate_year }}</td>
                    </tr>
                    <tr>
                        <th>職歴</th>
                        <td>{!! nl2br(e($customer->profile->job_record ? $customer->profile->job_record : '')) !!}</td>
                    </tr>
                    <tr>
                        <th>活かせる経験・スキル</th>
                        <td>{!! nl2br(e($customer->profile->skill ? $customer->profile->skill : '')) !!}</td>
                    </tr>
                    <tr>
                        <th>保有資格</th>
                        <td>{!! nl2br(e($customer->profile->qualification ? $customer->profile->qualification : '')) !!}</td>
                    </tr>

                    <tr>
                        <th>直近の勤務先企業名</th>
                        <td>{{ $customer->profile->company_name  }}</td>
                    </tr>

                    <tr>
                        <th>直近の勤務先業種</th>
                        <td>
                            @foreach ($customer->profile->industry_types as $industry_type)
                                {{ $industry_type->name }}<br>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>直近の経験職種</th>
                        <td>
                            @foreach ($customer->profile->occupationCategoryNames() as $occupationCategoryName)
                                {{ $occupationCategoryName }}<br>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>希望勤務地</th>
                        <td>{{ $customer->profile->workLocationName() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop