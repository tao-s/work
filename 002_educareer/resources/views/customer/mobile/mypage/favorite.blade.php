@extends('customer.mobile.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

  <div class="globalContents__titleBox l-row">
    <h2 class="col-10">気になるリスト</h2>
    <div class="col-2"><span class="num">{{ $favs->total() }}</span>件</div>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/mypage/password') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="put">

    <ul class="l-group l-group--s jobList">
      @foreach ($favs as $fav)
      <li>
        @if($fav->job->main_image)
          <img src="{{ $thumbnail_path . '/390x200/' . $fav->job->main_image }}" alt="">
        @else
          <img src="/images/bnr_default_390x200.jpg" alt="" />
        @endif
        <div class="l-box s">
          <p>{{ $fav->job->title }}</p>
          <p class="m-text m-text--sub m-text--small">{{ $fav->job->client->company_name }}</p>
        </div>
        <div class="l-row l-box s">
          <div class="col-6">
            <a href="{{ url('/job/'.$fav->job->id.'/detail') }}" class="m-button default">詳細を見る</a>
          </div>
          <div class="col-6">
            <a data-method="delete" href="{{ url('/favorite/'.$fav->id) }}" class="m-button negative">削除</a>
          </div>
        </div>
      </li>
      @endforeach
    </ul>

  </form>

  <div class="pager">
    <div>{!! $favs->render() !!}</div>
  </div>
@stop
