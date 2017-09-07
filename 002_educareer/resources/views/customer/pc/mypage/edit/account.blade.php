@extends('customer.pc.layout_mypage')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')
<div class="globalMain globalMain--hook l-group col-8">
  <div class="l-group">
    <div class="breadcrumbs">
      <a href="{{ url('/') }}">ホーム</a>
      <span>&gt;</span>
      <a href="{{ url('/mypage') }}">マイページ</a>
      <span>&gt;</span>
      <strong>アカウント設定</strong>
    </div>

    @include('customer.pc.include.message')

    <form action="{{ url('/mypage/account') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="_method" value="put">

      <div class="l-group">
        <table class="m-table">
          <tbody>
            <tr>
              <th><label for="inputUsername">名前</label></th>
              <td><input name="username" type="text" id="inputUsername" value="{{ $customer->profile->username }}" placeholder="名前" autofocus=""></td>
            </tr>

            <tr>
              <th><label for="inputEmail">メールアドレス</label></th>
              <td><input name="email" type="text" id="inputEmail" value="{{ $customer->email }}" placeholder="メールアドレス" autofocus=""></td>
            </tr>

            <tr>
              <th><label for="inputSex">性別</label></th>
              <td>
                <select name="sex" id="inputSex">
                  <option {{ $customer->profile->sex == 1 ? 'selected' : '' }} value="1">男性</option>
                  <option {{ $customer->profile->sex == 2 ? 'selected' : '' }} value="2">女性</option>
                </select>
              </td>
            </tr>

            <tr>
              <th><label for="inputBirthday">生年月日</label></th>
              <td>
                <?php $birthday = $user->profile->birthday; ?>
                <?php $ymd = $birthday ? ['year' => $birthday->year, 'month' => $birthday->month, 'day' => $birthday->day] : ['year' => null, 'month' => null, 'day' => null] ?>
                <select name="year">
                  <option value="">年</option>
                  @for ($i = 1; $i<=70; $i++)
                    <?php $year = \Carbon\Carbon::today()->subYear($i)->format('Y'); ?>
                    <option {{ $year == $ymd['year'] ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                  @endfor
                </select>
                <select name="month">
                  <option value="">月</option>
                  @for ($i = 1; $i <=12; $i++)
                  <option {{ $i == $ymd['month'] ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                <select name="day">
                  <option value="">日</option>
                  @for ($i = 1; $i <=31; $i++)
                    <option {{ $i == $ymd['day'] ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </td>
            </tr>

            <tr>
              <th><label for="inputPrefecture">都道府県</label></th>
              <td>
                <select name="prefecture" id="inputPrefecture">
                  <option value="">都道府県</option>
                  @foreach($prefectures as $key => $pf)
                    <option {{ $key == $user->profile->prefecture ? 'selected' : '' }} value="{{ $key }}">{{ $pf }}</option>
                  @endforeach
                </select>
              </td>
            </tr>

            <tr>
              <th><label for="inputMailMagazineFlag">メールマガジンの受信</label></th>
              <td>
                <select name="mail_magazine_flag" id="inputMailMagazineFlag">
                  <option {{ $customer->profile->mail_magazine_flag == true ? 'selected' : '' }} value="true">許可する</option>
                  <option {{ $customer->profile->mail_magazine_flag == false ? 'selected' : '' }} value="false">許可しない</option>
                </select>
              </td>
            </tr>

            <tr>
              <th><label for="inputScoutMailFlag">スカウトメールの受信</label></th>
              <td>
                <select name="scout_mail_flag" id="inputScoutMailFlag">
                  <option {{ $customer->profile->scout_mail_flag == true ? 'selected' : '' }} value="true">許可する</option>
                  <option {{ $customer->profile->scout_mail_flag == false ? 'selected' : '' }} value="false">許可しない</option>
                </select>
              </td>
            </tr>

            <tr>
              <th><label for="inputPhone">電話番号</label></th>
              <td>
                <input id="inputPhone" type="text" name="phone" value="{{ $customer->phone }}" placeholder="電話番号">
              </td>
            </tr>
          </tbody>
        </table>
        
        <div class="l-row l-row--xs">
          <div class="col-6"><a href="{{ url('/mypage') }}" class="m-button m-button--negative">戻る</a></div>
          <div class="col-6"><input type="submit" value="変更する" class="m-button m-button--default"></div>
        </div>
      </div>
    </form>

  </div>
</div>
@stop
