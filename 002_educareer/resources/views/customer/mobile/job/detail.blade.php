@extends('customer.mobile.layout')

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
@stop

@section('custom_js')
  @include('customer.mobile.include.sns')
  {!! Html::script('js/nested_select.js') !!}
@stop

@section('content')
  <form action="{{ url('/application') }}" method="post">

  <div class="detailMain">

    @include('customer.mobile.include.message')

    @if($job->main_image)
      <img src="{{ $thumbnail_path . '/780x400/' . $job->main_image }}" alt=""/>
    @else
      <img src="/images/bnr_default_780x400.jpg" alt=""/>
    @endif
    <div class="l-box s l-group l-group--s">
      <p class="detailMain__company">{{ $job->client->company_name }}</p>
      <p class="detailMain__catch">{{$job->title}}</p>
      <div class="l-row">
        <div class="col-6">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          @if(!$job->hasAppliedBy($user))
            <input type="button" value="応募する" class="col-12 m-button default" onclick="location.href='#entry'">
          @else
            <p class="col-12 m-button is-disable">応募済み</p>
          @endif
        </div>
        <div class="col-6">
          @if(!$job->hasFavoredBy($user))
            <a data-method="post" class="col-12 m-button primary" href="{{ url('/favorite') }}">
              <input type="hidden" name="job_id" value="{{ $job->id }}">
              気になる
            </a>
          @else
            <p class="col-12 m-button is-disable">お気に入り済み</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="l-group l-box s">
    <p>{!! nl2br(e($job->main_message)) !!}</p>
  </div>

  @if($job->side_image1)
  <div class="slider">
    <ul>
      <li><img src="{{ $side_image_path . '/360x270/' . $job->side_image1 }}" alt=""/><p class="m-text m-text--sub">{{ $job->side_image1_caption }}</p></li>
    @if($job->side_image2)
      <li><img src="{{ $side_image_path . '/360x270/' . $job->side_image2 }}" alt=""/><p class="m-text m-text--sub">{{ $job->side_image2_caption }}</p></li>
    @endif
    @if($job->side_image3)
      <li><img src="{{ $side_image_path . '/360x270/' . $job->side_image3 }}" alt=""/><p class="m-text m-text--sub">{{ $job->side_image3_caption }}</p></li>
    @endif
    </ul>
  </div>
  @endif

  <div class="jobInfo">
    <div class="jobInfo__tabBtn l-row" data-sptabs="trigger">
      <div class="col-6 is-active"><span><a href="#">募集要項</a></span></div>
      <div class="col-6"><span><a href="#">会社概要</a></span></div>
    </div>
    <div class="jobInfo__tabMain" data-sptabs="target">
      <div class="is-active">
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
          @if (trim($job->background))
          <tr>
            <th>募集の背景</th>
            <td>
              {!! nl2br(e($job->background)) !!}
            </td>
          </tr>
          @endif

          @if (trim($job->job_description))
          <tr>
            <th>仕事内容</th>
            <td>
              {!! nl2br(e($job->job_description)) !!}
            </td>
          </tr>
          @endif

          @if (trim($job->job_qualification))
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

          @if (trim($job->job_place))
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

          @if (trim($job->work_hour))
          <tr>
            <th>勤務時間</th>
            <td>{!! nl2br(e($job->work_hour)) !!}</td>
          </tr>
          @endif

          @if (trim($job->salary))
          <tr>
            <th>給与</th>
            <td>{!! nl2br(e($job->salary)) !!}</td>
          </tr>
          @endif

          @if (trim($job->benefit))
          <tr>
            <th>待遇・福利厚生</th>
            <td>{!! nl2br(e($job->benefit)) !!}</td>
          </tr>
          @endif

          @if (trim($job->holiday))
          <tr>
            <th>休日・休暇</th>
            <td>{!! nl2br(e($job->holiday)) !!}</td>
          </tr>
          @endif
          </tbody>
        </table>
      </div>
      <div>
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
    </div>
  </div>

  <div class="globalContents__titleBox" id="entry">
    <h2>この求人に応募する</h2>
  </div>

  @include('customer.mobile.include.application_form')

  <div class="l-row l-box s">
    <div class="col-6">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      @if(!$job->hasAppliedBy($user))
        <input type="submit" value="応募する" class="col-12 m-button default">
      @else
        <p class="col-12 m-button is-disable">応募済み</p>
      @endif
    </div>
    <div class="col-6">
      @if(!$job->hasFavoredBy($user))
        <a data-method="post" class="col-12 m-button primary" href="{{ url('/favorite') }}">
          <input type="hidden" name="job_id" value="{{ $job->id }}">
          気になる
        </a>
      @else
        <p class="col-12 m-button is-disable">お気に入り済み</p>
      @endif
    </div>
  </div>

  @if($related_interviews->count() > 0)
  <div class="globalContents__titleBox">
    <h2>関連ニュース/インタビュー</h2>
  </div>
  <ul class="m-list m-list--article">
    @foreach ($related_interviews as $interview)
      <li>
        <a class="l-row" href="{{ $interview->url }}">
          <div class="col-5"><img src="{{ $interview_image_path . '/145x100/' . $interview->image }}" alt=""></div>
          <div class="col-7 l-group l-group--xs">
            <p class="m-label m-label--primary">INTERVIEW</p>
            <p>{{ str_limit($interview->title, 45, '...') }}</p>
            <p class="m-text m-text--sub m-text--small">{{ $interview->client->company_name }}</p>
          </div>
        </a>
      </li>
    @endforeach
  </ul>
  @endif

  @if($related_jobs->count() > 0)
    <div class="globalContents__titleBox">
      <h2>この企業の他の求人</h2>
    </div>
    <ul class="m-list m-list--article">
      @foreach ($related_jobs as $job)
        <li>
          <a class="l-row" href="{{ url('/job/'.$job->id.'/detail') }}">
            <div class="col-5">
              @if($job->main_image)
                <img src="{{ $thumbnail_path . '/145x100/' . $job->main_image }}" alt="">
              @else
                <img src="/images/bnr_default_145x100.jpg" alt=""/>
              @endif
            </div>
            <div class="col-7 l-group l-group--xs">
              <p>{{ str_limit($job->title, 45, '...') }}</p>
              <p class="m-text m-text--sub m-text--small">{{ $job->client->company_name }}</p>
            </div>
          </a>
        </li>
      @endforeach
    </ul>
  @endif

  @if($related_jobs->count() > 0)
    <div class="globalContents__titleBox">
      <h2>関連したおすすめの求人</h2>
    </div>
    <ul class="m-list m-list--article">
      @foreach ($interested_jobs as $job)
        <li>
          <a class="l-row" href="{{ url('/job/'.$job->id.'/detail') }}">
            <div class="col-5">
              @if($job->main_image)
                <img src="{{ $thumbnail_path . '/145x100/' . $job->main_image }}" alt="">
              @else
                <img src="/images/bnr_default_145x100.jpg" alt=""/>
              @endif
            </div>
            <div class="col-7 l-group l-group--xs">
              <p>{{ str_limit($job->title, 45, '...') }}</p>
              <p class="m-text m-text--sub m-text--small">{{ $job->client->company_name }}</p>
            </div>
          </a>
        </li>
      @endforeach
    </ul>
  @endif

  <div class="l-box s">
    @include('customer.mobile.include.snsButtonList')
  </div>

</form>
@stop
