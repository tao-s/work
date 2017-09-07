@extends('admin.layout')

@section('title')
    {{ 'カスタマー管理 | ' }}
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

            <div class="col-xs-12 col-xs-offset-1 main">

                <h1 class="page-header">カスタマー管理</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="margin-bottom10">
                    <a class="btn btn-success" role="button" href="{{ url('/customer/create') }}">新規作成</a>
                </div>

                <div class="well">
                    <form action="{{ url('/customer') }}" method="get">

                        <div class="col-xs-3">
                            <input class="form-control" type="text" name="age_from" value="{{ isset($query['age_from']) ? $query['age_from'] : '' }}" placeholder="年齢下限">
                        </div>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" name="age_to" value="{{ isset($query['age_to']) ? $query['age_to'] : '' }}" placeholder="年齢上限">
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-3 form-adjust">
                            <select class="form-control" name="mail_magazine_flag" id="inputMailMagazineFlag">
                                <option {{ isset($query['mail_magazine_flag']) ? '' : 'selected' }} value="">メールマガジンの受信</option>
                                <option {{ isset($query['mail_magazine_flag']) && $query['mail_magazine_flag'] == 'true' ? 'selected' : '' }} value="true">許可する</option>
                                <option {{ isset($query['mail_magazine_flag']) && $query['mail_magazine_flag'] == 'false' ? 'selected' : '' }} value="false">許可しない</option>
                            </select>
                        </div>

                        <div class="col-xs-3 form-adjust">
                            <select class="form-control" name="scout_mail_flag" id="inputScoutMailFlag">
                                <option {{ isset($query['scout_mail_flag']) ? '' : 'selected' }} value="">スカウトメールの受信</option>
                                <option {{ isset($query['scout_mail_flag']) && $query['scout_mail_flag'] == 'true' ? 'selected' : '' }} value="true">許可する</option>
                                <option {{ isset($query['scout_mail_flag']) && $query['scout_mail_flag'] == 'false' ? 'selected' : '' }} value="false">許可しない</option>
                            </select>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-8">
                            <input id="inputFreeword" class="form-control" type="text" name="freeword" value="{{ isset($query['freeword']) ? $query['freeword'] : '' }}" placeholder="メールアドレス、ユーザ名、大学名、その他フリーワード">
                        </div>
                        <div class="col-xs-4">
                            <input id="inputSearch" class="btn btn-default" type="submit" value="検索">
                        </div>

                        <div class="clearfix"></div>

                    </form>
                </div>


                <div class="table-responsive" style="overflow-x: visible;">
                    <div>
                        <p>{{ $customers->total() }}件中{{ $customers->firstItem() }} ~ {{ $customers->lastItem() }}件を表示</p>
                    </div>
                    {!! $customers->render() !!}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>メールアドレス</th>
                            <th>ユーザ名</th>
                            <th>年齢</th>
                            <th>性別</th>
                            <th>ステータス</th>
                            <th>メールフラグ</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>
                                    <div class="td">{{ $customer->id }}</div>
                                </td>
                                <td>
                                    <div class="td">{{ str_limit($customer->email, 20, '...') }}</div>
                                </td>
                                <td>
                                    @if ($customer->profile && $customer->profile->username)
                                        <div class="td">{{ $customer->profile->username }}</div>
                                    @else
                                        <div class="td">未設定</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($customer->profile && $customer->profile->birthday)
                                        <div class="td">{{ $customer->profile->birthday->age }}</div>
                                    @else
                                        <div class="td">未設定</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($customer->profile && $customer->profile->sex)
                                        <div class="td">{{ $customer->profile->sex == 1 ? '男性' : '女性' }}</div>
                                    @else
                                        <div class="td">未設定</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="td">
                                        <span class="label label-{{ ViewHelper::label($customer->status()) }}">
                                            {{ $customer->status() == 'active' ? '仮メール開封済み' : '仮メール未開封' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="td col-xs-3">
                                        <span class="label label-{{ ViewHelper::label($customer->profile && $customer->profile->mail_magazine_flag ? 'active' : 'inactive') }}">
                                            {{ $customer->profile && $customer->profile->mail_magazine_flag ? 'メルマガOK' : 'メルマガNG' }}
                                        </span>
                                        <span class="label label-{{ ViewHelper::label($customer->profile && $customer->profile->scout_mail_flag ? 'active' : 'inactive') }}">
                                            {{ $customer->profile && $customer->profile->scout_mail_flag ? 'スカウトOK' : 'スカウトNG' }}
                                        </span>

                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
                                            更新
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" style="z-index: 99999999;">
                                            <li>
                                                <a href="{{ url('/customer/'.$customer->id.'/edit') }}">アカウント情報</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/customer_profile/'.$customer->id.'/edit') }}">プロフィール情報</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a data-method="delete" data-confirm="本当に削除してもよろしいですか？" class="btn btn-danger"
                                       role="button" href="{{ url('/customer/'.$customer->id) }}">削除</a>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $customers->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop