@extends('customer.pc.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
@stop

@section('content')
  <div class="globalViewport l-row">
    <div class="globalMain globalMain--narrow">
      @include('customer.pc.include.message')
      <div class="l-group">
        <h2 class="m-heading m-heading--h2">ご応募ありがとうございます</h2>
        <p>
          求人にご応募いただきありがとうございます。採用の可否、今後の選考フローに関してのご連絡をお待ちください。
        </p>

        @if ($jobs1->count())
        <h2 class="m-heading m-heading--h2">関連求人</h2>
        <div class="l-group pull-right" style="width: 45% !important; float:left;">
          <ul class="l-group l-group--s">
            @foreach($jobs1 as $job)
              <li>
                <a href="{{ url('/job/'.$job->id.'/detail') }}" class="l-row pull-left" target="_blank">
                  @if ($job->main_image)
                    <div class="col-5"><img src="{{ $thumbnail_path . '/390x200/' . $job->main_image }}" alt="" /></div>
                  @else
                    <div class="col-5"><img src="/images/bnr_default_390x200.jpg" alt=""/></div>
                  @endif
                  <div class="col-7 l-group l-group--xs">
                    <p>{{ $job->title }}</p>

                    <p class="m-text m-text--sub m-text--small">{{ $job->client->company_name }}</p>
                  </div>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        @endif

        @if ($jobs2->count())
          <div class="l-group pull-right" style="width: 45% !important; float:left;margin-left:10px">
            <ul class="l-group l-group--s">
              @foreach($jobs2 as $job)
                <li>
                  <a href="{{ url('/job/'.$job->id.'/detail') }}" class="l-row pull-left" target="_blank">
                    <div class="col-5"><img src="{{ $thumbnail_path . '/390x200/' . $job->main_image }}" alt="" /></div>

                    <div class="col-7 l-group l-group--xs">
                      <p>{{ $job->title }}</p>

                      <p class="m-text m-text--sub m-text--small">{{ $job->client->company_name }}</p>
                    </div>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        @endif

      </div>
  </div>
@stop
