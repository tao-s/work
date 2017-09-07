@extends('customer.mobile.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

  <div class="about">
    <img src="/mobile/images/about.jpg" alt="">
    <div class="about__education-career">
      <h1>Education Careerとは？</h1>
      <p>
        Education Careerは、教育業界、教育関係の仕事に<br>
        特化した求人・転職支援サービスです。<br>
        教育業界で多様な働き方、<br>
        職種の求人・転職情報を掲載しています。<br>
        教育関係の仕事で、子供の役に立ちたい、<br>
        社会に貢献したいという方や企業の支援を行っています。
      </p>
    </div>
    <div class="about__register">
      <div class="l-row l-box s">
        <a href="{{ url('/register') }}" class="m-button primary col-12">無料会員登録</a>
      </div>
    </div>
  </div>

  <div class="globalContents__titleBox">
    <h2>Education Careerの特徴</h2>
  </div>

  <div class="feature">
    <div>
      <img src="/mobile/images/icon-book.png" alt="教育関連業界に特化">
      <h3>教育業界に特化</h3>
      <p>Education Careerは、教育関連産業の求人に特化しています。 教育分野でのやりがいのある仕事を見つけることができます。</p>
    </div>
    <div>
      <img src="/mobile/images/icon-user.png" alt="多様な働き方を選択可能">
      <h3>多様な働き方を選択可能</h3>
      <p>フルタイムでの募集はもちろん、インターンや業務委託、今の勤務先を辞めずに手伝いが可能なプロボノ・ボランティアなど多くの求人を掲載しています。</p>
    </div>
    <div>
      <img src="/mobile/images/icon-documents.png" alt="EdTech Mediaで関連情報を得られる">
      <h3>関連情報を得る</h3>
      <p>Education Careerの姉妹サイトである<a href="http://edtech-media.com/" target="_blank">EdTech Media</a>で求人企業の関連ニュースを読むことができ、深い会社の理解が可能です。</p>
    </div>
  </div>

  <div class="globalContents__titleBox">
    <h2>応募の流れ</h2>
  </div>

  <div class="flow l-group l-group--s">
    <div class="flow__step">
      1 無料会員登録
    </div>
    <div class="flow__arrow"><img src="/mobile/images/arrow_bottom.png" alt=""></div>
    <div class="flow__step">
      2 求人を探す
    </div>
    <div class="flow__arrow"><img src="/mobile/images/arrow_bottom.png" alt=""></div>
    <div class="flow__step">
      3 気になる企業に応募
    </div>
  </div>

  <div class="globalContents__titleBox">
    <h2>専門のエージェントに無料で相談できる</h2>
  </div>

  <div class="l-box s">
    <p>Education Careerでは、教育関係の仕事に特化した専門のエージェント（キャリアコンサルタント）が相談に応じます《無料》<br>
      キャリアのご要望をお伺いし、最適な選択肢をご紹介します。
      面接のアドバイス、志望動機の書き方、職務経歴書添削など、転職活動におけるサポートも無料で行います。<br>
      以下の転職相談フォームよりお気軽にお問い合わせください。
    </p>
  </div>
  <div class="l-row l-box s">
    <a href="{{ url('/agent') }}" class="m-button primary col-12">エージェントに無料で相談する</a>
  </div>

@stop
