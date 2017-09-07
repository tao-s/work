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

                <form id="hoge" action="{{ url('/posting') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-xs-12 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="margin-bottom20">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="#">通常求人</a></li>
                            @if ($client->canPublishFranchise())
                                <li role="presentation"><a href="{{ url('/posting/create?franchise=1') }}">フランチャイズ求人</a></li>
                            @else
                                <li role="presentation" class="disabled"><a href="#">フランチャイズ求人</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputTitle"><span style="color: red">*</span> 求人タイトル</label>
                        <input name="title" type="text" id="inputTitle" class="form-control"
                               placeholder="求人タイトル" value="{{ $data->title }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputMainMessage">メイン文言</label>
                        <textarea name="main_message" id="inputMainMessage" class="form-control" cols="30"
                                  rows="13">{{ $data->main_message }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputJobCategory"><span style="color: red">*</span> 職種カテゴリ</label>
                        <select class="form-control margin-right10 pull-left" data-title="職種" data-width="240px"
                                name="job_category_id">
                            @foreach($job_categories as $jc)
                                <option {{ ViewHelper::selected($jc->id, $data->job_category_id) }} value="{{ $jc->id }}">{{ $jc->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-6 form-adjust">
                        <label for="inputJobTitle"><span style="color: red">*</span> 職種タイトル</label>
                        <input name="job_title" type="text" id="inputJobTitle" class="form-control"
                               placeholder="（例）UXデザイナー" value="{{ $data->job_title }}">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputEmploymentStatus"><span style="color: red">*</span> 働き方</label>
                        <select class="form-control pull-left" data-title="働き方" name="employment_status_id">
                            @foreach($employment_status as $es)
                                <option {{ ViewHelper::selected($es->id, $data->employment_status_id) }} value="{{ $es->id }}">{{ $es->title }}</option>
                            @endforeach
                        </select>
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

                    <div class="col-xs-12 form-adjust">
                        <label for="inputBackground">募集の背景</label>
                        <textarea name="background" id="inputBackground" class="form-control" cols="30"
                                  rows="13">{{ $data->background }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputJobDescription">仕事内容</label>
                        <textarea name="job_description" id="inputJobDescription" class="form-control" cols="30"
                                  rows="13">{{ $data->job_description }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputQualification">応募資格</label>
                        <textarea name="qualification" id="inputQualification" class="form-control" cols="30"
                                  rows="13">{{ $data->qualification }}</textarea>
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
                        <label for="inputWorkPlace">勤務地（住所）</label>
                        <textarea name="work_place" id="inputWorkPlace" class="form-control" cols="30"
                                  rows="3">{{ $data->work_place }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputWorkHour">勤務時間</label>
                        <textarea name="work_hour" id="inputWorkHour" class="form-control" cols="30"
                                  rows="5">{{ $data->work_hour }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputSalary">給与</label>
                        <textarea name="salary" id="inputsalary" class="form-control" cols="30"
                                  rows="5">{{ $data->salary }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputHoliday">休日</label>
                        <textarea name="holiday" id="inputHoliday" class="form-control" cols="30"
                                  rows="5">{{ $data->holiday }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputBenefit">福利厚生</label>
                        <textarea name="benefit" id="inputBenefit" class="form-control" cols="30"
                                  rows="5">{{ $data->benefit }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 form-adjust">
                        <label for="inputMainImage">メイン画像（横780px 縦400px）最大4MBまで</label>

                        <div class="thumbnail">
                            @if($data->main_image)
                                <img src="{{ $thumbnail_path . '/780x400/' . $data->main_image }}" alt=""/>
                            @endif
                            <div class="caption">
                                <input name="main_image" type="file" id="inputMainImage" class="form-control">
                                <input name="main_image_filename" type="hidden" value="{{ $data->main_image }}">
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-6 form-adjust">
                        <label for="inputSideImage1">サブ画像1（横360px 縦270px）最大4MBまで</label>

                        <div class="thumbnail">
                            @if($data->side_image1)
                                <img src="{{ $side_image_path . '/360x270/' . $data->side_image1 }}" alt=""/>
                            @endif
                            <div class="caption">
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
                            @if($data->side_image2)
                                <img src="{{ $side_image_path . '/360x270/' . $data->side_image2 }}" alt=""/>
                            @endif
                            <div class="caption">
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
                            @if($data->side_image3)
                                <img src="{{ $side_image_path . '/360x270/' . $data->side_image3 }}" alt=""/>
                            @endif
                            <div class="caption">
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
                               role="button" href="{{ url('/preview') }}" target="_blank">プレビュー</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop