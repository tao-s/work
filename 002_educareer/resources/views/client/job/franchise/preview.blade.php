@extends('customer.pc.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
    @include('customer.pc.include.sns')
@stop

@section('content')
  <div>
    @foreach($errors->all() as $error)
      <label class="error-msg">{{ $error }}</label><br>
    @endforeach
  </div>

  <div class="globalViewport l-row">
    <div class="breadcrumbs">
        <a href="#">ホーム</a>
        <span>&gt;</span>
        <a href="#">求人を探す</a>
        <span>&gt;</span>
        <a href="#">{{ $client->company_name }}</a>
        <span>&gt;</span>
        <strong>{{ $job->job_title }}</strong>
    </div>

    <div class="bigBanner">
        <div class="l-row m-card">
            <div class="col-8">
                @if($job->main_image_filepath)
                    <img src="{{ $job->main_image_filepath }}" alt="メイン画像"/>
                @else
                    <img alt="" src="/images/bnr_default_780x400.jpg">
                @endif
            </div>
            <div class="col-4 l-group l-group--xs slider__caption">
                <div class="bigBanner__header">
                    @include('customer.pc.include.snsButtonList')
                </div>
                <p class="m-heading m-heading--h3">{{ $client->company_name }}</p>

                <p class="m-heading m-heading--h2">{{ $job->title }}</p>

                <div class="bigBanner__footer">
                    <div class="l-row">
                        <div class="col-6"><a href="#" class="m-button m-button--default">応募する</a></div>
                        <div class="col-6"><a href="#" class="m-button m-button--primary">気になる</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="globalViewport l-row">

        <div class="globalMain l-group l-group--l col-8">
            <div class="l-group">
                <p>
                    {!! nl2br(e($job->main_message)) !!}
                </p>
            </div>

            <div class="m-tabs" data-tabs="container">
                <div class="m-tabs__tab">
                    <ul class="clearfix">
                        <li><a href="#" class="is-active" data-tabs="trigger"><strong>募集要項</strong></a></li>
                        <li><a href="#" data-tabs="trigger"><strong>会社概要</strong></a></li>
                    </ul>
                </div>

                <div class="m-tabs__body" data-tabs="body">
                    <div class="l-group l-group--xs" data-tabs="target">
                        <p class="m-heading m-heading--h2">募集要項</p>
                        <table class="m-table">
                            <tbody>

                            <tr>
                                <th>働き方</th>
                                <td>{{ $employment_status->title }}</td>
                            </tr>

                            <tr>
                                <th>職種</th>
                                <td>{{ $job->job_title }}</td>
                            </tr>

                            @if (trim($job->fr_about_product))
                                <tr>
                                    <th>商品/サービスの概要</th>
                                    <td>
                                        {!! nl2br(e($job->fr_about_product)) !!}
                                    </td>
                                </tr>
                            @endif

                            @if (trim($job->fr_about_market))
                                <tr>
                                    <th>ビジネスの特徴・市場性・強み</th>
                                    <td>
                                        {!! nl2br(e($job->fr_about_market)) !!}
                                    </td>
                                </tr>
                            @endif

                            @if (trim($job->fr_pre_support))
                                <tr>
                                    <th>開業前のサポート</th>
                                    <td>
                                        <ul class="l-group l-group--xs">
                                            <p>
                                                {!! nl2br(e($job->fr_pre_support)) !!}
                                            </p>
                                        </ul>
                                    </td>
                                </tr>
                            @endif

                            @if (trim($job->fr_post_support))
                                <tr>
                                    <th>開業後のサポート</th>
                                    <td>
                                        <ul class="l-group l-group--xs">
                                            <p>
                                                {!! nl2br(e($job->fr_post_support)) !!}
                                            </p>
                                        </ul>
                                    </td>
                                </tr>
                            @endif

                            @if (trim($job->fr_flow_to_open))
                                <tr>
                                    <th>開業までの流れ</th>
                                    <td>{!! nl2br(e($job->fr_flow_to_open)) !!}</td>
                                </tr>
                            @endif

                            @if (trim($job->fr_income_model))
                                <tr>
                                    <th>収益モデル</th>
                                    <td>{!! nl2br(e($job->fr_income_model)) !!}</td>
                                </tr>
                            @endif

                            @if (trim($job->fr_contract_type))
                                <tr>
                                    <th>契約タイプ</th>
                                    <td>{!! nl2br(e($job->fr_contract_type)) !!}</td>
                                </tr>
                            @endif

                            @if (trim($job->fr_contract_period))
                                <tr>
                                    <th>契約期間</th>
                                    <td>{!! nl2br(e($job->fr_contract_period)) !!}</td>
                                </tr>
                            @endif

                            @if (trim($job->fr_initial_fund_amount))
                                <tr>
                                    <th>開業資金</th>
                                    <td>{!! nl2br(e($job->fr_initial_fund_amount)) !!}</td>
                                </tr>
                            @endif

                            @if (trim($job->fr_royalty))
                                <tr>
                                    <th>ロイヤルティ</th>
                                    <td>{!! nl2br(e($job->fr_royalty)) !!}</td>
                                </tr>
                            @endif

                            @if (trim($job->fr_seminar_info))
                                <tr>
                                    <th>説明会情報</th>
                                    <td>{!! nl2br(e($job->fr_seminar_info)) !!}</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- .m-tabs__body -->

                    <div class="l-group l-group--xs" data-tabs="target">
                        <p class="m-heading m-heading--h2">会社概要</p>
                        <table class="m-table">
                            <tbody>
                            <tr>
                                <th>社名</th>
                                <td>{{ $client->company_name }}</td>
                            </tr>
                            <tr>
                                <th>URL</th>
                                <td><a href="{{ $client->url }}" target="_blank">{{ $client->url }}</a></td>
                            </tr>

                            @if(trim($job->company_business))
                            <tr>
                                <th>事業内容</th>
                                <td>{!! nl2br(e($job->company_business)) !!}</td>
                            </tr>
                            @endif

                            @if(trim($job->company_characteristics))
                            <tr>
                                <th>会社の特徴</th>
                                <td>{!! nl2br(e($job->company_characteristics)) !!}</td>
                            </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- .m-tabs__body -->
                </div>
            </div>

            <div class="m-text m-text--rtc">
                <div class="l-row" style="width: 360px; margin: 0 auto;">
                    <div class="col-6"><a href="#" class="m-button m-button--default">応募する</a></div>
                    <div class="col-6"><a href="#" class="m-button m-button--primary">気になる</a></div>
                </div>
            </div>

            <div class="m-text m-text--rtc">
                @include('customer.pc.include.snsButtonList')
            </div>

        </div>

        <div class="globalSide l-group l-group--l col-4">
            <div class="l-group">
                @if($job->side_image1_filepath)
                    <div class="l-group l-group--xs">
                        <div><img src="{{ $job->side_image1_filepath }}" alt="サイド画像1"/>
                        </div>
                        <p class="m-text m-text--sub">{{ $job->side_image1_caption }}</p>
                    </div>
                @endif
                @if($job->side_image2_filepath)
                    <div class="l-group l-group--xs">
                        <div><img src="{{ $job->side_image2_filepath }}" alt="サイド画像2"/>
                        </div>
                        <p class="m-text m-text--sub">{{ $job->side_image2_caption }}</p>
                    </div>
                @endif
                @if($job->side_image3_filepath)
                    <div class="l-group l-group--xs">
                        <div><img src="{{ $job->side_image3_filepath }}" alt="サイド画像3"/>
                        </div>
                        <p class="m-text m-text--sub">{{ $job->side_image3_caption }}</p>
                    </div>
                @endif


            </div>

            <div class="l-group l-group--xs" style="margin-top:20px">
                <div>
                    <a href="#">
                        <img src="/images/private_job.jpg" alt=""/>
                    </a>
                </div>
            </div>
        </div>

    </div>
@stop
