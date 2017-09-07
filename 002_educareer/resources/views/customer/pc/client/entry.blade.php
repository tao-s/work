@extends('customer.pc.layout')

@section('title', '企業アカウント登録｜教育業界特化の転職・求人サイト 教育業界に特化した求人・転職サービス「Education Career」の企業アカウント登録ページです。掲載をお考えの際は、こちらから登録をお願い致します。')

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

      <form action="{{ url('/recruiter') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="l-group">
          <table class="m-table">
            <tbody>
            <tr>
              <th><label for="inputCompanyName">会社名 <span class="m-label m-label--require">必須</span></label></th>
              <td><input id="inputCompanyName" type="text" name="company_name" value="{{ old('company_name') }}" placeholder="会社名"></td>
            </tr>

            <tr>
              <th><label for="inputCompanyId">会社ID <span
                      class="m-label m-label--require">必須</span></label></th>
              <td>
                <div class="l-group l-group--xs">
                  <input id="inputCompanyId" type="text" name="company_id" value="{{ old('company_id') }}"
                       placeholder="会社ID">

                  <p class="m-text m-text--sub m-text--small">※半角小文字英数字、_（アンダースコア）、または-（ハイフン）が利用可能 </p>
                </div>
              </td>
            </tr>

            <tr>
              <th><label for="inputCompanyUrl">コーポレートサイトURL <span
                      class="m-label m-label--require">必須</span></label></th>
              <td>
                <div class="l-group l-group--xs">
                  <input id="inputCompanyUrl" type="text" name="company_url" value="{{ old('company_url') }}"
                       placeholder="コーポレートサイトURL">

                  <p class="m-text m-text--sub m-text--small">（例）https://education-career.jp</p>
                </div>
              </td>
            </tr>

            <tr>
              <th><label for="inputRepName">担当者名 <span
                          class="m-label m-label--require">必須</span></label></th>
              <td>
                <div class="l-group l-group--xs">
                  <input id="inputRepName" type="text" name="name" value="{{ old('name') }}"
                         placeholder="担当者名">
                </div>
              </td>
            </tr>

            <tr>
              <th><label for="inputRepEmail">担当者メールアドレス <span
                      class="m-label m-label--require">必須</span></label></th>
              <td>
                <div class="l-group l-group--xs">
                  <input id="inputRepEmail" type="text" name="email" value="{{ old('email') }}"
                       placeholder="メールアドレス">
                </div>
              </td>
            </tr>

            <tr>
              <th><label for="inputRepPhone">担当者電話番号 <span
                      class="m-label m-label--require">必須</span></label></th>
              <td>
                <div class="l-group l-group--xs">
                  <input id="inputRepPhone" type="text" name="phone" value="{{ old('phone') }}"
                       placeholder="電話番号">
                </div>
              </td>
            </tr>

            </tbody>
          </table>

          <div class="l-row l-row--xs">
            <div class="col-12"><input type="submit" value="法人用アカウント申請" class="m-button m-button--default">
            </div>
          </div>
        </div>

      </form>

    </div>

  </div>
@stop
