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
    {!! Html::script('js/preview.js') !!}
@stop

@section('content')

    @include('client.header')

    <div class="container-fluid">
        <div class="row">

            @include('client.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">求人新規作成</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <h2>求人情報</h2>

                <p style="font-size: 16px"><span style="color: red">*</span> は必須項目</p>

                <form action="{{ url('/posting/franchise') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="franchise" value="1">

                    <div class="col-xs-12 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="margin-bottom20">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class=""><a href="{{ url('/posting/create') }}">通常求人</a></li>
                            <li role="presentation" class="active"><a href="#">フランチャイズ求人</a></li>
                        </ul>
                    </div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputTitle"><span style="color: red">*</span> 募集タイトル</label>
                        <input name="title" type="text" id="inputTitle" class="form-control"
                               placeholder="募集タイトル" value="{{ $data->title }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputMainMessage">メイン文言</label>
                        <textarea name="main_message" id="inputMainMessage" class="form-control" cols="30"
                                  rows="13">{{ $data->main_message }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputJobTitle"><span style="color: red">*</span> 職種タイトル</label>
                        <input name="job_title" type="text" id="inputJobTitle" class="form-control"
                               placeholder="" value="{{ $data->job_title }}">
                    </div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputBusinessType"><span style="color: red">*</span> 業態</label>
                        <select class="form-control pull-left" data-title="業態" name="business_type_id">
                            @foreach($business_types as $bt)
                                <option {{ ViewHelper::selected($bt->id, $data->business_type_id) }} value="{{ $bt->id }}">{{ $bt->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputTags">こだわり条件</label>
                        <select id="inputTags" class="selectpicker pull-left" multiple data-title="こだわり条件" data-width="405px"
                                name="tag_id[]">
                            @foreach($tags as $tag)
                                <option {{ in_array($tag->id, $data->tags) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputPrefecture"><span style="color: red">*</span> 勤務地（都道府県）</label>
                        <select class="form-control pull-left" data-title="勤務地" data-width="240px" name="prefecture">
                            @foreach($prefectures as $key => $pref)
                                <option {{ ViewHelper::selected($key, $data->prefecture) }} value="{{ $key }}">{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputWorkplace">勤務地（開業エリア）</label>
                        <textarea name="work_place" id="inputWorkplace" class="form-control"
                                  cols="30" rows="3">{{ $data->work_place }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputAbountProduct">商品/サービスの概要</label>
                        <textarea name="fr_about_product" id="inputAbountProduct" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_about_product }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputAboutMarket">ビジネスの特徴・市場性・強み</label>
                        <textarea name="fr_about_market" id="inputAboutMarket" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_about_market }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputPreSupport">開業前のサポート</label>
                        <textarea name="fr_pre_support" id="inputPreSupport" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_pre_support }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputPostSupport">開業後のサポート</label>
                        <textarea name="fr_post_support" id="inputPostSupport" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_post_support }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputFlowToOpen">開業までの流れ</label>
                        <textarea name="fr_flow_to_open" id="inputFlowToOpen" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_flow_to_open }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputBusinessModel">収益モデル</label>
                        <textarea name="fr_business_model" id="inputBusinessModel" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_business_model }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputContractType">契約タイプ</label>
                        <textarea name="fr_contract_type" id="inputContractType" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_contract_type }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputContractPeriod">契約期間</label>
                        <textarea name="fr_contract_period" id="inputContractPeriod" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_contract_period }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputInitialFundAmount">開業資金（その内訳）</label>
                        <textarea name="fr_initial_fund_amount" id="inputInitialFundAmount" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_initial_fund_amount }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputRoyalty">ロイヤルティ</label>
                        <textarea name="fr_royalty" id="inputRoyalty" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_royalty }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputSeminarInfo">説明会情報</label>
                        <textarea name="fr_seminar_info" id="inputSeminarInfo" class="form-control" cols="30"
                                  rows="13">{{ $data->fr_seminar_info }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputMainImage">メイン画像（横780px 縦400px）最大4MBまで</label>

                        <div class="thumbnail">
                            <div class="caption">
                                @if($data->main_image)
                                    <img src="{{ $thumbnail_path . '/780x400/' . $data->main_image }}" alt=""/>
                                @endif
                                <input name="main_image" type="file" id="inputMainImage" class="form-control">
                                <input name="main_image_filename" type="hidden" value="{{ $data->main_image }}">
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage1">サブ画像1（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            <div class="caption">
                                @if($data->side_image1)
                                    <img src="{{ $side_image_path . '/360x270/' . $data->side_image1 }}" alt=""/>
                                @endif
                                <input name="side_image1" type="file" id="inputSideImage1" class="form-control">
                                <input name="side_image1_filename" type="hidden" value="{{ $data->side_image1 }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage1Caption">サブ画像1の説明</label>
                        <input name="side_image1_caption" type="text" id="inputSideImage1Caption" class="form-control"
                               placeholder="サブ画像1の説明" value="{{ $data->side_image1_caption }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage2">サブ画像2（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            <div class="caption">
                                @if($data->side_image2)
                                    <img src="{{ $side_image_path . '/360x270/' . $data->side_image2 }}" alt=""/>
                                @endif
                                <input name="side_image2" type="file" id="inputSideImage2" class="form-control">
                                <input name="side_image2_filename" type="hidden" value="{{ $data->side_image2 }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage2Caption">サブ画像2の説明</label>
                        <input name="side_image2_caption" type="text" id="inputSideImage2Caption" class="form-control"
                               placeholder="サブ画像2の説明" value="{{ $data->side_image2_caption }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage3">サブ画像3（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            <div class="caption">
                                @if($data->side_image3)
                                    <img src="{{ $side_image_path . '/360x270/' . $data->side_image3 }}" alt=""/>
                                @endif
                                <input name="side_image3" type="file" id="inputSideImage3" class="form-control">
                                <input name="side_image3_filename" type="hidden" value="{{ $data->side_image3 }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage3Caption">サブ画像3の説明</label>
                        <input name="side_image3_caption" type="text" id="inputSideImage3Caption" class="form-control"
                               placeholder="サブ画像3の説明" value="{{ $data->side_image3_caption }}">
                    </div>

                    <div class="clearfix"></div>

                    <h2>会社情報</h2>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputCompanyDescription">会社概要</label>
                        <textarea name="company_description" id="inputCompanyDescription" class="form-control" cols="30"
                                  rows="13">{{ $data->company_description }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputCompanyBusiness">事業概要</label>
                        <textarea name="company_business" id="inputCompanyBusiness" class="form-control" cols="30"
                                  rows="13">{{ $data->company_business }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputCompanyCharacteristics">会社の特徴</label>
                        <textarea name="company_characteristics" id="inputCompanyCharacteristics" class="form-control"
                                  cols="30" rows="13">{{ $data->company_characteristics }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <div class="col-xs-4 form-adjust">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">保存して一覧に戻る</button>
                        </div>
                        <div class="col-xs-4 form-adjust">
                            <a id="preview" class="btn btn-lg btn-success btn-block"
                               role="button" href="{{ url('/preview/franchise') }}" target="_blank">プレビュー</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop