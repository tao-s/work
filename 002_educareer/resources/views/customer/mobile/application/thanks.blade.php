@extends('customer.mobile.layout')

@section('custom_js')
@stop

@section('content')

  @include('customer.mobile.include.message')

  <h2 class="m-heading m-heading--h2">ご応募ありがとうございます</h2>
  <div class="globalViewport l-row l-box s">
    <div class="globalMain globalMain--narrow">
      <div class="l-group">
        <p>求人にご応募いただきありがとうございます。採用の可否、今後の選考フローに関してのご連絡をお待ちください。</p>
    </div>
    </div>
  </div>
  <h2 class="m-heading m-heading--h2">関連求人</h2>
  <div class="globalViewport l-row l-box s">
    <div class="globalMain globalMain--narrow">
      <div class="l-group">
        <ul class="m-list m-list--article">
          @foreach ($jobs1 as $job)
          <li>
            <a class="l-row" href="{{ url('/job/'.$job->id.'/detail') }}">
              @if ($job->main_image)
                <div class="col-5"><img src="{{ $thumbnail_path . '/390x200/' . $job->main_image }}" alt=""></div>
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
    </div>
  </div>
@stop
