@extends('customer.pc.layout')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
  {!! Html::script('js/nested_select.js') !!}
@stop

@section('content')

  <div class="globalViewport l-row">
    <div class="globalMain globalMain--narrow">

      <div class="l-group">
        <h2 class="m-heading m-heading--h2">会員登録</h2>

        <p>サービス登録前に<a href="{{ url('/terms') }}" class="m-text m-text--primary">利用規約</a>をお読みいただき、同意された上で登録をお願い致します。</p>

        @include('customer.pc.include.message')

        <form action="{{ url('/register/'.$customer->id.'/profile') }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="l-group">
            <table class="m-table">
              <tbody>
                <tr>
                  <th><label for="inputUsername">名前 <span class="m-label m-label--require">必須</span></label></th>
                  <td><input name="username" type="text" value="{{ $data->username }}" id="inputUsername" placeholder="名前"></td>
                </tr>

                <tr>
                  <th><label for="inputSex">性別 <span class="m-label m-label--require">必須</span></label></th>
                  <td>
                    <select name="sex" id="inputSex">
                      <option {{ $data->sex == 1 ? 'selected' : '' }} value="1">男性</option>
                      <option {{ $data->sex == 2 ? 'selected' : '' }} value="2">女性</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <th>生年月日  <span class="m-label m-label--require">必須</span></th>
                  <td>
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
                  </td>
                </tr>

                <tr>
                  <th><label for="inputPrefecture">都道府県 <span class="m-label m-label--require">必須</span></label></th>
                  <td>
                    <select name="prefecture" id="inputPrefecture">
                      <option value="">都道府県</option>
                      @foreach($prefectures as $key => $pf)
                        <option {{ $data->prefecture == $key ? 'selected' : ''}} value="{{ $key }}">{{ $pf }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <tr>
                  <th><label for="inputPhone">電話番号 <span class="m-label m-label--require">必須</span></label></th>
                  <td>
                    <input id="inputPhone" type="text" name="phone" value="{{ $data->phone }}" placeholder="電話番号">
                  </td>
                </tr>

                <tr>
                  <th><label for="inputMailMagazineFlag">メールマガジンの受信</label></th>
                  <td>
                    <select name="mail_magazine_flag" id="inputMailMagazineFlag">
                      {{-- パスワードが入っている場合は通常の会員登録動線 --}}
                      <option {{ $data->mail_magazine_flag || !is_null($data->password) ? 'selected' : '' }} value="true">許可する</option>
                      <option {{ !$data->mail_magazine_flag && is_null($data->password) ? 'selected' : '' }} value="false">許可しない</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <th><label for="inputScoutMailFlag">スカウトメールの受信</label></th>
                  <td>
                    <select name="scout_mail_flag" id="inputScoutMailFlag">
                      {{-- パスワードが入っている場合は通常の会員登録動線 --}}
                      <option {{ $data->scout_mail_flag || !is_null($data->password) ? 'selected' : '' }} value="true">許可する</option>
                      <option {{ !$data->scout_mail_flag && is_null($data->password) ? 'selected' : '' }} value="false">許可しない</option>
                    </select>
                  </td>
                </tr>


                @if ($should_input_password)
                  <tr>
                    <th><label for="inputPassword">パスワード <span class="m-label m-label--require">必須</span></label></th>
                    <td><input name="password" type="password" value="" id="inputPassword" placeholder="パスワード"></td>
                  </tr>
                  <tr>
                    <th><label for="inputPasswordConfirmation">パスワード（確認用） <span class="m-label m-label--require">必須</span></label></th>
                    <td><input name="password_confirmation" type="password" value="" id="inputPasswordConfirmation" placeholder="パスワード（確認用）"></td>
                  </tr>
                @endif

                <tr>
                  <th>最終学歴</th>
                  <td>
                    <select name="school_record_id">
                      <option value="">最終学歴</option>
                      @foreach ($school_records as $school_record)
                        <option {{ $data->school_record_id == $school_record->id ? 'selected' : '' }} value="{{ $school_record->id }}">
                          {{ $school_record->title }}
                        </option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <tr>
                  <th>学校名</th>
                  <td><input name="school_name" type="text" id="inputSchoolName" value="{{ $data->school_name }}" placeholder="学校名"></td>
                </tr>

                <tr>
                  <th>卒業年度</th>
                  <td>
                    <select name="graduate_year">
                      <option value="">卒業年度</option>
                      @for ($i = 1; $i<=50; $i++)
                        <?php $year = \Carbon\Carbon::today()->subYear($i-7)->format('Y'); ?>
                        <option {{ $year == $data->graduate_year ? 'selected' : ''}} value="{{ $year }}">{{ $year }}年</option>
                      @endfor
                    </select>
                  </td>
                </tr>

                <tr>
                  <th><label for="inputJobRecord">職歴</label></th>
                  <td><textarea name="job_record" id="inputJobRecord">{{ $data->job_record }}</textarea></td>
                </tr>

                <tr>
                  <th><label for="inputSkill">活かせる経験・スキル</label></th>
                  <td><textarea name="skill" id="inputSkill">{{ $data->skill }}</textarea></td>
                </tr>

                <tr>
                  <th><label for="inputQualification">保有資格</label></th>
                  <td><textarea name="qualification" id="inputQualification">{{ $data->qualification }}</textarea></td>
                </tr>

                <tr>
                  <th><label for="inputIntroduction">自己紹介/キャリアサマリー</label></th>
                  <td><textarea name="introduction" id="inputIntroduction">{{ $data->introduction }}</textarea></td>
                </tr>

                <tr>
                  <th><label for="inputFuturePlan">取り組みたいこと/関心トピック</label></th>
                  <td><textarea name="future_plan" id="inputFuturePlan">{{ $data->future_plan }}</textarea></td>
                </tr>

                <tr>
                  <th><label for="inputCompanyName">直近の勤務先企業名</label></th>
                  <td>
                    <div class="l-group l-group--xs">
                      <textarea name="company_name" id="inputCompanyName" placeholder="直近の勤務先企業名">{{ $data->company_name }}</textarea>
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
                          <option {{ $data->industry_type1 == $industry_type->id ? 'selected' : '' }} value="{{$industry_type->id}}">
                            {{$industry_type->name}}
                          </option>
                        @endforeach
                      </select>
                      <select name="industry_type[]" id="industryType2">
                        <option value="">直近の勤務先業種2</option>
                        @foreach($industry_types as $industry_type)
                          <option {{ $data->industry_type2 == $industry_type->id ? 'selected' : '' }} value="{{$industry_type->id}}">
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
                                style="{{ !$data->{'occupation_category' . $i} || $data->{'occupation_category' . $i} == 80 ? 'display:none;' : '' }}">
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
                          <option value="{{$id}}" {{$id == $data->work_location ? 'selected' : ''}}>{{$prefecture}}</option>
                        @endforeach
                      </select>
                    </div>
                  </td>
                </tr>

              </tbody>
            </table>
            
            <div class="l-row l-row--xs">
              <div class="col-12"><input type="submit" value="完了" class="m-button m-button--default"></div>
            </div>
          </div>

        </form>
      </div>
    </div>

  </div>
@stop
