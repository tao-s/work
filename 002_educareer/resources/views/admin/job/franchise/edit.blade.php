@extends('admin.layout')

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

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">求人編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif
                <h2>求人情報</h2>

                <p style="font-size: 16px"><span style="color: red">*</span> は必須項目</p>

                <form action="{{ url('/job/'.$job->id.'/franchise') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">

                    <div class="pull-right">
                        <a data-method="post" class="btn btn-success" href="{{ url('/job/create?franchise=1') }}" target="_blank">
                            コピーして新規作成
                            @foreach ($job->toArray() as $key => $val)
                                @if ($key != 'client' && $key != 'applications' && $key != 'tags')
                                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                @endif
                            @endforeach
                            @foreach($job->tags as $tag)
                                <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                            @endforeach
                        </a>
                    </div>

                    <div class="col-xs-12 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputClient"><span style="color: red">*</span> クライアント</label>
                        <select id="inputClient" class="form-control pull-left" data-title="クライアント" name="client_id">
                            @foreach($clients as $client)
                                <option {{ ViewHelper::selected($client->id, $job->client_id) }} value="{{ $client->id }}">{{ $client->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputTitle"><span style="color: red">*</span> 募集タイトル</label>
                        <input name="title" type="text" id="inputTitle" class="form-control"
                               placeholder="募集タイトル" value="{{ $job->title }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputMainMessage">メイン文言</label>
                        <textarea name="main_message" id="inputMainMessage" class="form-control" cols="30"
                                  rows="13">{{ $job->main_message }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputJobTitle"><span style="color: red">*</span> 職種タイトル</label>
                        <input name="job_title" type="text" id="inputJobTitle" class="form-control"
                               placeholder="" value="{{ $job->job_title }}">
                    </div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputBusinessType"><span style="color: red">*</span> 業態</label>
                        <select class="form-control pull-left" data-title="業態" name="business_type_id">
                            @foreach($business_types as $bt)
                                <option {{ ViewHelper::selected($bt->id, $job->business_type_id) }} value="{{ $bt->id }}">{{ $bt->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputTags">こだわり条件</label>
                        <select id="inputTags" class="selectpicker pull-left" multiple data-title="こだわり条件" data-width="405px"
                                name="tag_id[]">
                            @foreach($tags as $tag)
                                <option {{ in_array($tag->id, array_fetch($job->tags->toArray(), 'id')) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust form-group">
                        <label for="inputMainSlideFlag">メインスライドに表示する</label>
                        <select id="inputMainSlideFlag" class="form-control pull-left" name="main_slide_flag">
                            <option {{ !boolval($job->main_slide_flag) ? 'selected' : '' }} value="0">表示しない</option>
                            <option {{ boolval($job->main_slide_flag) ? 'selected' : '' }} value="1">表示する</option>
                        </select>
                    </div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputPickupFlag">PICKUP求人に表示する</label>
                        <select id="inputPickupFlag" class="form-control pull-left" name="pickup_flag">
                            <option {{ !boolval($job->pickup_flag) ? 'selected' : '' }} value="0">表示しない</option>
                            <option {{ boolval($job->pickup_flag) ? 'selected' : '' }} value="1">表示する</option>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputPrefecture"><span style="color: red">*</span> 勤務地（都道府県）</label>
                        <select class="form-control pull-left" name="prefecture">
                            @foreach($prefectures as $key => $pref)
                                <option {{ ViewHelper::selected($key, $job->prefecture) }} value="{{ $key }}">{{ $pref }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputWorkplace">勤務地（開業エリア）</label>
                        <textarea name="work_place" id="inputWorkplace" class="form-control"
                                  cols="30" rows="3">{{ $job->work_place }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputAbountProduct">商品/サービスの概要</label>
                        <textarea name="fr_about_product" id="inputAbountProduct" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_about_product }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputAboutMarket">ビジネスの特徴・市場性・強み</label>
                        <textarea name="fr_about_market" id="inputAboutMarket" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_about_market }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputPreSupport">開業前のサポート</label>
                        <textarea name="fr_pre_support" id="inputPreSupport" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_pre_support }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputPostSupport">開業後のサポート</label>
                        <textarea name="fr_post_support" id="inputPostSupport" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_post_support }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputFlowToOpen">開業までの流れ</label>
                        <textarea name="fr_flow_to_open" id="inputFlowToOpen" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_flow_to_open }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputBusinessModel">収益モデル</label>
                        <textarea name="fr_business_model" id="inputBusinessModel" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_business_model }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputContractType">契約タイプ</label>
                        <textarea name="fr_contract_type" id="inputContractType" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_contract_type }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputContractPeriod">契約期間</label>
                        <textarea name="fr_contract_period" id="inputContractPeriod" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_contract_period }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputInitialFundAmount">開業資金（その内訳）</label>
                        <textarea name="fr_initial_fund_amount" id="inputInitialFundAmount" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_initial_fund_amount }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputRoyalty">ロイヤルティ</label>
                        <textarea name="fr_royalty" id="inputRoyalty" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_royalty }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputSeminarInfo">説明会情報</label>
                        <textarea name="fr_seminar_info" id="inputSeminarInfo" class="form-control" cols="30"
                                  rows="13">{{ $job->fr_seminar_info }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputMainImage">メイン画像（横780px 縦400px）最大4MBまで</label>

                        <div class="thumbnail">
                            @if($job->main_image)
                                <img src="{{ $thumbnail_path . '/780x400/' . $job->main_image }}" alt=""/>
                            @endif
                            <div class="caption">
                                <input name="main_image" type="file" id="inputPublishDate" class="form-control">
                                <input name="main_image_filename" type="hidden" value="{{ $job->main_image }}">
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage1">サブ画像1（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            @if($job->side_image1)
                                <img src="{{ $side_image_path . '/360x270/' . $job->side_image1 }}" alt=""/>
                            @endif
                            <div class="caption">
                                <input name="side_image1" type="file" id="inputSideImage1" class="form-control">
                                <input name="side_image1_filename" type="hidden" value="{{ $job->side_image1 }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage1Caption">サブ画像1の説明</label>
                        <input name="side_image1_caption" type="text" id="inputSideImage1Caption" class="form-control"
                               placeholder="サブ画像1の説明" value="{{ $job->side_image1_caption }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage2">サブ画像2（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            @if($job->side_image2)
                                <img src="{{ $side_image_path . '/360x270/' . $job->side_image2 }}" alt=""/>
                            @endif
                            <div class="caption">
                                <input name="side_image2" type="file" id="inputSideImage2" class="form-control">
                                <input name="side_image2_filename" type="hidden" value="{{ $job->side_image2 }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage2Caption">サブ画像2の説明</label>
                        <input name="side_image2_caption" type="text" id="inputSideImage2Caption" class="form-control"
                               placeholder="サブ画像2の説明" value="{{ $job->side_image2_caption }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage3">サブ画像3（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            @if($job->side_image3)
                                <img src="{{ $side_image_path . '/360x270/' . $job->side_image3 }}" alt=""/>
                            @endif
                            <div class="caption">
                                <input name="side_image3" type="file" id="inputSideImage3" class="form-control">
                                <input name="side_image3_filename" type="hidden" value="{{ $job->side_image3 }}">
                            </div>
                        </div>

                    </div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage3Caption">サブ画像3の説明</label>
                        <input name="side_image3_caption" type="text" id="inputSideImage3Caption" class="form-control"
                               placeholder="サブ画像3の説明" value="{{ $job->side_image3_caption }}">
                    </div>

                    <div class="clearfix"></div>

                    <h2>会社情報</h2>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputCompanyDescription">会社概要</label>
                        <textarea name="company_description" id="inputCompanyDescription" class="form-control" cols="30"
                                  rows="13">{{ $job->company_description }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputCompanyBusiness">事業概要</label>
                        <textarea name="company_business" id="inputCompanyBusiness" class="form-control" cols="30"
                                  rows="13">{{ $job->company_business }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputCompanyCharacteristics">会社の特徴</label>
                        <textarea name="company_characteristics" id="inputCompanyCharacteristics" class="form-control"
                                  cols="30" rows="13">{{ $job->company_characteristics }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">保存して一覧に戻る</button>
                    </div>
                    <div class="col-xs-4 form-adjust">
                        <a id="preview" class="btn btn-lg btn-success btn-block"
                           role="button" href="{{ url('/preview/franchise') }}" target="_blank">プレビュー</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop