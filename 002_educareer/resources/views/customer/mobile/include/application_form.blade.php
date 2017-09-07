<div class="formInput">
  <div class="formInput__label">
    <label for="inputUserName">お名前 <span class="m-label m-label--require">必須</span></label><br>
    <input id="inputUserName" type="text" name="username" value="{{ $data->username }}" placeholder="姓名を入力">
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
    <label for="inputBirthday" >生年月日 <span class="m-label m-label--require">必須</span></label>
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
    <label for="inputPrefecture" >お住まいの都道府県 <span class="m-label m-label--require">必須</span></label>
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
    <label for="inputEmail">メールアドレス <span class="m-label m-label--require">必須</span></label>
    <div>
      <input type="text" id="inputEmail" name="email" value="{{ $data->email }}" placeholder="メールアドレス">
    </div>
  </div>
  <div class="formInput__label">
    <label for="inputPhone">電話番号 <span class="m-label m-label--require">必須</span></label>
    <div>
      <input type="text" id="inputPhone" name="phone" value="{{ $data->phone }}" placeholder="電話番号">
    </div>
  </div>
  <div class="formInput__label">
    <label for="inputSchoolRecordId">最終学歴</label>
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
    <label for="inputJobRecord">経歴概要</label>
    <textarea rows="6" class="col-12" id="inputJobRecord" name="job_record" placeholder="経歴の概要をご記入下さい。">{{ $data->job_record }}</textarea>
  </div>
  <div class="formInput__label l-row">
    <label for="inputInquiry">転職に関するご希望・相談内容・転職理由など</label>
    <textarea rows="6" class="col-12" id="inputInquiry" name="inquiry" placeholder="転職への希望・相談したい内容・転職理由などをご記入下さい。">{{ $data->inquiry }}</textarea>
  </div>
  <div class="formInput__label l-row">
    <label for="inputCompanyName">直近の勤務先企業名</label>
    <input type="text" name="company_name" id="inputCompanyName" placeholder="企業名（団体名）を入力">{{ $data->company_name }}</input>
  </div>
  <!--<div class="formInput__label l-row">
    <label>直近の勤務先業種<br>
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
  </div>-->
  <div class="formInput__label l-row">
    <label>
      直近の経験職種
      @for ($i = 1; $i <= 1; $i++)
        <div id="inputOccupationCategoryBox{{$i}}">
          <select name="occupation_category_parent[]" id="inputOccupationCategoryParent{{$i}}" style="margin-bottom: 10px;">
            <option value="0">職種をお選び下さい{{$i}}</option>
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
    </label>
  </div>
  <div class="formInput__label l-row">
    <label for="workLocation">希望勤務地</label>
    <div>
      <select name="work_location" id="workLocation">
        <option value="0">勤務地を選択</option>
        @foreach ($prefectures as $id => $prefecture)
          <option value="{{$id}}" {{$id == $data->work_location ? 'selected' : ''}}>{{$prefecture}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div>
    <p class="m-text m-text--rtc">※ Education Careerにまだ会員登録していない方はこのフォームの情報で会員登録をさせていただきます。<br>
      応募する前に<a href="https://local.education-career.jp/terms" class="m-text m-text--primary" target="_blank">利用規約</a>をお読みいただき、同意された上で送信をお願い致します。
    </p>
  </div>
</div>