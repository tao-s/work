@extends('customer.mobile.layout')

@section('custom_js')
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>アカウント設定</h2>
  </div>

  @include('customer.mobile.include.message')

  <form action="{{ url('/mypage/account') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="put">

    <div class="formInput">
      <div class="m-text m-text--sub">
        <label for="inputUsername">名前</label>
        <input name="username" type="text" id="inputUsername" value="{{ $customer->profile->username }}" placeholder="名前" autofocus="">
      </div>
      <div class="m-text m-text--sub">
        <label for="inputEmail">メールアドレス</label>
        <input name="email" type="text" id="inputEmail" value="{{ $customer->email }}" placeholder="メールアドレス" autofocus="">
      </div>
      <div class="m-text m-text--sub">
        <label for="inputSex">性別</label>
        <select name="sex" id="inputSex">
          <option {{ $customer->profile->sex == 1 ? 'selected' : '' }} value="1">男性</option>
          <option {{ $customer->profile->sex == 2 ? 'selected' : '' }} value="2">女性</option>
        </select>
      </div>
      <div class="formInput__label">
        <label for="inputBirthday" >生年月日 <span class="m-label m-label--require">必須</span></label>
        <div>
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
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputPrefecture" >お住まいの都道府県 <span class="m-label m-label--require">必須</span></label>
        <div>
          <select name="prefecture" id="inputPrefecture">
            <option value="">お住まいの都道府県</option>
            @foreach($prefectures as $key => $pf)
              <option {{ $user->profile->prefecture == $key ? 'selected' : '' }} value="{{ $key }}">{{ $pf }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="m-text m-text--sub">
        <label for="inputPhone">電話番号</label>
        <input name="phone" type="text" id="inputPhone" value="{{ $customer->phone }}" placeholder="電話番号">
      </div>

      <div class="l-row l-box s">
        <div class="col-6">
          <a href="{{ url('/mypage') }}" class="m-button negative col-12">戻る</a>
        </div>
        <div class="col-6">
          <input type="submit" value="変更する" class="m-button default">
        </div>
      </div>
    </div>
  </form>

@stop
