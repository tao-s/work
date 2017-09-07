@extends('customer.mobile.layout')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
  {!! Html::script('js/form_confirmation.js') !!}
  {!! Html::script('js/nested_select.js') !!}
@stop

@section('content')
 <div id="content-wrap">
<div class="header mb70">
<div class="header-img">
<div class="header-btn">
<a href="#form01" class="h-btn h-btn-more">無料で相談する</a>
</div>
</div>
</div>
</div>

<div id ="main-wrap">
<div class="main-box1"><!-- st main-box1 -->
<div class="box1-twrap">
<div class="box-txt1"><p class="hide_text">教育領域の大手企業や、優良スタートアップ、ベンチャーなど多数の求人がございます。弊社限定でご紹介出来る案件も数多くございます。</p></div>
<div class="box-txt2"><p class="hide_text">営業やエンジニア、デザイナー、企画・マーケティング、講師、経営幹部など、教育分野であなたのキャリアにプラスになる求人が揃っています。ご希望のキャリアにあった求人をご提案します。</p></div>
<div class="box-txt3"><p class="hide_text">コンサルタントにご相談いただいた方限定の非公開求人をご紹介可能です。コンフィデンシャルな募集等も面談時にご紹介させていただきます。</p></div>
</div>
</div><!-- end main-box1 -->

<div class="main-box2"><!-- st main-box2 -->
<p class="hide_text">
Education Careerの
専門コンサルタントに相談するメリット
メリット01
あなたの希望にマッチした求人をご紹介
ご要望、今後のキャリアプランを伺い、最適なお仕事をご紹介します。

メリット02
教育領域専門のコンサルタントに相談可能
教育領域専門のコンサルタントが面談を行いますので、詳細な情報、業界の動向を知ることが可能です。
※弊社ではEdTech Mediaという教育分野のニュースメディアも運営しており、業界の最新の情報を有しています。

メリット03
無料で相談、書類作成サポート、面接対策も行います
相談から入社されるまで全て無料でサポートいたします。
履歴書や職務経歴書の書き方、面接の対策など、良いキャリアのサポートを行います。
</p>
</div><!-- end main-box2 -->

<div class="main-box3-wrap">
<div class="main-box3"><!-- st main-box3 -->
<p class="hide_text">
すでに！たくさんの方々が教育分野への転職に成功しています！
法人営業から文教市場への営業へ
27歳　女性
学生時代から教育分野に関心がありましたが、最初の就職では人材関連の企業へ就職。そこで３年ほど法人営業の経験を積みました。
営業経験を生かして教育分野での良い求人がないかを相談しました。いくつか魅力的な企業を紹介いただき、最終的にはオンラインの教育サービスを学校へご提案する企業に入社することができました。

ネット広告代理店からスタートアップの幹部候補へ転身
26歳　男性
新卒で入社したネット広告代理店ではSEMなどのオンラインマーケティング全般を経験しました。そこで培ったスキルを活かし、EdTech（教育×テクノロジー）分野の企業へ転身したいと考えていました。
その要望を相談したところ、他のサービスではご紹介頂けなかったようなスタートアップをご紹介いただき、入社することが決まりました。

ソーシャルゲーム開発からオンライン学習サービスのエンジニアへ
29歳　男性
前職はソーシャルゲームの開発を行っていました。技術的には刺激もありユーザー数も多く面白かったのですが、ユーザーの人生により強いイン
パクトを与えたいと思って、教育分野の企業への転身を決めました。
要望が多く色々と注文をつけてしまったのですが笑、大手企業や
スタートアップなど多くの企業をご紹介いただき、結果中高生に
オンライン学習サービスを提供する企業への入社を決めることが出来ました。
選考の情報以外にも、サービスの特徴や業界の流れなど、色々と率直にお話しいただき、非常に勉強になりました。
</p>
<div class="entry-btn"><a href="#form01" class="btn btn-more">無料で相談する</a></div>
</div><!-- end main-box3 -->
</div>


