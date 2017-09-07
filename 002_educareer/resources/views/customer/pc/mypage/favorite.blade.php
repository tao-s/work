@extends('customer.pc.layout_mypage')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')
<div class="globalMain globalMain--hook l-group col-8">
  <div class="l-group">
    <div class="breadcrumbs">
      <a href="{{ url('/') }}">ホーム</a>
      <span>&gt;</span>
      <a href="{{ url('/mypage') }}">マイページ</a>
      <span>&gt;</span>
      <strong>気になるリスト</strong>
    </div>

    @include('customer.pc.include.message')

    <h1><strong class="m-heading m-heading--h2">気になるリスト <span class="m-text m-text--error">{{ $favs->total() }}</span> </strong>件</h1>

    <form action="{{ url('/mypage/password') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="_method" value="put">

      <div class="l-group l-group--l">
        @foreach ($favs as $fav)
        <div class="l-row">
          <div class="col-6">
            <a href="{{ url('/job/'.$fav->job->id.'/detail') }}">
              @if($fav->job->main_image)
                <img src="{{ $thumbnail_path . '/390x200/' . $fav->job->main_image }}" alt="" />
              @else
                <img src="/images/bnr_default_390x200.jpg" alt="" />
              @endif
            </a>
          </div>
          <div class="col-6 l-group">
            <div class="l-group l-group--xs">
              <h2 class="m-heading m-heading--h2">{{ $fav->job->title }}</h2>
              <p class="m-text m-text--sub">{{ $fav->job->client->company_name }}</p>
            </div>
            <ul class="clearfix l-row">
              <li class="col-6"><a class="m-button m-button--default" href="{{ url('/job/'.$fav->job->id.'/detail') }}">詳細を見る</a></li>
              <li class="col-6"><a data-method="delete" class="m-button m-button--negative" href="{{ url('/favorite/'.$fav->id) }}">削除</a></li>
            </ul>
          </div>
        </div>
        @endforeach
      </div>

    </form>

    <div>{!! $favs->render() !!}</div>

  </div>
</div>
@stop
