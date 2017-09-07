@extends('client.layout')

@section('title')
    {{ 'メンテナンス中です' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

    @include('client.header')

    <div class="container-fluid">
        <div class="row">
            <div class="jumbotron">
                <h1>503</h1>
                <p>ただいまメンテナンス中です。</p>
            </div>
        </div>
    </div>
@stop