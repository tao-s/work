@extends('customer.mobile.layout')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

  <div class="full-content">
  <h2 class="main-copy">教育業界の中途採用なら「Education Career」</h2>
  <div class="float">
  <div class="contact-btn">
    <p class="contact-txt">詳細のご案内をご希望の企業・担当者様はこちら</p>
    <p class="c-btn"><a href="/contact" class="m-button m-button--primary">お問い合わせ</a></p>
  </div>
  </div>
</div>

<div class="content1">
  <h2>教育業界専門の転職サイト<br>Education Careerの特徴</h2>
  <div class="feature1">
    <section class="feature-box">
      <div class="img-box"><img class="f-img" src="/images/image1.jpg" alt=""></div>
      <div class="feature-bc"><figcaption>求人の掲載は全て無料、期間の制限もありません</figcaption></div>
      <p class="feature-txt">Education Careerは無料で求人広告の掲載が可能です。<br> アカウント開設後にすぐにご利用開始いただけます。 掲載期限もありません。<br>
          フルタイム（正社員・契約社員）の募集のみ、採用成功時に成功報酬を頂戴しております。（※別途弊社と人材紹介契約を締結頂きます）</p>      
    </section>
    <section class="feature-box">
      <div class="img-box"><img class="f-img2" src="/images/image2.jpg" alt=""></div>
      <div class="feature-bc"><figcaption>職種、業態、雇用形態こだわらず利用が可能</figcaption></div>
      <p class="feature-txt">講師関連職や営業、エンジニア、バックオフィスなど職種や雇用形態によらず求人掲載が可能です。<br>
          教育業界の採用にお困りの場合は、ぜひEducation Careerをご活用ください。</p>
    </section>
    <section class="feature-box">
      <div class="img-box"><img class="f-img2" src="/images/image3.jpg" alt=""></div>
      <div class="feature-bc"><figcaption>シンプルな管理画面で、求人作成・応募管理もカンタン</figcaption></div>
        <p class="feature-txt">貴社専用のシンプルな管理画面で、カンタンに求人広告の作成や応募者の管理が可能です。<br>公開・非公開、公開後の編集もご自由に行って頂くことが可能です。</p>
    </section>
  </div>
  <div class="feature2">
    <section class="feature-box">
      <div class="img-box"><img class="f-img" src="/images/image4.png" alt=""></div>
      <div class="feature-bc"><figcaption>教育業界に関心の高い求職者に出会える</figcaption></div>
      <p class="feature-txt">EdTech Media（教育×テクノロジーに特化したWebメディア）との連携、 業界に特化したプロモーションにより教育業界への関心の高い求職者と出会うことが可能です。<br>
          ※詳細はお問い合わせください。</p>
    </section>
    <section class="feature-box">
      <div class="img-box"><img class="f-img" src="/images/image5.jpg" alt=""></div>
      <div class="feature-bc"><figcaption>業界専門の転職エージェントが最適な人材を紹介</figcaption></div>
      <p class="feature-txt">教育業界に精通した転職エージェントが貴社の採用要件に合う人材のみをご紹介します。<br>
          採用業務や面接での業務負荷を軽減致します。</p>
    </section>
  </div>
</div>

<div class="content2">
  <h2>採用決定時の成果報酬に<br>関して</h2>
  <p>Education Careerの求人掲載は全て無料です。</p>
  <p>正社員・契約社員（フルタイム）の場合は、入社に至った場合、成果報酬を頂戴しております。<br>
        ※別途弊社と人材紹介契約を締結させていただきます。</p>
  <p>アルバイトやインターン、業務委託の募集に関しては成果報酬も発生せず、完全に無料でご利用いただけます。</p>
  <p>フルタイムの掲載求人に応募があった場合、弊社から応募者に連絡を取り、要件に合う方の場合、貴社にご紹介致します。フルタイム以外の募集に関しては直接貴社に連絡が届くようになっております。</p>
</div>

<div class="content3">
  <h2>Education Careerの利用を<br>ご希望の企業・担当者様へ</h2>
  <div class="float">
  <div class="contact-btn">
    <p class="contact-txt-bottom">サービスの利用をお考えの企業・団体様は、以下問い合わせフォームからお問い合わせください。<br>
直接弊社スタッフからご案内（訪問・お電話）等で行わせていただきます。</p>
    <p class="c-btn"><a href="/contact" class="m-button m-button--primary">お問い合わせ</a></p>
  </div>
  </div>
</div>

@stop
