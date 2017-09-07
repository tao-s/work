@extends('admin.layout')

@section('title')
    {{ 'ページが見つかりませんでした' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">
            <div class="jumbotron">
                <h1>404</h1>
                <p>お探しのページは見つかりませんでした。</p>
            </div>
        </div>
    </div>
@stop