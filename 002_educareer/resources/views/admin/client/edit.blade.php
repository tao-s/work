@extends('admin.layout')

@section('title')
    {{ 'クライアント管理 | ' }}
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

                <h1 class="page-header">クライアント編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <form action="{{ url('/client/'.$client->id) }}" method="post">
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

                    <div class="col-xs-6 form-adjust">
                        @if($client->can_publish == '0')
                            <label for="inputPermission">公開承認</label>
                            <input name="permission" type="checkbox" id="inputPermission" autofocus>
                        @else
                            <label for="inputPermission">公開取消</label>
                            <input name="permission" type="checkbox" id="inputPermission" checked autofocus>
                        @endif

                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="plan">プラン</label>
                        <select name="plan">
                            @foreach ($plans as $plan)
                                @if($selected_plan_id == $plan->id)
                                    <option value="{{ $plan->id }}" selected="selected">{{ $plan->plan_name }}</option>
                                @else
                                    <option value="{{ $plan->id }}">{{ $plan->plan_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div>
                            <label>有効期限</label>
                            {{ $client->upgrade ? $client->upgrade->getExpireDate() : '' }}
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="plan_update">プランの有効期限を更新する</label>
                        <input type="checkbox" name="plan_update" id="plan_update" value="1">
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