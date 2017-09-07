@extends('admin.layout')

@section('title')
    {{ 'インタビュー記事 | ' }}
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

                <h1 class="page-header">インタビュー記事編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <form action="{{ url('/interview/'.$interview->id) }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">

                    <div class="col-xs-6 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputClient"><span style="color: red">*</span> クライアント</label>
                        <select class="form-control margin-right10 pull-left" data-title="クライアントを選択して下さい"
                                data-width="240px" name="client_id">
                            @foreach($clients as $client)
                                <option {{ $data->client_id == $client->id ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->company_name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputTitle"><span style="color: red">*</span> 記事タイトル</label>
                        <input name="title" type="text" id="inputTitle" class="form-control" placeholder="記事タイトル" value="{{ $data->title }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputUrl"><span style="color: red">*</span> URL</label>
                        <input name="url" type="text" id="inputUrl" class="form-control" placeholder="URL" value="{{ $data->url }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputImage"><span style="color: red">*</span> サムネイル画像（横145px 縦100px）</label>

                        <div class="thumbnail">
                            @if($interview->image)
                                <img src="{{ $interview_image_path . '/145x100/' . $interview->image }}" alt=""/>
                            @else
                                <img alt="" src="http://dummyimage.com/145x100/b8b8b8/fff">
                            @endif
                            <div class="caption">
                                <input name="image" type="file" id="inputImage" class="form-control">
                            </div>
                        </div>

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