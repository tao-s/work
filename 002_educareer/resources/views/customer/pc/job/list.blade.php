@extends('customer.pc.layout')

@section('title', $seo->title() . ' | 教育業界に特化した就職・転職の求人サービス【Education Career】')
@section('description', $seo->description())
@section('keywords', $seo->keywords())

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')
<div class="globalViewport l-row">
  <div class="breadcrumbs">
    <a href="{{ url('/') }}">ホーム</a>
    <span>&gt;</span>
    <strong>求人を探す</strong>
  </div>

  @include('customer.pc.include.message')

  <div class="l-group">
    <div class="advancedSearch l-group l-group--s">
      <h2 class="m-heading m-heading--h2">{{ $seo->title() }}</h2>

      <form action="{{ url('/job') }}" method="get">
        <div class="l-group l-group--s">
    
          <div class="l-row">
            <select name="job_category" class="col-6">
              <option value="">職種</option>
              @foreach($job_categories as $jc)
                <option {{ isset($query['job_category']) && $query['job_category'] == $jc->id ? 'selected' : '' }} value="{{ $jc->id }}">{{ $jc->title }}</option>
              @endforeach
            </select>
            <select name="employment_status" class="col-6">
              <option value="">働き方</option>
              @foreach($employment_status as $ec)
                <option {{ isset($query['employment_status']) && $query['employment_status'] == $ec->id ? 'selected' : '' }} value="{{ $ec->id }}">{{ $ec->title }}</option>
              @endforeach
            </select>
          </div>
    
          <div class="l-row">
            <select name="business_type" class="col-6">
              <option value="">業態</option>
              @foreach($business_types as $bc)
                <option {{ isset($query['business_type']) && $query['business_type'] == $bc->id ? 'selected' : '' }} value="{{ $bc->id }}">{{ $bc->title }}</option>
              @endforeach
            </select>
            <select name="prefecture" class="col-6">
              <option value="">勤務地</option>
              @foreach($prefectures as $pf)
                <option {{ isset($query['prefecture']) && $query['prefecture'] == $pf->id ? 'selected' : '' }} value="{{ $pf->id }}">{{ $pf->formal_title }}</option>
              @endforeach
            </select>
          </div>

          <div class="l-row">
            <input type="text" name="keyword" placeholder="社名、職種名、業種、働き方などフリーワードを入力して検索する" value="{{ isset($query['keyword']) ? $query['keyword'] : '' }}">
          </div>
    
          <div class="l-row">
            <input type="submit" value="検索する" class="m-button m-button--default col-3--rtl"/>
          </div>
        </div>
      </form>
    </div>
    
    <div class="l-group l-group--xs">
      <p>この条件の求人 <span class="m-text m-text--error">{{ $jobs->total() }}</span> 件あり、{{ $jobs->firstItem() }} ~ {{ $jobs->lastItem() }}件を表示</p>
      <div>{!! $jobs->render() !!}</div>
    </div>
    
    <div class="l-group">
      @foreach($jobs as $job)
      <div class="jobCard">
        <div class="jobCard__header clearfix">
          <h2 class="jobCard__header__heading">{{ str_limit($job->title, 60, '...') }}</h2>
        </div>
        <div class="jobCard__company">
          <p>
            <strong class="m-text m-text--bold">{{ $job->client->company_name }}</strong>
            @if (86400 * 7 > time() - $job->created_at->getTimeStamp())
            <span class="m-label m-label--status">新着求人</span>
            @endif
          </p>
        </div>
        <div class="jobCard__body">
          <div class="l-row">
            <div class="col-4">
              <a href="{{ url('/job/'.$job->id.'/detail') }}">
                @if ($job->main_image)
                  <img src="{{ $thumbnail_path . '/390x200/' . $job->main_image }}" alt="" />
                @else
                  <img src="/images/bnr_default_390x200.jpg" alt="" />
                @endif
              </a>
            </div>
            <div class="col-8">
              <table class="jobCard__profile">
                <tbody>
                  @if ( !empty($job->job_title) )
                  <tr>
                    <th><span>職種</span></th>
                    <td>{{ $job->job_title }}</td>
                  </tr>
                  @endif
    
                  @if ( !empty($job->job_description) )
                  <tr>
                    <th><span>仕事内容</span></th>
                    <td>{{ str_limit($job->job_description, 140, '...') }}</td>
                  </tr>
                  @endif
    
    
                  @if ( !empty($job->employment_status->title) )
                  <tr>
                    <th><span>雇用形態</span></th>
                    <td>{{ $job->employment_status->title }}</td>
                  </tr>
                  @endif
    
    
                  @if ( !empty($job->salary) )
                  <tr>
                    <th><span>給与</span></th>
                    <td>{{ str_limit($job->salary, 140, '...') }}</td>
                  </tr>
                  @endif
    
    
                  @if ( !empty($job->work_place) )
                  <tr>
                    <th><span>勤務地</span></th>
                    <td>{{ str_limit($job->work_place, 140, '...') }}</td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    
        <div class="jobCard__cv">
          <div class="l-row l-row--s">
            <div class="col-6">
              <a class="m-button m-button--default" href="{{ url('/job/'.$job->id.'/detail') }}">この求人の詳細を見る</a>
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
      @endforeach
    </div>
    
    <div class="l-group l-group--xs">
      <p>この条件の求人 <span class="m-text m-text--error">{{ $jobs->total() }}</span> 件あり、{{ $jobs->firstItem() }} - {{ $jobs->lastItem() }}件を表示</p>
      <div>{!! $jobs->render() !!}</div>
    </div>
  </div>

</div>
@stop
