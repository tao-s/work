@extends('customer.pc.layout')

@section('title', 'Education Careerとは | 教育関係の仕事に特化した就職・転職の求人サービス【Education Career】')
@section('description', 'Education Careerについて。EducationCareerは教育関係の仕事に関心のあるすべての方に向けた求人サービスです。正社員や業務委託、パートやアルバイト、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')
  <div class="messageUnit">
    <div class="l-group l-group--xl l-stage">
      <div class="l-group l-group--xs">
        <h1 class="m-heading m-heading--h1">Education Careerとは</h1>
        <p>
          Education Careerは、教育業界、教育関係の仕事に特化した求人・転職支援サービスです。<br>
          教育業界で多様な働き方、職種の求人・転職情報を掲載しています。<br>
          教育関係の仕事で、子供の役に立ちたい、社会に貢献したいという方や企業の支援を行っています。
        </p>
      </div>
      <div class="l-row l-row--xs">
        <a href="{{ url('/register') }}" class="m-button m-button--primary">無料会員登録</a>
      </div>
    </div>
  </div>

  <div class="featureUnit m-text m-text--rtc">
    <div class="l-stage l-group l-group--l">
      <h2 class="m-heading m-heading--h1">Education Careerの特徴</h2>
      <div class="l-row">
        <div class="col-4 l-group l-group--s">
          <div class="featureUnit__icon"><span class="icon--book"></span></div>
          <h3 class="m-heading m-heading--h2">教育業界に特化</h3>
          <p>Education Careerは、教育関連産業の求人に特化しています。 教育分野でのやりがいのある仕事を見つけることができます。</p>
        </div>

        <div class="col-4 l-group l-group--s">
          <div class="featureUnit__icon"><span class="icon--user"></span></div>
          <h3 class="m-heading m-heading--h2">多様な働き方を選択可能</h3>
          <p>フルタイムでの募集はもちろん、インターンや業務委託、今の勤務先を辞めずに手伝いが可能なプロボノ・ボランティアなど多くの求人を掲載しています。</p>
        </div>

        <div class="col-4 l-group l-group--s">
          <div class="featureUnit__icon"><span class="icon--documents"></span></div>
          <h3 class="m-heading m-heading--h2">関連情報を得る</h3>
          <p>Education Careerの姉妹サイトである<a href="http://edtech-media.com/" target="_blank">EdTech Media</a>で求人企業の関連ニュースを読むことができ、深い会社の理解が可能です。</p>
        </div>
      </div>
    </div>
  </div>

  <div class="cvUnit l-group l-group--xs">
    <div class="l-stage l-group l-group--l">
      <div class="m-text m-text--rtc">
        <h2 class="m-heading m-heading--h1">応募までの流れ</h2>
      </div>
      <div class="l-group l-group--xs">
        <div><img src="/images/step.png" alt="1 無料会員登録 2 求人を探す 3 気になる企業に応募" /></div>
      </div>
    </div>
  </div>

  <div class="featureUnit">
    <div class="l-stage l-group l-group--l">
      <div class="l-group l-group--xs m-text m-text--rtc">
        <h2 class="m-heading m-heading--h1">専門のエージェントに無料で相談できる</h2>
        <p>Education Careerでは、教育関係の仕事に特化した専門のエージェント（キャリアコンサルタント）が相談に応じます《無料》<br>
          キャリアのご要望をお伺いし、最適な選択肢をご紹介します。<br>
          面接のアドバイス、志望動機の書き方、職務経歴書添削など、転職活動におけるサポートも無料で行います。<br>
          以下の転職相談フォームよりお気軽にお問い合わせください。
        </p>
      </div>
      <div class="l-row l-row--xs">
        <a href="{{ url('/agent') }}" class="m-button m-button--primary">エージェントに無料で相談する</a>
      </div>
    </div>
  </div>

@stop
