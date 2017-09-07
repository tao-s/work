@extends('customer.pc.layout')

@section('title', '教育業界に特化した就職・転職の求人サービス【Education Career】')
@section('description', 'EducationCareerは教育業界に就職・転職したい方、関心のあるすべての方に向けた求人情報サービスです。正社員や業務委託、パートやアルバイト、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
<script>
  $("input:checkbox").on('click', function() {
    // in the handler, 'this' refers to the box clicked on
    var $box = $(this);
    if ($box.is(":checked")) {
      // the name of the box is retrieved using the .attr() method
      // as it is assumed and expected to be immutable
      var group = "input:checkbox[name='" + $box.attr("name") + "']";
      if ($box.attr("name") == "business_type") {
        var grand_group = "input:checkbox[name='grand_" + $box.attr("name") + "']";
        $(grand_group).prop("checked", false);
      }
      if ($box.attr("name") == "grand_business_type") {
        var child_group = "input:checkbox[name='" + $box.attr("name").replace('grand_', '') + "']";
        $(child_group).prop("checked", false);
      }

      // the checked state of the group/box on the other hand will change
      // and the current value is retrieved using .prop() method
      $(group).prop("checked", false);
      $box.prop("checked", true);
    } else {
      $box.prop("checked", false);
    }
  });

</script>
@stop
@section('slick.js')
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
  <div class="jumbotron">
    <div class="top-slide">

  <div class="slider">
    <p><img src="/images/topimage3.jpg" alt=""></p>
    <p><img src="/images/topimage4.jpg" alt=""></p>
    <p><img src="/images/topimage5.jpg" alt=""></p>
  </div>

  <h2 class="slider-copy">教育業界の転職・仕事探しは「Education Career」</h2>
  <div class="form">
    <form action="https://education-career.jp/job" method="get">
      <p>
          <input type="text" name="keyword" placeholder="フリーワードで検索" value="" class="keyword">
      </p>
      <span>or</span>
      <p>
        <select name="job_category">
          <option value="">職種を選択</option>
          <option  value="1">営業職</option>
          <option  value="2">企画・管理系職</option>
          <option  value="3">エンジニア・技術関連職</option>
          <option  value="4">クリエイティブ・クリエイター系職種</option>
          <option  value="5">講師・教員関連職種</option>
          <option  value="6">専門職種（コンサルタント・士業系等）</option>
          <option  value="7">事務系職種</option>
          <option  value="8">その他</option>
        </select>
      </p>
      <p>
          <select name="prefecture">
            <option value="">勤務地を選択</option>
            <option  value="1">東京都</option>
            <option  value="2">北海道</option>
            <option  value="3">青森県</option>
            <option  value="6">秋田県</option>
            <option  value="4">岩手県</option>
            <option  value="7">山形県</option>
            <option  value="5">宮城県</option>
            <option  value="8">福島県</option>
            <option  value="9">茨城県</option>
            <option  value="10">栃木県</option>
            <option  value="11">群馬県</option>
            <option  value="14">神奈川県</option>
            <option  value="12">埼玉県</option>
            <option  value="13">千葉県</option>
            <option  value="16">富山県</option>
            <option  value="17">石川県</option>
            <option  value="18">福井県</option>
            <option  value="15">新潟県</option>
            <option  value="19">山梨県</option>
            <option  value="20">長野県</option>
            <option  value="23">愛知県</option>
            <option  value="22">静岡県</option>
            <option  value="24">三重県</option>
            <option  value="21">岐阜県</option>
            <option  value="26">京都府</option>
            <option  value="27">大阪府</option>
            <option  value="28">兵庫県</option>
            <option  value="25">滋賀県</option>
            <option  value="29">奈良県</option>
            <option  value="30">和歌山県</option>
            <option  value="34">広島県</option>
            <option  value="33">岡山県</option>
            <option  value="35">山口県</option>
            <option  value="31">鳥取県</option>
            <option  value="32">島根県</option>
            <option  value="36">徳島県</option>
            <option  value="37">香川県</option>
            <option  value="38">愛媛県</option>
            <option  value="39">高知県</option>
            <option  value="40">福岡県</option>
            <option  value="41">佐賀県</option>
            <option  value="43">熊本県</option>
            <option  value="44">大分県</option>
            <option  value="42">長崎県</option>
            <option  value="45">宮崎県</option>
            <option  value="46">鹿児島県</option>
            <option  value="47">沖縄県</option>
        </select>
      </p>
      <p>
        <select name="business_type">
            <option value="">業種を選択</option>
            <option  value="1">大学・大学院</option>
            <option  value="2">高等学校</option>
            <option  value="3">専門学校・短期大学・高専</option>
            <option  value="4">中学校</option>
            <option  value="5">小学校</option>
            <option  value="6">保育園・幼稚園・学童保育</option>
            <option  value="7">フリースクール</option>
            <option  value="8">その他</option>
            <option  value="9">英会話スクール・英語塾</option>
            <option  value="10">中国語・韓国語教室</option>
            <option  value="11">ドイツ・フランス・スペイン教室</option>
            <option  value="12">日本語教室</option>
            <option  value="13">その他語学教室</option>
            <option  value="14">プログラミング・パソコンスクール</option>
            <option  value="15">デザインスクール</option>
            <option  value="16">料理教室、音楽教室、水泳教室</option>
            <option  value="17">フィットネス・ヨガ・ダンス・スポーツ教室</option>
            <option  value="18">資格スクール・予備校</option>
            <option  value="19">予備校</option>
            <option  value="20">学習塾</option>
            <option  value="21">幼児教室</option>
            <option  value="22">出版・コンテンツ制作会社</option>
            <option  value="23">Webサービス・アプリ開発／運営</option>
            <option  value="24">留学斡旋・サポート</option>
            <option  value="25">学校・スクール・教室運営</option>
        </select>
      </p>
      <p>
        <select name="employment_status">
          <option value="">働き方を選択</option>
          <option  value="1">フルタイム（正社員・契約社員)</option>
          <option  value="2">パート・アルバイト・インターン</option>
          <option  value="3">業務委託</option>
          <option  value="4">プロボノ・ボランティア</option>
          <option  value="5">フランチャイズオーナー</option>
          <option  value="6">その他</option>
        </select>
      </p>
        <p><input type="submit" value="求人を検索する" class="submit m-button m-button--primary"></p>
    </form>
  </div>
  <div class="recuit">
    <p class="m-button m-button--default"><a href="{{ url('/recruiter') }}">採用を検討中の企業様はこちら</a></p>
    </div>

