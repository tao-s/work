@extends('admin.layout')

@section('title')
    {{ 'クライアント担当者管理 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/bootstrap-select.min.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/bootstrap-select.js') !!}
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')


            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


                <h1 class="page-header">クライアント担当者編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="col-xs-10">
                    <form action="{{ url('/client_rep/'.$client_rep->id) }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="put">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label>
                        @endforeach

                        <div class="clearfix"></div>

                        <div class="col-xs-6 form-adjust">
                            <label for="inputName">担当者名</label>
                            <input name="name" type="text" id="inputName" class="form-control"
                                   value="{{ $client_rep->name ? $client_rep->name : '未設定' }}"
                                   placeholder="" disabled>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-6 form-adjust">
                            <label for="inputEmail">メールアドレス</label>
                            <input name="email" type="text" id="inputEmail" class="form-control"
                                   value="{{ $client_rep->email }}"
                                   placeholder="メールアドレス" disabled>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-6 form-adjust">
                            <label for="inputPhone">電話番号</label>
                            <input name="phone" type="text" id="inputPhone" class="form-control"
                                   value="{{ $client_rep->phone ? $client_rep->phone : '未設定' }}"
                                   placeholder="" disabled>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-6 form-adjust">
                            <label for="inputClientId">クライアント</label>
                            <select id="inputClientId" class="form-control margin-bottom10" data-title="クライアントを選択して下さい" data-width="240px"
                                    name="client_id">
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ ViewHelper::selected($client->id, $client_rep->client_id) }}>
                                        {{ $client->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-4 form-adjust">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">変更を保存</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@stop