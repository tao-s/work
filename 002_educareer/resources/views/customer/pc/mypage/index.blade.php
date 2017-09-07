@extends('customer.pc.layout_mypage')

@section('custom_css')
	{!! Html::style('css/slick.css') !!}
	{!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
	@include('customer.pc.include.sns')
@stop

@section('content')
  <div class="globalMain globalMain--hook l-group l-group--l col-8">
    <div>
      <div class="breadcrumbs">
        <a href="{{ url('/') }}">ホーム</a>
        <span>&gt;</span>
        <strong>マイページ</strong>
      </div>

      @include('customer.pc.include.message')

      <div class="l-group">

        <div class="m-editCard l-group l-group--xs" data-editable>
          <div class="m-editCard__header clearfix">
            <p class="m-heading m-heading--h2">職務経歴</p>
            <a href="{{ url('/mypage/profile') }}"><i class="icon--edit"></i>編集する</a>
          </div>

          <table class="m-table">
            <tbody>
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
            </tbody>
          </table>
          <div class="m-editCard l-group l-group--xs">
            <div class="m-editCard__header clearfix">
              <p class="m-heading m-heading--h2">自己紹介/キャリアサマリー</p>
              <a href="{{ url('/mypage/profile') }}"><i class="icon--edit"></i>編集する</a>
            </div>
            <div class="m-editCard__body">
              <p>{!! nl2br(e($user->profile->introduction)) !!}</p>
            </div>
          </div>

          <div class="m-editCard l-group l-group--xs">
            <div class="m-editCard__header clearfix">
              <p class="m-heading m-heading--h2">取り組みたいこと/関心トピック</p>
              <a href="{{ url('/mypage/profile') }}"><i class="icon--edit"></i>編集する</a>
            </div>
            <div class="m-editCard__body">
              <p>{!! nl2br(e($user->profile->future_plan)) !!}</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@stop
