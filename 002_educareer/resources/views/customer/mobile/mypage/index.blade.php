@extends('customer.mobile.layout')

@section('content')

  <div class="profile l-row">
    <!--
    <div class="col-4 profile__author">
      <img src="/mobile/images/author.jpg" alt="">
    </div>
    -->
    @include('customer.mobile.include.message')

    <div class="col-8 l-group l-group--xs l-box s">
      <div class="profile__name">{{ $user->profile->username }}</div>
      <div class="profile__info">
        <div>
          性別：<span>{{ $user->profile->getGender() }}</span>
        </div>
        @if ( !is_null($user->profile->birthday) )
        <div>
          生年月日：<span>{{ $user->profile->birthday->format('Y年m月d日') }}</span>
        </div>
        <div>
          年齢：<span>{{ $user->profile->birthday->age }}歳</span>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="globalContents__titleBox l-row">
    <h2 class="col-9">職務経歴</h2>
    <div class="col-3 edit"><a href="{{ url('/mypage/profile') }}">編集する</a></div>
  </div>

  <div class="l-box s">
    <table class="m-table">
      <tr>
        <th>最終学歴</th>
        <td>{!! nl2br(e($user->profile->school_record ? $user->profile->school_record->title : '')) !!}</td>
      </tr>

      <tr>
        <th>学校名</th>
        <td>{!! nl2br(e($user->profile->school_name)) !!}</td>
      </tr>

      <tr>
        <th>卒業年度</th>
        <td>{!! nl2br(e($user->profile->graduate_year ? $user->profile->graduate_year . '年' : '')) !!}</td>
      </tr>

      <tr>
        <th>職歴</th>
        <td>{!! nl2br(e($user->profile->job_record)) !!}</td>
      </tr>

      <tr>
        <th>活かせる経験・スキル</th>
        <td>{!! nl2br(e($user->profile->skill)) !!}</td>
      </tr>

      <tr>
        <th>保有資格</th>
        <td>{!! nl2br(e($user->profile->qualification)) !!}</td>
      </tr>

      <tr>
        <th>直近の勤務先企業名</th>
        <td>{{ $user->profile->company_name  }}</td>
      </tr>

      <tr>
        <th>直近の勤務先業種</th>
        <td>
          @foreach ($user->profile->industry_types as $industry_type)
            {{ $industry_type->name }}<br>
          @endforeach
        </td>
      </tr>

      <tr>
        <th>直近の経験職種</th>
        <td>
          @foreach ($user->profile->occupationCategoryNames() as $occupationCategoryName)
            {{ $occupationCategoryName }}<br>
          @endforeach
        </td>
      </tr>

      <tr>
        <th>希望勤務地</th>
        <td>{{ $user->profile->workLocationName() }}</td>
      </tr>
    </table>
  </div>

  <div class="globalContents__titleBox l-row">
    <h2 class="col-9">自己紹介/キャリアサマリー</h2>
    <div class="col-3 edit"><a href="{{ url('/mypage/profile') }}">編集する</a></div>
  </div>

  <div class="l-box s l-group">
    <p>{!! nl2br(e($user->profile->introduction)) !!}</p>
  </div>

  <div class="globalContents__titleBox l-row">
    <h2 class="col-9">取り組みたいこと/関心トピック</h2>
    <div class="col-3 edit"><a href="{{ url('/mypage/profile') }}">編集する</a></div>
  </div>

  <div class="l-box s l-group">
    <p>{!! nl2br(e($user->profile->future_plan)) !!}</p>
  </div>


@stop
