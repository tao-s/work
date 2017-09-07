@extends('customer.pc.layout_mypage')

@section('custom_css')
    {!! Html::style('css/slick.css') !!}
    {!! Html::style('css/slick-theme.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/request_sender.js') !!}
    {!! Html::script('js/nested_select.js') !!}
@stop

@section('content')
<div class="globalMain globalMain--hook l-group l-group--l col-8">
  <div class="l-group">
    <div class="breadcrumbs">
      <a href="{{ url('/') }}">ホーム</a>
      <span>&gt;</span>
      <a href="{{ url('/mypage') }}">マイページ</a>
      <span>&gt;</span>
      <strong>プロフィール設定</strong>
    </div>

    @include('customer.pc.include.message')

    <form action="{{ url('/mypage/profile') }}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="_method" value="put">

      <div class="l-group">

        <div class="l-group l-group--xs">
          <p class="m-heading m-heading--h2">職務経歴</p>
          <table class="m-table">
            <tbody>
              <tr>
                <th>最終学歴</th>
                <td>
                  <select name="school_record_id">
                    <option value="">最終学歴</option>
                    @foreach ($school_records as $school_record)
                      <option {{ $customer->profile->school_record_id == $school_record->id ? 'selected' : '' }} value="{{ $school_record->id }}">
                        {{ $school_record->title }}
                      </option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>学校名</th>
                <td><input name="school_name" type="text" id="inputSchoolName" value="{{ $customer->profile->school_name }}" placeholder="学校名" autofocus></td>
              </tr>
              <tr>
                <th>卒業年度</th>
                <td>
                  <select name="graduate_year">
                    <option value="">卒業年度</option>
                    <?php $saved_year = $customer->profile->graduate_year ? $customer->profile->graduate_year : ''; ?>
                    @for ($i = 1; $i<=50; $i++)
                      <?php $year = \Carbon\Carbon::today()->subYear($i-7)->format('Y'); ?>
                      <option {{ $year == $saved_year ? 'selected' : ''}} value="{{ $year }}">{{ $year }}年</option>
                    @endfor
                  </select>
                </td>
              </tr>
              <tr>
                <th>職歴</th>
                @if(trim($customer->profile->job_record))
                  <td><textarea name="job_record" placeholder="">{{ $customer->profile->job_record }}</textarea></td>
                @else
                  <td>
                    <textarea name="job_record" placeholder="">@include('customer.pc.include.job_record_template')</textarea>
                  </td>
                @endif
              </tr>
              <tr>
                <th>活かせる経験・スキル</th>
                <td><textarea name="skill">{{ $customer->profile->skill }}</textarea></td>
              </tr>
              <tr>
                <th>保有資格</th>
                <td><textarea id="" name="qualification">{{ $customer->profile->qualification }}</textarea></td>
              </tr>
              <tr>
                <th><label for="inputCompanyName">直近の勤務先企業名</label></th>
                <td>
                  <div class="l-group l-group--xs">
                    <textarea name="company_name" id="inputCompanyName" placeholder="直近の勤務先企業名">{{ $customer->profile->company_name }}</textarea>
                  </div>
                </td>
              </tr>

              <tr>
                <th><label for="inputIndustryType">直近の勤務先業種</label></th>
                <td>
                  <div class="l-group l-group--xs">
                    <select name="industry_type[]" id="industryType1">
                      <option value="">直近の勤務先業種1</option>
                      @foreach($industry_types as $industry_type)
                        <option {{ $customer->profile->hasIndustryType(0, $industry_type->id) ? 'selected' : '' }} value="{{$industry_type->id}}">
                          {{$industry_type->name}}
                        </option>
                      @endforeach
                    </select>
                    <select name="industry_type[]" id="industryType2">
                      <option value="">直近の勤務先業種2</option>
                      @foreach($industry_types as $industry_type)
                        <option {{ $customer->profile->hasIndustryType(1, $industry_type->id) ? 'selected' : '' }} value="{{$industry_type->id}}">
                          {{$industry_type->name}}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </td>
              </tr>

              @for ($i = 1; $i <= 3; $i++)
                <tr>
                  @if ($i === 1)
                    <th rowspan="3">直近の経験職種</th>
                  @endif
                  <td>
                    <div class="l-group l-group--xs">
                      <div id="inputOccupationCategoryBox{{$i}}">
                        <select name="occupation_category_parent[]" id="inputOccupationCategoryParent{{$i}}">
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
                              style="{{ !$customer->profile->occupationCategoryId($i - 1) || $customer->profile->occupationCategoryId($i - 1) == 80 ? 'display:none;' : '' }}">
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
                                style="{{ $customer->profile->occupationCategoryId($i - 1) != 80 ? 'display:none;' : '' }}">{{ $customer->profile->occupationCategoryFreeWord($i - 1) }}</textarea>
                    </div>
                  </td>
                </tr>
              @endfor

              <tr>
                <th><label for="workLocation">希望勤務地</label></th>
                <td>
                  <div class="l-group l-group--xs">
                    <select name="work_location" id="workLocation">
                      <option value="0">希望勤務地</option>
                      @foreach ($prefectures as $id => $prefecture)
                        <option value="{{$id}}" {{$id == $customer->profile->work_location_id ? 'selected' : ''}}>{{$prefecture}}</option>
                      @endforeach
                    </select>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="m-editCard l-group l-group--xs">
            <div class="m-editCard__header clearfix">
              <p class="m-heading m-heading--h2"><label for="inputIntroduction">自己紹介/キャリアサマリー</label></p>
            </div>
            <div class="m-editCard__body">
              <textarea name="introduction" id="inputIntroduction" placeholder="自己紹介/キャリアサマリー">{{ $customer->profile->introduction }} </textarea>
            </div>
          </div>

          <div class="m-editCard l-group l-group--xs">
            <div class="m-editCard__header clearfix">
              <p class="m-heading m-heading--h2"><label for="inputFuturePlan">取り組みたいこと/関心トピック</label></p>
            </div>
            <div class="m-editCard__body">
              <textarea name="future_plan" id="inputFuturePlan" placeholder="取り組みたいこと/関心トピック">{{ $customer->profile->future_plan }}</textarea>
            </div>
          </div>

        </div>

        <div class="l-row l-row--xs">
          <div class="col-6"><a href="{{ url('/mypage') }}" class="m-button m-button--negative">戻る</a></div>
          <div class="col-6"><input type="submit" value="変更する" class="m-button m-button--default"></div>
        </div>
      </div>
    </form>

  </div>
</div>
@stop
