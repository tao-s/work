@extends('admin.layout')

@section('title')
    {{ 'IP設定 | ' }}
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

                <h1 class="page-header">IP設定</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <form action="{{ url('/ip') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-xs-6 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <p>メンテナンスモード時に許可するIPアドレスは6つまで指定できます</p>

                    <p>あなたのIPアドレス:  <code>{{ $my_ip }}</code></p>

                    <div id="ip-input" class="col-xs-10 form-adjust">
                        <div class="pull-left col-xs-6 form-adjust">
                            <input name="ip[1]" type="text" id="inputIp" class="form-control" value="{{ isset($ips[0]) ? $ips[0]->ip : ''  }}" autofocus>
                        </div>
                        <div class="pull-left col-xs-6 form-adjust">
                            <input name="ip[2]" type="text" id="inputIp" class="form-control" value="{{ isset($ips[1]) ? $ips[1]->ip : ''  }}" autofocus>
                        </div>
                        <div class="pull-left col-xs-6 form-adjust">
                            <input name="ip[3]" type="text" id="inputIp" class="form-control" value="{{ isset($ips[2]) ? $ips[2]->ip : ''  }}" autofocus>
                        </div>
                        <div class="pull-left col-xs-6 form-adjust">
                            <input name="ip[4]" type="text" id="inputIp" class="form-control" value="{{ isset($ips[3]) ? $ips[3]->ip : ''  }}" autofocus>
                        </div>
                        <div class="pull-left col-xs-6 form-adjust">
                            <input name="ip[5]" type="text" id="inputIp" class="form-control" value="{{ isset($ips[4]) ? $ips[4]->ip : ''  }}" autofocus>
                        </div>
                        <div class="pull-left col-xs-6 form-adjust">
                            <input name="ip[6]" type="text" id="inputIp" class="form-control" value="{{ isset($ips[5]) ? $ips[5]->ip : ''  }}" autofocus>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <p style="color: #a9a9a9">※ 保存ボタンを押すと現在許可されているIPに上書きして保存されますのでご注意ください。</p>
                    <div class="col-xs-3 form-adjust">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">保存</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop