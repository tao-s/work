@extends('customer.mobile.layout')

@section('custom_js')
    {!! Html::script('js/request_sender.js') !!}
    {!! Html::script('js/nested_select.js') !!}
@stop

@section('content')

  <form action="{{ url('/mypage/profile') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="put">

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">職務経歴</h2>
    </div>

    @include('customer.mobile.include.message')

    <div class="formInput">
      <div class="formInput__label">
        <p>最終学歴</p>
        <select name="school_record_id">
          <option value="">最終学歴</option>
          @foreach ($school_records as $school_record)
            <option {{ $customer->profile->school_record_id == $school_record->id ? 'selected' : '' }} value="{{ $school_record->id }}">
              {{ $school_record->title }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="formInput__label">
        <p>学校名</p>
        <input name="school_name" type="text" id="inputSchoolName" value="{{ $customer->profile->school_name }}" placeholder="学校名" autofocus>
      </div>
      <div class="formInput__label">
        <p>卒業年度</p>
        <select name="graduate_year">
          <option value="">卒業年度</option>
          <?php $saved_year = $customer->profile->graduate_year ? $customer->profile->graduate_year : ''; ?>
          @for ($i = 1; $i<=50; $i++)
            <?php $year = \Carbon\Carbon::today()->subYear($i-7)->format('Y'); ?>
            <option {{ $year == $saved_year ? 'selected' : ''}} value="{{ $year }}">{{ $year }}年</option>
          @endfor
        </select>
      </div>
      <div class="formInput__label l-row">
        <p>職歴<p>
        @if(trim($customer->profile->job_record))
          <td><textarea rows="10" class="col-12" name="job_record" placeholder="">{{ $customer->profile->job_record }}</textarea></td>
        @else
          <td>
            <textarea rows="10" class="col-12" name="job_record" placeholder="">@include('customer.pc.include.job_record_template')</textarea>
          </td>
        @endif
      </div>
      <div class="formInput__label l-row">
        <p>活かせる経験・スキル</p>
        <textarea rows="6" class="col-12" name="skill">{{ $customer->profile->skill }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <p>保有資格</p>
        <textarea rows="6" class="col-12" id="" name="qualification">{{ $customer->profile->qualification }}</textarea>
      </div>
    </div>

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">自己紹介/キャリアサマリー</h2>
    </div>

    <div class="l-row l-box s">
      <textarea rows="10" name="introduction" id="inputIntroduction" class="col-12" placeholder="自己紹介/キャリアサマリー">{{ $customer->profile->introduction }}</textarea>
    </div>

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">取り組みたいこと/関心トピック</h2>
    </div>

    <div class="l-row l-box s">
      <textarea rows="10" name="future_plan" id="inputFuturePlan" class="col-12" placeholder="取り組みたいこと/関心トピック">{{ $customer->profile->future_plan }}</textarea>
    </div>

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">直近の勤務先企業名</h2>
    </div>

    <div class="l-row l-box s">
      <input type="text" name="company_name" id="inputCompanyName" placeholder="直近の勤務先企業名" value="{{ $customer->profile->company_name }}">
    </div>

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">直近の勤務先業種</h2>
    </div>

    <div class="l-row l-box s">
      <select name="industry_type[]" id="industryType1">
        <option value="">直近の勤務先業種1</option>
        @foreach($industry_types as $industry_type)
          <option {{ $customer->profile->hasIndustryType(0, $industry_type->id) ? 'selected' : '' }} value="{{$industry_type->id}}">
            {{$industry_type->name}}
          </option>
        @endforeach
      </select>
      <select name="industry_type[]" id="industryType2" style="margin-top: 10px;">
        <option value="">直近の勤務先業種2</option>
        @foreach($industry_types as $industry_type)
          <option {{ $customer->profile->hasIndustryType(1, $industry_type->id) ? 'selected' : '' }} value="{{$industry_type->id}}">
            {{$industry_type->name}}
          </option>
        @endforeach
      </select>
    </div>

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">直近の勤務先業種</h2>
    </div>

    <div class="l-row l-box s">
      @for ($i = 1; $i <= 3; $i++)
        <div id="inputOccupationCategoryBox{{$i}}">
          <select name="occupation_category_parent[]" id="inputOccupationCategoryParent{{$i}}" style="margin-bottom: 10px;">
            <option value="0">直近の経験職種{{$i}}</option>
            <option value="1" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 1)}}>
              営業職
            </option>
            <option value="2" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 2)}}>
              企画・管理系職種
            </option>
            <option value="3" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 3)}}>
              エンジニア・技術系職種
            </option>
            <option value="4" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 4)}}>
              クリエイティブ・クリエイター系職種
            </option>
            <option value="5" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 5)}}>
              講師・教員関連職種
            </option>
            <option value="6" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 6)}}>
              専門職種（コンサルタント、士業系等）
            </option>
            <option value="7" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 7)}}>
              事務系職種
            </option>
            <option value="8" {{ViewHelper::isSelectedCategory($customer->profile->occupationCategoryId($i - 1), 8)}}>
              その他
            </option>
          </select>
        </div>

        <select name="occupation_category[]" id="inputOccupationCategory{{$i}}"
                style="margin-bottom: 10px; max-width: 100%;{{ !$customer->profile->occupationCategoryId($i - 1) || $customer->profile->occupationCategoryId($i - 1) == 80 ? 'display:none;' : '' }}">
          <option value="0"></option>
          @foreach ($occupation_categories as $occupation_category)
            @if ($occupation_category->id == $customer->profile->occupationCategoryId($i - 1))
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
                  style="margin-bottom: 10px;{{ $customer->profile->occupationCategoryId($i - 1) != 80 ? 'display:none;' : '' }}">{{ $customer->profile->occupationCategoryFreeWord($i - 1) }}</textarea>
      @endfor
    </div>

    <div class="globalContents__titleBox l-row">
      <h2 class="col-9">希望勤務地</h2>
    </div>

    <div class="l-row l-box s">
      <select name="work_location" id="workLocation">
        <option value="0">希望勤務地</option>
        @foreach ($prefectures as $id => $prefecture)
          <option value="{{$id}}" {{$id == $customer->profile->work_location_id ? 'selected' : ''}}>{{$prefecture}}</option>
        @endforeach
      </select>
    </div>

    <div class="l-row l-box s">
      <div class="col-6">
        <a href="{{ url('/mypage') }}" class="m-button negative col-12">戻る</a>
      </div>
      <div class="col-6">
        <input type="submit" value="変更する" class="m-button default">
      </div>
    </div>
  </form>
@stop
