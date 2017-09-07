@extends('admin.layout')

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/bootstrap.min.js') !!}
@stop

@section('content')

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <h1 class="page-header">サービス概要</h1>

                <div class="row placeholders">
                    <div class="col-xs-6 col-sm-3 placeholder">
                        <h4>今日の新規会員獲得数</h4>
                        <span class="text-muted">{{ $daily_acquisitions }}</span>
                    </div>
                    <div class="col-xs-6 col-sm-3 placeholder">
                        <h4>今日の応募数</h4>
                        <span class="text-muted">{{ $daily_applications }}</span>
                    </div>
                    <div class="col-xs-6 col-sm-3 placeholder">
                        <h4>現存掲載求人件数</h4>
                        <span class="text-muted">{{ $current_jobs }}</span>
                    </div>
                    <div class="col-xs-6 col-sm-3 placeholder">
                        <h4>累計会員数</h4>
                        <span class="text-muted">{{ $total_customers }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop