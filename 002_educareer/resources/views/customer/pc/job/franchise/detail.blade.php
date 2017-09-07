@extends('customer.pc.layout')

@section('title', $job->title . ' - ' . $job->client->company_name)

@section('open_graph')
  <meta property="og:title" content="{{ $job->title . ' - ' . $job->client->company_name }}"/>
  <meta property="og:description" content="EducationCareerは教育業界に関心のあるすべての方に向けた求人サービスです。正社員や業務委託、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。"/>
  <meta property="og:image" content="{{ $thumbnail_path . '/780x400/' . $job->main_image }}"/>
  <meta property="og:url" content="{{ url('/job/'.$job->id.'/detail') }}"/>
  <meta property="og:type" content="website"/>
@stop

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
  <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE" crossorigin="anonymous">
@stop

@section('custom_js')
  @include('customer.pc.include.sns')
@stop

@section('content')
<form action="{{ url('/application') }}" method="post">
  <div class="globalViewport l-row">
    <div class="breadcrumbs">
      <a href="{{ url('/') }}">ホーム</a>
      <span>&gt;</span>
      <a href="{{ url('/job') }}">求人を探す</a>
      <span>&gt;</span>
      <a href="{{ url('job?company='.$job->client->id) }}">{{ $job->client->company_name }}</a>
      <span>&gt;</span>
      <strong>{{ $job->job_title }}</strong>
    </div>

    @include('customer.pc.include.message')

    <div class="bigBanner">
      <div class="l-row m-card">
        <div class="col-8">
          @if($job->main_image)
            <img src="{{ $thumbnail_path . '/780x400/' . $job->main_image }}" alt=""/>
          @else
            <img alt="" src="/images/bnr_default_780x400.jpg">
          @endif
        </div>
        <div class="col-4 l-group l-group--xs slider__caption">
          <div class="bigBanner__header">
            @include('customer.pc.include.snsButtonList')
          </div>
          <p class="m-heading m-heading--h3">{{ $job->client->company_name }}</p>

          <p class="m-heading m-heading--h2">{{$job->title}}</p>

          <div class="bigBanner__footer">
            <div class="l-row">
              <div class="col-6">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if(!$job->hasAppliedBy($user))
                  <input type="submit" value="応募する" class="m-button m-button--default">
                @else
                  <p class="m-button is-disable">応募済み</p>
                @endif
              </div>

              <div class="col-6">
                @if(!$job->hasFavoredBy($user))
                  <a data-method="post" class="m-button m-button--primary" href="{{ url('/favorite') }}">
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    気になる
                  </a>
                @else
                  <p class="m-button is-disable">お気に入り済み</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
                <td>{{ $job->employment_status->title }}</td>
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

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div style="margin-bottom: 20px;margin-top: 20px;">
              <strong class="m-heading m-heading--h2">この求人に応募する</strong>
            </div>

            @include('customer.pc.include.application_form')

          </div>
          <!-- .m-tabs__body -->

          <div class="l-group l-group--xs" data-tabs="target">
            <p class="m-heading m-heading--h2">会社概要</p>
            <table class="m-table">
              <tbody>
              <tr>
                <th>社名</th>
                <td>{{ $job->client->company_name }}</td>
              </tr>
              <tr>
                <th>URL</th>
                <td><a href="{{ $job->client->url }}" target="_blank">{{ $job->client->url }}</a></td>
              </tr>

              @if (trim($job->company_business))
                <tr>
                  <th>事業内容</th>
                  <td>{!! nl2br(e($job->company_business)) !!}</td>
                </tr>
              @endif

              @if (trim($job->company_characteristics))
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
          <div class="col-6">
            @if(!$job->hasAppliedBy($user))
              <input type="submit" value="応募する" class="m-button m-button--default">
            @else
              <p class="m-button is-disable">応募済み</p>
            @endif
          </div>

          <div class="col-6">
            @if(!$job->hasFavoredBy($user))
              <a data-method="post" class="m-button m-button--primary" href="{{ url('/favorite') }}">
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                気になる
              </a>
            @else
              <p class="m-button is-disable">お気に入り済み</p>
            @endif
          </div>
        </div>
      </div>

      <div class="clearfix">
        @if ($related_interviews->count() > 0)
          <div>
            <div class="l-group pull-right" style="width: 50% !important; float:left;">
              <h2 class="m-heading m-heading--h3" style="color:dimgrey">この求人に関連するインタビュー記事</h2>
              <ul class="l-group l-group--s">
                @foreach($related_interviews as $interview)
                  <li>
                    <a href="{{ $interview->url }}" class="l-row pull-left" target="_blank">
                      @if($interview->image)
                        <div class="col-5"><img src="{{ $interview_image_path . '/145x100/' . $interview->image }}" alt=""></div>
                      @else
                        <div class="col-5"><img src="/images/bnr_default_145x100.jpg" alt=""/></div>
                      @endif
                      <div class="col-7 l-group l-group--xs">
                        <p class="m-label m-label--primary">INTERVIEW</p>

                        <p>{{ str_limit($interview->title, 48, '...') }}</p>

                        <p class="m-text m-text--sub m-text--small">{{ str_limit($interview->client->company_name, 16, '...') }}</p>
                      </div>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        <div>
          <div class="l-group pull-right" style="width: 50% !important; float:left;">
            @if($related_jobs->count() > 0)
              <h2 class="m-heading m-heading--h3" style="color:dimgrey">この求人に関連する別の求人</h2>
              <ul class="l-group l-group--s">
                @foreach($related_jobs as $job)
                  <li>
                    <a href="{{ url('/job/'.$job->id.'/detail') }}" class="l-row pull-left" target="_blank">
                      @if($job->main_image)
                        <div class="col-5"><img src="{{ $thumbnail_path . '/145x100/' . $job->main_image }}" alt=""></div>
                      @else
                        <div class="col-5"><img src="/images/bnr_default_145x100.jpg" alt=""/></div>
                      @endif
                      <div class="col-7 l-group l-group--xs">
                        <p class="m-label m-label--status">JOB</p>

                        <p>{{ str_limit($job->title, 48, '...')  }}</p>

                        <p class="m-text m-text--sub m-text--small">{{ str_limit($job->client->company_name, 16, '...') }}</p>
                      </div>
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif

            @if($interested_jobs->count() > 0)
              <h2 class="m-heading m-heading--h3" style="color:dimgrey">この求人を見ている人が見ている他の求人</h2>
              <ul class="l-group l-group--s">
                @foreach($related_jobs as $job)
                  <li>
                    <a href="{{ url('/job/'.$job->id.'/detail') }}" class="l-row pull-left" target="_blank">
                      @if($job->main_image)
                        <div class="col-5"><img src="{{ $thumbnail_path . '/145x100/' . $job->main_image }}" alt=""></div>
                      @else
                        <div class="col-5"><img src="/images/bnr_default_145x100.jpg" alt=""/></div>
                      @endif
                      <div class="col-7 l-group l-group--xs">
                        <p class="m-label m-label--status">JOB</p>

                        <p>{{ str_limit($job->title, 48, '...')  }}</p>

                        <p class="m-text m-text--sub m-text--small">{{ str_limit($job->client->company_name, 16, '...') }}</p>
                      </div>
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
        </div>
      </div>

      <div class="m-text m-text--rtc">
        @include('customer.pc.include.snsButtonList')
      </div>

    </div>

    <div class="globalSide l-group l-group--l col-4">
      <div class="l-group">
        @if($job->side_image1)
          <div class="l-group l-group--xs">
            <div><img src="{{ $side_image_path . '/360x270/' . $job->side_image1 }}" alt=""/>
            </div>
            <p class="m-text m-text--sub">{{ $job->side_image1_caption }}</p>
          </div>
        @endif
        @if($job->side_image2)
          <div class="l-group l-group--xs">
            <div><img src="{{ $side_image_path . '/360x270/' . $job->side_image2 }}" alt=""/>
            </div>
            <p class="m-text m-text--sub">{{ $job->side_image2_caption }}</p>
          </div>
        @endif
        @if($job->side_image3)
          <div class="l-group l-group--xs">
            <div><img src="{{ $side_image_path . '/360x270/' . $job->side_image3 }}" alt=""/>
            </div>
            <p class="m-text m-text--sub">{{ $job->side_image3_caption }}</p>
          </div>
        @endif
      </div>

      <div class="l-group l-group--xs" style="margin-top:20px">
        <div>
          <a href="{{ url('/agent') }}">
            <img src="/images/private_job.jpg" alt=""/>
          </a>
        </div>
      </div>
      <!-- サイド領域内のナビここから -->
  <div class="navs">
    <h2 class="navs-head">職種<span class="navs-head-s">でさがす</span></h2>
    <ul class="navs-menus">
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=1&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>営業職</a>
        <br>法人営業、個人営業、キャリアアドバイザーなど
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=2&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>企画・管理系職</a>
        <br>マーケティング、企画、広告宣伝、経理、財務、総務、人事、法務、広報、経営企画、事業統括、事業開発、その他
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=3&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>エンジニア・技術関連職</a>
        <br>Webエンジニア、アプリエンジニア（iOS、Android等）、プログラマー、通信・インフラエンジニア、ITコンサルタント・システムコンサルタント、システムエンジニア、その他
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=4&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>クリエイティブ・クリエイター系職種</a>
        <br>Webプロデューサー・ディレクター・プランナー、アートディレクター、Webデザイナー・デザイナー、編集／ライター、その他
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=5&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>講師・教員関連職種</a>
        <br>大学講師、小・中・高等学校教員、保育士・幼稚園教諭、研修講師、スクール長 ／教室長／マネージャー、インストラクター、その他
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=6&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>専門職種（コンサルタント・士業系等）</a>
        <br>戦略・経営コンサルタント、組織・人事コンサルタント、業務コンサルタント、その他専門コンサルタント、士業（弁護士・会計士・税理士・弁理士等）
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=7&keyword=" target="_blank"><span class="navs-icon-arrow">&gt;</span>事務系職種</a>
        <br>一般事務、経理事務、営業事務、その他アシスタント
      </li>
      <li class="navs-menu"><a href="https://education-career.jp/job?job_category=8&keyword=s" target="_blank"><span class="navs-icon-arrow">&gt;</span>その他</a>
        <br>
      </li>
    </ul>

    <h2 class="navs-head">勤務地<span class="navs-head-s">でさがす</span></h2>
    <ul class="navs-menus navs-area clearfix">
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>北海道・東北</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=2&keyword=" target="_blank">北海道</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=3&keyword=" target="_blank">青森</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=6&keyword=" target="_blank">秋田</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=4&keyword=" target="_blank">岩手</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=7&keyword=" target="_blank">山形</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=5&keyword=" target="_blank">宮城</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=8&keyword=" target="_blank">福島</a></div>
        </div>
      </li><!-- 北海道・東北 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>関東</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=9&keyword=" target="_blank">茨城</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=10&keyword=" target="_blank">栃木</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=11&keyword=" target="_blank">群馬</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=1&keyword=" target="_blank">東京</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=14&keyword=" target="_blank">神奈川</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=12&keyword=" target="_blank">埼玉</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=13&keyword=" target="_blank">千葉</a></div>
        </div>
      </li><!-- 関東 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>東海</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=23&keyword=" target="_blank">愛知</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=22&keyword=" target="_blank">静岡</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=24&keyword=" target="_blank">三重</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=21&keyword=" target="_blank">岐阜</a></div>
        </div>
      </li><!-- 東海 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>北陸・甲信越</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=16&keyword=" target="_blank">富山</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=17&keyword=" target="_blank">石川</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=18&keyword=" target="_blank">福井</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=15&keyword=" target="_blank">新潟</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=19&keyword=" target="_blank">山梨</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=20&keyword=" target="_blank">長野</a></div>
        </div>
      </li><!-- 北陸・甲信越 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>関西</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=26&keyword=" target="_blank">京都</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=27&keyword=" target="_blank">大阪</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=28&keyword=" target="_blank">兵庫</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=25&keyword=" target="_blank">滋賀</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=29&keyword=" target="_blank">奈良</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=30&keyword=" target="_blank">和歌山</a></div>
        </div>
      </li><!-- 関西 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>中国</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=34&keyword=" target="_blank">広島</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=33&keyword=" target="_blank">岡山</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=35&keyword=" target="_blank">山口</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=31&keyword=" target="_blank">鳥取</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=32&keyword=" target="_blank">島根</a></div>
        </div>
      </li><!-- 中国 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>四国</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=36&keyword=" target="_blank">徳島</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=37&keyword=" target="_blank">香川</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=38&keyword=" target="_blank">愛媛</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=39&keyword=" target="_blank">高知</a></div>
        </div>
      </li><!-- 四国 -->
      <li class="navs-menu"><div class="navs-menu-head"><span class="navs-icon-arrow">&gt;</span>九州・沖縄</div>
        <div class="clearfix">
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=40&keyword=" target="_blank">福岡</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=41&keyword=" target="_blank">佐賀</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=43&keyword=" target="_blank">熊本</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=44&keyword=" target="_blank">大分</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=42&keyword=" target="_blank">長崎</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=45&keyword=" target="_blank">宮崎</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=46&keyword=" target="_blank">鹿児島</a></div>
          <div class="navs-menu-area"><a href="https://education-career.jp/job?job_category=8&prefecture=47&keyword=" target="_blank">沖縄</a></div>
        </div>
      </li><!-- 九州・沖縄 -->
      <!--li class="navs-menu"><a href="#"><span class="navs-icon-arrow">&gt;</span>海外</a></li-->
    </ul>


    <h2 class="navs-head">キーワード<span class="navs-head-s">でさがす</span></h2>
    <p class="navs-guide">会社名や職種名、希望の勤務地などを入力して、転職情報を探せます。</p>
    <form action="{{ url('/job') }}" method="get" class="navs-search clearfix">
      <input type="text" name="search" placeholder="会社名、職種名など" class="navs-search-box"><buttom type="submit" class="navs-search-btn"><span class="sr-only">検索する</span><i class="fa fa-search" aria-hidden="true"></i></buttom>
    </form>
  </div>
  <!-- サイド領域内のナビここまで -->

    </div>

  </div>
</form>
@stop
