@extends('customer.pc.layout')

@section('title', 'お問い合わせ | 教育業界に特化した就職・転職の求人サービス【Education Career】')
@section('description', 'EducationCareerへのお問い合わせはこちらから。EducationCareerは教育業界に就職・転職したい方、関心のあるすべての方に向けた求人情報サービスです。正社員や業務委託、パートやアルバイト、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

  <div class="globalViewport l-row">
    <div class="globalMain globalMain--narrow">

      @include('customer.pc.include.message')

      <form action="{{ url('/contact') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div style="margin-bottom: 20px">
          <strong class="m-heading m-heading--h2">お問い合わせ</strong>
        </div>

        <div class="l-group">
          <table class="m-table">
            <tbody>
            <tr>
              <th><label for="inputName">お名前 <span class="m-label m-label--require">必須</span></label></th>
              <td><input id="inputName" type="text" name="name" value="{{ old('name') }}" placeholder="お名前"></td>
            </tr>
            <tr>
              <th><label for="inputCompany">貴社名/団体名 <span class="m-label m-label--require">必須</span></label></th>
              <td><input id="inputCompany" type="text" name="company" value="{{ old('company') }}" placeholder="貴社名/団体名"></td>
            </tr>
            <tr>
              <th><label for="inputTel">お電話番号 <span class="m-label m-label--require">必須</span></label></th>
              <td><input id="inputTel" type="text" name="tel" value="{{ old('tel') }}" placeholder="お電話番号"></td>
            </tr>
            <tr>
              <th><label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label></th>
              <td><input id="inputEmail" type="text" name="email" value="{{ old('email') }}" placeholder="メールアドレス"></td>
            </tr>
            <tr>
              <th><label for="inputUrl">貴社サイトURL <span class="m-label m-label--optional">任意</span></label></th>
              <td><input id="inputUrl" type="text" name="url" value="{{ old('url') }}" placeholder="貴社サイトURL"></td>
            </tr>
            <tr>
                <th><label for="inputSubject">件名 <span class="m-label m-label--require">必須</span></label></th>
                <td><input id="inputSubject" type="text" name="subject" value="{{ old('subject') }}" placeholder="件名"></td>
            </tr>

            <tr>
              <th><label for="inputBody">お問い合わせ内容 <span
                      class="m-label m-label--require">必須</span></label></th>
              <td>
                <div class="l-group l-group--xs">
                  <textarea id="inputBody" name="body" style="height: 300px; resize:vertical" placeholder="中途採用を行っているので、詳細の案内をしてほしい　等"></textarea>
                </div>
              </td>
            </tr>

            </tbody>
          </table>

          <div class="l-row l-row--xs">
            <div class="col-12"><input type="submit" value="お問い合わせ送信" class="m-button m-button--default">
            </div>
          </div>
        </div>

      </form>

    </div>

  </div>
@stop
