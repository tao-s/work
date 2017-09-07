@extends('customer.pc.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

    <div class="globalViewport l-row">
        <div class="globalMain globalMain--hook l-group col-8">

            @include('customer.mobile.include.message')

            <h1>customer.pc.client.complete</h1>

        </div>

    </div>
@stop
