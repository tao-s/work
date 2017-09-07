@extends('admin.layout')

@section('title')
    {{ 'カスタマー管理 | ' }}
@stop

@section('custom_css')
    {!! Html::style('css/admin/dashboard.css') !!}
    {!! Html::style('css/admin/admin.css') !!}
    {!! Html::style('css/admin/bootstrap-select.min.css') !!}
@stop

@section('custom_js')
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/bootstrap-select.js') !!}
    {!! Html::script('js/request_sender.js') !!}
@stop

@section('content')

    @include('admin.header')

    <div class="container-fluid">
        <div class="row">

            @include('admin.sidebar')

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                <h1 class="page-header">プロフィール情報編集</h1>

                @if(Session::has('flash_msg'))
                    <div class="alert alert-{{ Session::get('flash_msg')->type() }}" role="alert">
                        {{ Session::get('flash_msg')->message() }}
                    </div>
                @endif

                <p style="font-size: 16px"><span style="color: red">*</span> は必須項目</p>

                <form action="{{ url('/customer_profile/'.$customer->id) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="put">

                    <div class="col-xs-5 form-adjust">
                        @foreach($errors->all() as $error)
                            <label class="error-msg">{{ $error }}</label><br>
                        @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputEmail">メールアドレス</label>
                        <input name="email" type="text" id="inputEmail" class="form-control"
                               value="{{ $customer->email }}" placeholder="メールアドレス" disabled>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputUsername"><span style="color: red">*</span> ユーザ名</label>
                        <input name="username" type="text" id="inputUsername" class="form-control"
                               value="{{ $data->username }}" placeholder="ユーザ名">
                    </div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputSex">性別</label>
                        <select class="form-control" name="sex" id="inputSex">
                            <option {{ $data->sex == 1 ? 'selected' : '' }} value="1">男性</option>
                            <option {{ $data->sex == 2 ? 'selected' : '' }} value="2">女性</option>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputBirthday">生年月日</label>
                        <div>
                            <select class="form-control pull-left margin-right20" style="width: 30%" name="year">
                                <option value="">年</option>
                                @for ($i = 1; $i<=70; $i++)
                                    <?php $year = \Carbon\Carbon::today()->subYear($i)->format('Y'); ?>
                                    <option {{ $year == $data->year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}年</option>
                                @endfor
                            </select>
                            <select class="form-control pull-left margin-right20" style="width: 30%" name="month">
                                <option value="">月</option>
                                @for ($i = 1; $i <=12; $i++)
                                    <option {{ $i == $data->month ? 'selected' : '' }} value="{{ $i }}">{{ $i }}月</option>
                                @endfor
                            </select>
                            <select class="form-control pull-left" style="width: 30%" name="day">
                                <option value="">日</option>
                                @for ($i = 1; $i <=31; $i++)
                                    <option {{ $i == $data->day ? 'selected' : '' }} value="{{ $i }}">{{ $i }}日</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputMailMagazineFlag">メールマガジンの受信</label>
                        <select class="form-control" name="mail_magazine_flag" id="inputMailMagazineFlag">
                            {{-- パスワードが入っている場合は通常の会員登録動線 --}}
                            <option {{ $data->mail_magazine_flag ? 'selected' : '' }} value="true">許可する</option>
                            <option {{ !$data->mail_magazine_flag ? 'selected' : '' }} value="false">許可しない</option>
                        </select>
                    </div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputScoutMailFlag">スカウトメールの受信</label>
                        <select class="form-control" name="scout_mail_flag" id="inputScoutMailFlag">
                            {{-- パスワードが入っている場合は通常の会員登録動線 --}}
                            <option {{ $data->scout_mail_flag ? 'selected' : '' }} value="true">許可する</option>
                            <option {{ !$data->scout_mail_flag ? 'selected' : '' }} value="false">許可しない</option>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputSchoolRecord">最終学歴</label>
                        <select class="form-control" name="school_record_id">
                            <option value="">最終学歴</option>
                            @foreach ($school_records as $school_record)
                                <option {{ $data->school_record_id == $school_record->id ? 'selected' : '' }} value="{{ $school_record->id }}">
                                    {{ $school_record->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xs-4 form-adjust">
                        <label for="inputSchoolName">学校名</label>
                        <input type="text" name="school_name" id="inputSchoolName" class="form-control" value="{{ $data->school_name }}"
                                  placeholder="学校名">
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputGraduateYear">卒業年度</label>
                        <select class="form-control" name="graduate_year">
                            <option value="">卒業年度</option>
                            @for ($i = 1; $i<=50; $i++)
                                <?php $year = \Carbon\Carbon::today()->subYear($i-7)->format('Y'); ?>
                                <option {{ $year == $data->graduate_year ? 'selected' : ''}} value="{{ $year }}">{{ $year }}年</option>
                            @endfor
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputJobRecord">職歴</label>
                        <textarea rows="5" name="job_record" id="inputJobRecord" class="form-control"
                                  placeholder="職歴">{{ $data->job_record }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputSkill">活かせる経験・スキル</label>
                        <textarea rows="5" name="skill" id="inputSkill" class="form-control"
                                  placeholder="活かせる経験・スキル">{{ $data->skill }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputQualification">保有資格</label>
                        <textarea rows="5" name="qualification" id="inputQualification" class="form-control"
                                  placeholder="保有資格">{{ $data->qualification }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputIntroduction">自己紹介/キャリアサマリー</label>
                        <textarea rows="5" name="introduction" id="inputIntroduction" class="form-control"
                                  placeholder="自己紹介/キャリアサマリー">{{ $data->introduction }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <label for="inputFuturePlan">取り組みたいこと/関心トピック</label>
                        <textarea rows="5" name="future_plan" id="inputFuturePlan" class="form-control"
                                  placeholder="取り組みたいこと/関心トピック">{{ $data->future_plan }}</textarea>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-8 form-adjust">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">変更を保存</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop