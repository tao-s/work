@extends('client.layout')

@section('title')
    {{ '求人管理 | ' }}
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

    @include('client.header')

    <div class="container-fluid">
        <div class="row">

            @include('client.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">有料プランへのアップグレード</h1>
                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <div class="col-xs-8 form-adjust">
                    @foreach($errors->all() as $error)
                        <label class="error-msg">{{ $error }}</label><br>
                    @endforeach
                </div>

                <div class="clearfix"></div>

                <form action="{{ url('/upgrade') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div>
                        <div class="radio">
                            <input type="radio" name="plan_id"
                                   {{ old('plan_id') == '1' ? 'checked' : '' }} id="optionsRadios1" value="1">

                            <h3><label for="optionsRadios1">6ヶ月プラン</label></h3>
                        </div>
                        <p>
                            <ul>
                                <li>掲載件数：無制限</li>
                                <li>追加費用なし　※サイト経由での応募者を何名採用しても費用は発生しません。</li>
                                    ※ 別途優待価格で紹介契約可能です
                                <li>オプションの優待利用可能　こちら（リンク）</li>
                                <li>本契約の有効期限は、契約成立日より6ヶ月です。</li>
                            </ul>
                            なお、契約開始の起算日に応答する日が存在しない場合は、更新日は期間満了月の末日となります。
                            例) ⒌/20に半年プランをお申し込みの場合、⒒/19までのご契約
                            ・お支払いは、下記の入力先に請求書を郵送させていただきます。
                            月末〆の翌月末〆の支払いとさせて頂いております。※ご要望等あればお知らせください
                        </p>
                    </div>
                    <div>
                        <div class="radio">
                            <input type="radio" name="plan_id"
                                   {{ old('plan_id') == '2' ? 'checked' : '' }} id="optionsRadios2" value="2">

                            <h3><label for="optionsRadios2">1年間プラン</label></h3>
                        </div>
                        <p>
                        <ul>
                            <li>掲載件数：無制限</li>
                            <li>追加費用なし　※サイト経由での応募者を何名採用しても費用は発生しません。</li>
                            ※ 別途優待価格で紹介契約可能です
                            <li>オプションの優待利用可能　こちら（リンク）</li>
                            <li>掲載期間は、アップグレードしていただいた日から365日間となります</li>
                        </ul>
                        なお、契約開始の起算日に応答する日が存在しない場合は、更新日は期間満了月の末日となります。
                        例) ⒌/20に半年プランをお申し込みの場合、⒒/19までのご契約
                        ・お支払いは、下記の入力先に請求書を郵送させていただきます。
                        月末〆の翌月末〆の支払いとさせて頂いております。※ご要望等あればお知らせください
                        </p>
                    </div>

                    <hr>

                    <h4>請求書ご送付先情報</h4>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputCompanyName">会社名</label>
                        <input name="company_name" type="text" id="inputCompanyName" class="form-control"
                               placeholder="会社名" value="{{ old('company_name') }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputCEO">代表取締役名</label>
                        <input name="ceo" type="text" id="inputCEO" class="form-control"
                               placeholder="代表名" value="{{ old('ceo') }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputPostcode">郵便番号</label>
                        <input name="post_code" type="text" id="inputPostcode" class="form-control"
                               placeholder="123-4567" value="{{ old('post_code') }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputAddress">住所</label>
                        <input name="address" type="text" id="inputAddress" class="form-control"
                               placeholder="住所" value="{{ old('address') }}">
                    </div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputAgreement"><a href="">利用規約</a>に同意する</label>
                        <input name="agreement" type="checkbox" id="inputAgreement" value="1">
                    </div>

                    <div class="clearfix"></div>

                    <div>
                        <p>
                            お預かりしたお客様の個人情報は、弊社からお客様へのご連絡のために使用します。<br>
                            法令に定める場合を除き、第三者に対して個人情報の提供・開示する事はありません。<br>
                            お申込み後、弊社にて審査を行う為、契約開始まで数日かかる場合がございます。<br>
                            ※審査中もお申し込みプランをご使用いただけます。
                        </p>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-3 form-adjust">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">同意して申し込む</button>
                    </div>

                    <div class="clearfix"></div>

                    <div>
                        <p>申し込みの後、弊社にて審査を行うため、契約開始まで数日かかる場合がございます。</p>
                        <p>※ 審査中も、お申込みプランをご利用いただくことが可能です。</p>
                    </div>

                </form>


            </div>
        </div>
    </div>
@stop