</div>
  </div>
<div class="banner-top"><a href="{{ url('/agent') }}"><img src="/images/banner01.png"></a></div>



  <div class="globalViewport l-row">

    <div class="globalMain globalMain--hook l-group col-8">

      <div class="l-group l-group--s">
        <h2 class="m-heading m-heading--h2">Education Career おすすめの求人</h2>

        <div class="l-group">
          @foreach ($pickups as $row)
            <ul class="clearfix l-row">
              @foreach ($row as $pickup)
                  <li class="col-6">
                    <a href="{{ url('/job/'.$pickup->id.'/detail') }}" class="m-card">
                      @if ($pickup->main_image)
                        <div><img src="{{ $thumbnail_path . '/390x200/' . $pickup->main_image }}" alt=""/></div>
                      @else
                        <div><img src="/images/bnr_default_390x200.jpg" alt=""/></div>
                      @endif
                      <div class="m-card__caption l-group l-group--xs">
                        <p class="m-text bold">{{ $pickup->title }}</p>
                        <p class="m-text m-text--sub">{{ $pickup->client->company_name }}</p>
                      </div>
                    </a>
                  </li>
              @endforeach
            </ul>
          @endforeach
        </div>
      </div>
      
      <div class="bottomtext">
            <div class="logobox">
                <div class="logol"><img src="/images/logo_p1.png" alt=""></div></div>
          <div class="companytext"><h3>教育業界の転職ならEducation Career</h3><br>
Education Careerは、教育業界に特化した転職、求人サービスです。<br>
教育業界の仕事でイメージしやすい、学習塾での講師や教室長、スーパーバイザーなどの仕事はもちろん、教育関連サービスの営業職や、人事などのバックオフィスの募集まで幅広い求人を取り扱っています。<br>
誰もが知るような有名企業や、知る人ぞ知る優良企業、成長著しいベンチャーや、スタートアップなどもご紹介しております。<br>
また、サイトでは公開していない非公開求人もございますので、教育分野での転職に興味のあるかたは、教育業界専門の転職エージェントにぜひご相談下さい。</div>
      
    </div>
</div>

    <div class="globalSide l-group l-group--l col-4">
      <div class="l-group l-group--s">
        <h2 class="m-heading m-heading--h2">転職役立ちコラム/教育業界ニュース</h2>
        <ul class="l-group s">
          @foreach ($interviews as $interview)
            <li>
              <a href="{{ $interview->url }}" class="l-row clearfix" target="_blank">
                <div class="col-5"><img src="{{ $interview_image_path . '/145x100/' . $interview->image }}" alt=""/></div>
                <div class="col-7 l-group l-group--xs">

                  <p>{{ str_limit($interview->title, 48, '...') }}</p>

                  <p class="m-text m-text--sub m-text--small">{{ str_limit($interview->client->company_name, 16, '...') }}</p>
                </div>
              </a>
            </li>
          @endforeach
        </ul>
      </div>


      <div class="l-group l-group--s">
        @include('customer.pc.include.facebook_page')
      </div>

      {{--<div class="l-group l-group--s">--}}
        {{--<h2 class="m-heading m-heading--h2">その他の記事</h2>--}}
        {{--<ul class="m-list m-list--article">--}}
          {{--<li><a href="#">...</a></li>--}}
          {{--<li><a href="#">...</a></li>--}}
          {{--<li><a href="#">...</a></li>--}}
        {{--</ul>--}}
      {{--</div>--}}

      {{--<div class="adBanner">--}}
        {{--<a href="#"><img src="http://dummyimage.com/360x120/000/fff" alt=""/></a>--}}
      {{--</div>--}}
    </div>

  
            
          
          </div>
<div class="banner-bottom"><a href="{{ url('/agent') }}"><img src="/images/banner02.png"></a></div>
@stop
