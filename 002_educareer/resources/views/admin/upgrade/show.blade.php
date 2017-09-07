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

            <div class="col-sm-12 col-sm-offset-3 col-md-12 col-md-offset-2 main">


                <h1 class="page-header">有料プラン申請</h1>

                <div class="panel panel-info">
                    <div class="panel-heading">申請クライアント</div>
                    <div class="panel-body">
                        {{ $upgrade->client->company_name }}: <a href="{{ $upgrade->client->url }}"
                                                                 target="_blank">{{ $upgrade->client->url }}</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="background-color: #F7F7F7">プラン名</th>
                            <td>{{ $upgrade->plan->plan_name }}</td>
                        </tr>
                        <tr>
                            <th style="background-color: #F7F7F7">会社名</th>
                            <td>{{ $upgrade->company_name }}</td>
                        </tr>
                        <tr>
                            <th style="background-color: #F7F7F7">代表名</th>
                            <td>{{ $upgrade->ceo }}</td>
                        </tr>
                        <tr>
                            <th style="background-color: #F7F7F7">住所</th>
                            <td>
                                〒{{ $upgrade->post_code }} <br>
                                {{ $upgrade->address }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <form action="{{ url('/upgrade/'.$upgrade->id) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="approved_flag" value="{{ $upgrade->is_approved }}">
                    @if($upgrade->is_approved == 1)
                        <div class="col-xs-3 form-adjust">
                            <a data-method="delete" data-confirm="本当に取り消してもよろしいですか？"
                               class="btn btn-lg btn-danger btn-block" role="button"
                               href="{{ url('/upgrade/'.$upgrade->id) }}">承認の取消</a>
                        </div>
                    @else
                        <div class="col-xs-3 form-adjust">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">申請を承認</button>
                        </div>
                        <div class="col-xs-3 form-adjust">
                            <a data-method="delete" data-confirm="本当に却下してもよろしいですか？"
                               class="btn btn-lg btn-danger btn-block" role="button"
                               href="{{ url('/upgrade/'.$upgrade->id) }}">申請を却下</a>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
@stop