@extends('customer.mobile.layout')

@section('title', $seo->title() . ' | 教育業界に特化した就職・転職の求人サービス【Education Career】')
@section('description', $seo->description())
@section('keywords', $seo->keywords())

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

  <div class="globalContents__titleBox">
    <h2>{{ str_limit($seo->title(), 20, '...') }}</h2>
  </div>

  @include('customer.mobile.include.message')

  <div class="pager">
    <div class="pager__hit"><span>{{ $jobs->total() }}</span>件あり、{{ $jobs->firstItem() }} - {{ $jobs->lastItem() }}件を表示</div>
    <div>{!! $jobs->render() !!}</div>
  </div>

  <form action="{{ url('/job') }}" method="get">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <ul class="l-group l-group--s jobList">
    @foreach($jobs as $job)
    <li>
      <a href="{{ url('/job/'.$job->id.'/detail') }}">
        @if($job->main_image)
          <img src="{{ $thumbnail_path . '/390x200/' . $job->main_image }}" alt="">
        @else
          <img src="/images/bnr_default_390x200.jpg" alt="" />
        @endif
        <div class="l-box s">
          <p>{{ $job->title }}</p>
          <p class="m-text m-text--sub m-text--small">{{ $job->client->company_name }}
          @if (86400 * 7 > time() - $job->updated_at->getTimeStamp())
            <span class="m-label m-label--status">新着求人</span>
          @endif
          </p>
        </div>
      </a>
      <div class="l-row l-box s">
        <div class="col-6">
          <a href="{{ url('/job/'.$job->id.'/detail') }}" class="m-button default">詳細を見る</a>
        </div>
        <div class="col-6">
          @if(!$job->hasFavoredBy($user))
            <a data-method="post" class="m-button primary" href="{{ url('/favorite') }}">
              <input type="hidden" name="job_id" value="{{ $job->id }}">
              気になる
            </a>
          @else
            <p class="col-12 m-button is-disable">お気に入り済み</p>
          @endif
        </div>
      </div>
    </li>
    @endforeach
  </ul>
  </form>

  <div class="pager">
    <div class="pager__hit"><span>{{ $jobs->total() }}</span>件あり、{{ $jobs->firstItem() }} - {{ $jobs->lastItem() }}件を表示</div>
    <div>{!! $jobs->render() !!}</div>
  </div>
@stop
