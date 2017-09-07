@extends('customer.mobile.layout')

@section('custom_js')
  {!! Html::script('js/nested_select.js') !!}
@stop

@section('content')
  <div class="globalContents__titleBox">
    <h2>会員登録</h2>
  </div>

  @include('customer.mobile.include.message')

  <div class="l-box s">
    <p>サービス登録前に<a href="{{ url('/terms') }}" class="m-text m-text--primary">利用規約</a>をお読みいただき、同意された上で登録をお願い致します。</p>
  </div>

  <form action="{{ url('/register/'.$customer->id.'/profile') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="formInput">
      <div class="formInput__label">
        <label for="inputUserName">名前 <span class="m-label m-label--require">必須</span></label>
        <input id="inputUserName" type="text" name="username" value="{{ $data->username }}" placeholder="名前">
      </div>
      <div class="formInput__label">
        <label for="inputSex">性別 <span class="m-label m-label--require">必須</span></label>
        <div>
          <select name="sex" id="inputSex">
            <option {{ $data->sex == 1 ? 'selected' : '' }} value="1">男性</option>
            <option {{ $data->sex == 2 ? 'selected' : '' }} value="2">女性</option>
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <p>生年月日 <span class="m-label m-label--require">必須</span></p>
        <div>
          <select name="year">
            <option value="">年</option>
            @for ($i = 1; $i<=70; $i++)
              <?php $year = \Carbon\Carbon::today()->subYear($i)->format('Y'); ?>
              <option {{ $data->year == $year ? 'selected' : ''}} value="{{ $year }}">{{ $year }}</option>
            @endfor
          </select>
          <select name="month">
            <option value="">月</option>
            @for ($i = 1; $i <=12; $i++)
              <option {{ $data->month == $i ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <select name="day">
            <option value="">日</option>
            @for ($i = 1; $i <=31; $i++)
              <option {{ $data->day == $i ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputPrefecture" >都道府県 <span class="m-label m-label--require">必須</span></label>
        <div>
          <select name="prefecture" id="inputPrefecture">
            <option value="">都道府県</option>
            @foreach($prefectures as $key => $pf)
              <option {{ $data->prefecture == $key ? 'selected' : ''}} value="{{ $key }}">{{ $pf }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputPhone">電話番号 <span class="m-label m-label--require">必須</span></label>
        <div>
          <input id="inputPhone" type="text" name="phone" value="{{ $data->phone }}" placeholder="電話番号">
        </div>
      </div>
      <div class="formInput__email">
        <label for="inputMailMagazineFlag">メールマガジンの受信</label>
        <div>
          <select name="mail_magazine_flag" id="inputMailMagazineFlag">
            {{-- パスワードが入っている場合は通常の会員登録動線 --}}
            <option {{ $data->mail_magazine_flag || !is_null($data->password) ? 'selected' : '' }} value="true">許可する</option>
            <option {{ !$data->mail_magazine_flag && is_null($data->password) ? 'selected' : '' }} value="false">許可しない</option>
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputScoutMailFlag">スカウトメールの受信</label>
        <div>
          <select name="scout_mail_flag" id="inputScoutMailFlag">
            {{-- パスワードが入っている場合は通常の会員登録動線 --}}
            <option {{ $data->scout_mail_flag || !is_null($data->password) ? 'selected' : '' }} value="true">許可する</option>
            <option {{ !$data->scout_mail_flag && is_null($data->password) ? 'selected' : '' }} value="false">許可しない</option>
          </select>
        </div>
      </div>
      @if ($should_input_password)
      <div class="formInput__pass">
        <label for="inputPassword">新しいパスワード <span class="m-label m-label--require">必須</span></label>
        <input name="password" type="password" id="inputPassword" placeholder="新しいパスワード">
        <p class="m-text m-text--sub m-text--small">※半角英数字8文字以上</p>
      </div>
      <div class="formInput__pass">
        <label for="inputPasswordConfirmation">新しいパスワード（確認用） <span class="m-label m-label--require">必須</span></label>
        <input name="password_confirmation" type="password" id="inputPasswordConfirmation" placeholder="新しいパスワード（確認用）">
      </div>
      @endif
      <div class="formInput__label">
        <p>最終学歴</p>
        <div>
          <select name="school_record_id">
            <option value="">最終学歴</option>
            @foreach ($school_records as $school_record)
              <option {{ $data->school_record_id == $school_record->id ? 'selected' : '' }} value="{{ $school_record->id }}">
                {{ $school_record->title }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputSchoolName">学校名</label>
        <div>
          <input name="school_name" type="text" id="inputSchoolName" value="{{ $data->school_name }}" placeholder="学校名">
        </div>
      </div>
      <div class="formInput__label">
        <label for="inputGraduateYear">卒業年度</label>
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
        <label for="inputJobRecord">職歴</label>
        <textarea rows="6" class="col-12" id="inputJobRecord" name="job_record" placeholder="職歴">{{ $data->job_record }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputSkill">活かせる経験・スキル</label>
        <textarea rows="6" class="col-12" id="inputSkill" name="skill" placeholder="活かせる経験・スキル">{{ $data->skill }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputQualification">保有資格</label>
        <textarea rows="6" class="col-12" id="inputQualification" name="qualification" placeholder="保有資格">{{ $data->qualification }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputIntroduction">自己紹介/キャリアサマリー</label>
        <textarea rows="6" class="col-12" id="inputIntroduction" name="introduction" placeholder="自己紹介/キャリアサマリー">{{ $data->introduction }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputFuturePlan">取り組みたいこと/関心トピック</label>
        <textarea rows="6" class="col-12" id="inputFuturePlan" name="future_plan" placeholder="取り組みたいこと/関心トピック">{{ $data->future_plan }}</textarea>
      </div>
      <div class="formInput__label l-row">
        <label for="inputCompanyName">直近の勤務先企業名</label>
        <input type="text" name="company_name" id="inputCompanyName" placeholder="直近の勤務先企業名">{{ $data->company_name }}</input>
      </div>
      <div class="formInput__label l-row">
        <label>直近の勤務先業種
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
        </label>
      </div>
      <div class="formInput__label l-row">
        <label>
          直近の経験職種
          @for ($i = 1; $i <= 3; $i++)
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
            <select name="occupation_category[]" id="inputOccupationCategory{{$i}}"
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
                      style="{{ $data->{'occupation_category' . $i} != 80 ? 'display:none;' : '' }}">{{ $data->{'occupation_category_free_word' . $i} }}</textarea>
          @endfor
        </label>
      </div>
      <div class="formInput__label l-row">
        <label for="workLocation">希望勤務地</label>
        <div>
          <select name="work_location" id="workLocation">
            <option value="0">希望勤務地</option>
            @foreach ($prefectures as $id => $prefecture)
              <option value="{{$id}}" {{$id == $data->work_location ? 'selected' : ''}}>{{$prefecture}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <input type="submit" value="完了" class="m-button default">
    </div>
  </form>

@stop

