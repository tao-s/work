@extends('client.layout')

@section('title')
    {{ '会社情報管理 | ' }}
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

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">クライアント編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <form action="{{ url('/company/'.$client->id) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">

                    <div class="col-xs-4 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-3 form-adjust">
                        <label for="inputCompanyName">会社名</label>
                        <input name="company_name" type="text" id="inputCompanyName" class="form-control"
                               value="{{ $client->company_name }}" autofocus>
                    </div>

                    <div class="col-xs-3 form-adjust">
                        <label for="inputCompanyId">クライアントID</label>
                        <input name="company_id" type="text" id="inputCompanyId" class="form-control"
                               value="{{ $client->company_id }}" autofocus>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputUrl">URL</label>
                        <input name="url" type="text" id="inputUrl" class="form-control" value="{{ $client->url }}"
                               autofocus>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-3 form-adjust">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">変更を保存</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop