@extends('admin.layout')

@section('title')
    {{ 'エラーが発生しました' }}
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
                <h1>500</h1>
                <p>サーバー内でエラーが発生しました。</p>
            </div>
        </div>
    </div>
@stop