@extends('customer.mobile.layout')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
<script>
    $(function() {
    $('.slider').slick({
      infinite: true,
      dots:true,
      slidesToShow: 1,
      centerMode: true, //要素を中央寄せ
      centerPadding:'0', //両サイドの見えている部分のサイズ
      autoplay:true, //自動再生
      pauseOnHover:false,
      fade:true,
      responsive: [{
        breakpoint: 480,
        settings: {
          centerMode: false,
      }
    }]
  });
});
</script>
@stop

@section('content')
  <div class="slider">
   
    <p><img src="/images/topimage3.jpg" alt=""></p>
    <p><img src="/images/topimage4.jpg" alt=""></p>
    <p><img src="/images/topimage5.jpg" alt=""></p>
  </div>

  <h2 class="slider-copy">教育業界の転職・仕事探しは「Education Career」</h2>

  <div class="globalContents__titleBox">
    <h2 style="text-align: center;">教育業界の求人・転職情報を探す</h2>
  </div>
  <div class="slider2">
    <div class="searchLinks">
      <a href="{{ url('/search') }}" style="border-right: solid 1px #ffffff;border-bottom: solid 1px #ffffff;">
        <p><span>職種</span>で探す</p>
      </a>
      <a href="{{ url('/search') }}" style="border-left: solid 1px #ffffff;border-bottom: solid 1px #ffffff;">
        <p><span>勤務地</span>で探す</p>
      </a>
      <a href="{{ url('/search') }}" style="border-right: solid 1px #ffffff;border-top: solid 1px #ffffff;">
        <p><span>業態</span>で探す</p>
      </a>
      <a href="{{ url('/search') }}" style="border-left: solid 1px #ffffff;border-top: solid 1px #ffffff;">
        <p><span>働き方</span>で探す</p>
      </a>
    </div>
    <form action="{{ url('/job') }}" method="get" class="keyword-box">
      <input type="text" value="" style="margin-top: 15px;" name="keyword" placeholder="フリーワードで">
      <button type="submit" class="search-button">検索</button>
    </form>
  </div>
  <div class="agentbanner">
      <a href="/agent" class="mbanner"><img src="/images/banner-agent1.jpg" alt="転職エージェントに相談"></a>
  </div>
  <div class="clientbanner">
      <a href="/recruiter" class="mbanner"><img src="/images/banner-client.jpg" alt="教育業界の中途採用なら"></a>
  </div>

  <div class="globalContents__titleBox">
    <h2>Education Career おすすめの求人</h2>
  </div>
  <div class="slider2">
    <ul>
      @foreach ($pickups as $row)
        @foreach($row as $job)
          <li class="l-box s">
            <a href="{{ url('/job/'.$job->id.'/detail') }}" class="slider__box">
              @if($job->main_image)
                <img src="{{ $thumbnail_path . '/390x200/' . $job->main_image }}" alt="">
              @else
                <div><img src="/images/bnr_default_390x200.jpg" alt=""/></div>
              @endif
              <div class="l-box s">
                <p>{{ $job->title }}</p>
                <p class="m-text m-text--sub m-text--small">{{ $job->client->company_name }}</p>
              </div>
            </a>
          </li>
        @endforeach
      @endforeach
    </ul>
  </div>

  <div class="globalContents__titleBox">
    <h2>転職役立ちコラム/教育業界ニュース</h2>
  </div>
  <ul class="m-list m-list--article">
    @foreach ($interviews as $interview)
    <li>
      <a class="l-row" href="{{ $interview->url }}">
        <div class="col-5">
          @if($interview->image)
            <img src="{{ $interview_image_path . '/145x100/' . $interview->image }}" alt="">
          @else
            <img src="/images/bnr_default_145x100.jpg" alt=""/>
          @endif
        </div>
        <div class="col-7 l-group l-group--xs">
          <p>{{ str_limit($interview->title, 45, '...') }}</p>
          <p class="m-text m-text--sub m-text--small">{{ $interview->client->company_name }}</p>
        </div>
      </a>
    </li>
    @endforeach
  </ul>

  {{--
  <div class="globalContents__titleBox">
    <h2>その他記事</h2>
  </div>
  <ul class="m-list m-list--article">
    <li>
      <a href="#">
        <p>勉強SNSのスタディプラスが、英単語アプリ「ラーニングドラゴン」</p>
      </a>
    </li>
    <li>
      <a href="#">
        <p>勉強SNSのスタディプラスが、英単語アプリ「ラーニングドラゴン」</p>
      </a>
    </li>
    <li>
      <a href="#">
        <p>勉強SNSのスタディプラスが、英単語アプリ「ラーニングドラゴン」</p>
      </a>
    </li>
  </ul>
  --}}

@stop
