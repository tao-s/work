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

                            @if(trim($job->background))
                                <tr>
                                    <th>募集の背景</th>
                                    <td>
                                        {!! nl2br(e($job->background)) !!}
                                    </td>
                                </tr>
                            @endif

                            @if(trim($job->job_description))
                            <tr>
                                <th>仕事内容</th>
                                <td>
                                    {!! nl2br(e($job->job_description)) !!}
                                </td>
                            </tr>
                            @endif

                            @if(trim($job->qualification))
                            <tr>
                                <th>応募資格</th>
                                <td>
                                    <ul class="l-group l-group--xs">
                                        <p>
                                            {!! nl2br(e($job->qualification)) !!}
                                        </p>
                                    </ul>
                                </td>
                            </tr>
                            @endif

                            @if(trim($job->work_place))
                            <tr>
                                <th>勤務地</th>
                                <td>
                                    <ul class="l-group l-group--xs">
                                        <p>
                                            {!! nl2br(e($job->work_place)) !!}
                                        </p>
                                    </ul>
                                </td>
                            </tr>
                            @endif

                            @if(trim($job->work_hour))
                            <tr>
                                <th>勤務時間</th>
                                <td>{!! nl2br(e($job->work_hour)) !!}</td>
                            </tr>
                            @endif

                            @if(trim($job->salary))
                            <tr>
                                <th>給与</th>
                                <td>{!! nl2br(e($job->salary)) !!}</td>
                            </tr>
                            @endif

                            @if(trim($job->benefit))
                            <tr>
                                <th>待遇・福利厚生</th>
                                <td>{!! nl2br(e($job->benefit)) !!}</td>
                            </tr>
                            @endif

                            @if(trim($job->holiday))
                            <tr>
                                <th>休日・休暇</th>
                                <td>{!! nl2br(e($job->holiday)) !!}</td>
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