<div class="main-box4">
<p class="hide_text">
STEP01 当サイトで無料会員登録
STEP02 コンサルタントによるカウンセリング面談
STEP03 個別企業様のご紹介
STEP04 書類選考/面接
STEP05 内定・入社
</p>
<div class="entry-btn"><a href="#form01" class="btn btn-more">無料で相談する</a></div>
</div>
 
  <div class="globalContents__titleBox" id="form01">
    <h2>エージェントに無料相談</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/agent') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="formInput">
      <div class="formInput__label">
        <label for="inputUserName">お名前 <span class="m-label m-label--require">必須</span></label><br>
        <input id="inputUserName" type="text" name="username" value="{{ $data->username }}" placeholder="姓名を入力">
      </div>
      <div class="formInput__label">
        <label for="inputSex">性別 <span class="m-label m-label--require">必須</span></label><br>
        <div>
          <select name="sex" id="inputSex">
            <option {{ $data->sex == 1 ? 'selected' : '' }} value="1">男性</option>
            <option {{ $data->sex == 2 ? 'selected' : '' }} value="2">女性</option>
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputBirthday" >生年月日 <span class="m-label m-label--require">必須</span></label><br>
        <div>
          <select name="year">
            <option value="">年</option>
            @for ($i = 1; $i<=70; $i++)
              <?php $year = \Carbon\Carbon::today()->subYear($i)->format('Y'); ?>
              <option {{ $data->year == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
            @endfor
          </select>
          <select name="month">
            <option value="">月</option>
            @for ($i = 1; $i <=12; $i++)
              <option {{ $data->month == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <select name="day">
            <option value="">日</option>
            @for ($i = 1; $i <=31; $i++)
              <option {{ $data->day == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputPrefecture" >お住まいの都道府県 <span class="m-label m-label--require">必須</span></label><br>
        <div>
          <select name="prefecture" id="inputPrefecture">
            <option value="">都道府県を選択</option>
            @foreach($prefectures as $key => $pf)
              <option {{ $data->prefecture == $key ? 'selected' : '' }} value="{{ $key }}">{{ $pf }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="formInput__email">
        <label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label><br>
        <div>
          <input type="text" id="inputEmail" name="email" value="{{ $data->email }}" placeholder="メールアドレス">
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputPhone">電話番号 <span class="m-label m-label--require">必須</span></label><br>
        <div>
          <input type="text" id="inputPhone" name="phone" value="{{ $data->phone }}" placeholder="電話番号">
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputSchoolRecordId">最終学歴</label><br>
        <div>
          <select id="inputSchoolRecordId" name="school_record_id">
            <option value="">最終学歴を選択</option>
            @foreach ($school_records as $school_record)
              <option {{ $data->school_record_id == $school_record->id ? 'selected' : '' }} value="{{ $school_record->id }}">
                {{ $school_record->title }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputSchoolName">学校名</label><br>
        <div>
          <input name="school_name" type="text" id="inputSchoolName" value="{{ $data->school_name }}" placeholder="学校名">
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputGraduateYear">卒業年度</label><br>
        <div>
          <select name="graduate_year" id="inputGraduateYear">
            <option value="">卒業年度</option>
            @for ($i = 1; $i<=50; $i++)
              <?php $year = \Carbon\Carbon::today()->subYear($i-7)->format('Y'); ?>
              <option {{ $data->graduate_year == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}年</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="formInput__label l-row">
        <label for="inputJobRecord">経歴概要</label><br>
        <textarea rows="6" class="col-12" id="inputJobRecord" name="job_record" placeholder="経歴の概要をご記入下さい。">{{ $data->job_record }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputInquiry">転職に関するご希望・相談内容・転職理由など</label><br>
        <textarea rows="6" class="col-12" id="inputInquiry" name="inquiry" placeholder="転職への希望・相談したい内容・転職理由などをご記入下さい。">{{ $data->inquiry }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputCompanyName">直近の勤務先企業名</label><br>
        <input type="text" name="company_name" id="inputCompanyName" placeholder="企業名（団体名）を入力">{{ $data->company_name }}</input>
      </div>
      <!--<div class="formInput__label l-row">
        <label>直近の勤務先業種</label><br>
          <select name="industry_type[]" id="industryType1">
            <option value="">直近の勤務先業種1</option>
            @foreach($industry_types as $industry_type)
              <option {{ $data->industry_type1 == $industry_type->id ? 'selected' : '' }} value="{{$industry_type->id}}">
                {{$industry_type->name}}
              </option>
            @endforeach
          </select>
          <select name="industry_type[]" id="industryType2" style="margin-top: 10px;">
            <option value="">直近の勤務先業種2</option>
            @foreach($industry_types as $industry_type)
              <option {{ $data->industry_type2 == $industry_type->id ? 'selected' : '' }} value="{{$industry_type->id}}">
                {{$industry_type->name}}
              </option>
            @endforeach
          </select>
      </div>-->
      <div class="formInput__label l-row">
        <label>直近の経験職種</label><br>
          @for ($i = 1; $i <= 1; $i++)
            <div id="inputOccupationCategoryBox{{$i}}">
              <select name="occupation_category_parent[]" id="inputOccupationCategoryParent{{$i}}" style="margin-bottom: 10px;">
                <option value="0">直近の経験職種{{$i}}</option>
                <option value="1" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 1)}}>
                  営業職
                </option>
                <option value="2" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 2)}}>
                  企画・管理系職種
                </option>
                <option value="3" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 3)}}>
                  エンジニア・技術系職種
                </option>
                <option value="4" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 4)}}>
                  クリエイティブ・クリエイター系職種
                </option>
                <option value="5" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 5)}}>
                  講師・教員関連職種
                </option>
                <option value="6" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 6)}}>
                  専門職種（コンサルタント、士業系等）
                </option>
                <option value="7" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 7)}}>
                  事務系職種
                </option>
                <option value="8" {{ViewHelper::isSelectedCategory($data->{'occupation_category' . $i}, 8)}}>
                  その他
                </option>
              </select>
            </div>
            <!--<select name="occupation_category[]" id="inputOccupationCategory{{$i}}"
                    style="margin-bottom: 10px; max-width: 100%; {{ !$data->{'occupation_category' . $i} || $data->{'occupation_category' . $i} == 80 ? 'display:none;' : '' }}">
              <option value="0"></option>
              @foreach ($occupation_categories as $occupation_category)
                @if ($occupation_category->id == $data->{'occupation_category' . $i})
                  <option value="{{$occupation_category->id}}" selected>
                    {{$occupation_category->name}}
                  </option>
                @else
                  <option value="{{$occupation_category->id}}" hidden>
                    {{$occupation_category->name}}
                  </option>
                @endif
              @endforeach
            </select>
            <textarea name="occupation_category_free_word[]" id="inputOccupationCategoryFreeWord{{$i}}"
                      placeholder="フリーワード"
                      style="{{ $data->{'occupation_category' . $i} != 80 ? 'display:none;' : '' }}">{{ $data->{'occupation_category_free_word' . $i} }}</textarea>-->
          @endfor
      </div>
      <div class="formInput__label l-row">
        <label for="workLocation">希望勤務地</label><br>
        <div>
          <select name="work_location" id="workLocation">
            <option value="0">希望勤務地</option>
            @foreach ($prefectures as $id => $prefecture)
              <option value="{{$id}}" {{$id == $data->work_location ? 'selected' : ''}}>{{$prefecture}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div>
        <p class="m-text m-text--rtc">※ Education Careerにまだ会員登録していない方はこのフォームの情報で会員登録をさせていただきます。<br>
          エージェントに相談する前に<a href="https://local.education-career.jp/terms" class="m-text m-text--primary" target="_blank">利用規約</a>をお読みいただき、同意された上で相談内容の送信をお願い致します。
        </p>
      </div>
      <input type="submit" value="エージェントに無料相談" class="f-btn f-btn-more2" data-confirm="この内容で本当に送信してもよろしいですか？">
    </div>
  </form>
</div>
@stop

