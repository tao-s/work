<div class="sidemenu sb-slidebar sb-left">
  @if(!$user)
    <div class="l-row l-box xl">
      <div class="col-6"><a class="m-button default col-12" href="{{ url('/login') }}">ログイン</a></div>
      <div class="col-6"><a class="m-button primary col-12" href="{{ url('/register') }}">会員登録</a></div>
    </div>
  @endif
  <ul>
    <li class="{{ Request::is('job*') ? 'is-active' : '' }} sidemenu__list"><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/job') }}">求人を探す</a></li>
        <li class="{{ Request::is('agent*') ? 'is-active' : '' }} sidemenu__list"><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/agent') }}">転職エージェントに相談</a></li>
        <li class="sidemenu__list"><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/recruiter') }}">採用担当者様へ</a></li>
        <li class="sidemenu__list"><span class="glyphicon glyphicon-chevron-right"></span><a href="{{ url('/magazine') }}">コラム</a></li>
    @if ($user)
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <li class="{{ Request::is('mypage') ? 'is-active' : '' }} sidemenu__list"><a href="{{ url('/mypage') }}">マイページ</a></li>
      <li class="{{ Request::is('favorite') ? 'is-active' : '' }} sidemenu__list"><a href="{{ url('/favorite') }}">気になるリスト</a></li>
      <li class="{{ Request::is('mypage/account') ? 'is-active' : '' }} sidemenu__list"><a href="{{ url('/mypage/account') }}">アカウント設定</a></li>
      <li class="{{ Request::is('mypage/profile') ? 'is-active' : '' }} sidemenu__list"><a href="{{ url('/mypage/profile') }}">プロフィール設定</a></li>
      <li class="{{ Request::is('mypage/password') ? 'is-active' : '' }} sidemenu__list"><a href="{{ url('/mypage/password') }}">パスワード設定</a></li>
      <li class="{{ Request::is('mypage/quit') ? 'is-active' : '' }} sidemenu__list"><a href="{{ url('/mypage/quit') }}">退会</a></li>
      <li class="{{ Request::is('mypage/logout') ? 'is-active' : '' }} sidemenu__list"><a data-method="post" href="{{ url('/logout') }}">ログアウト</a></li>
    @endif
  </ul>
</div>
<div class="sidemenu sb-slidebar sb-right">
  <form action="{{ url('/job') }}" method="get">
    <div class="l-box l-group l-row">
      <select name="job_category" class="col-12">
        <option value="null">職種</option>
        @foreach($job_categories as $jc)
          <option {{ isset($query['job_category']) && $query['job_category'] == $jc->id ? 'selected' : '' }} value="{{ $jc->id }}">{{ $jc->title }}</option>
        @endforeach
      </select>
      <select name="employment_status" class="col-12">
        <option value="null">働き方</option>
        @foreach($employment_status as $ec)
          <option {{ isset($query['employment_status']) && $query['employment_status'] == $ec->id ? 'selected' : '' }} value="{{ $ec->id }}">{{ $ec->title }}</option>
        @endforeach
      </select>
      <select name="business_type" class="col-12">
        <option value="null">業態</option>
        @foreach($business_types as $bc)
          <option {{ isset($query['business_type']) && $query['business_type'] == $bc->id ? 'selected' : '' }} value="{{ $bc->id }}">{{ $bc->title }}</option>
        @endforeach
      </select>
      <select name="prefecture" class="col-12">
        <option value="null">勤務地</option>
        @foreach($prefectures as $key => $pf)
          <option {{ isset($query['prefecture']) && $query['prefecture'] == $key ? 'selected' : '' }} value="{{ $key }}">{{ $pf }}</option>
        @endforeach
      </select>

      <input type="text" name="keyword" placeholder="社名、職種名、業種、働き方などフリーワードを入力して検索する" value="{{ isset($query['keyword']) ? $query['keyword'] : '' }}">

      <div class="l-row pickySearch col-12">

        <div class="pickySearch__button">
          <a href="#" class="m-text m-text--primary">
            <span class="pickySearch__button__open"><img class="pickySearch__button__icon" src="/mobile/images/icon-plus.png" />こだわり条件</span>
            <span class="pickySearch__button__close"><img class="pickySearch__button__icon" src="/mobile/images/icon-minus.png" />閉じる</span>
          </a>
        </div>

        <div class="pickySearch__contents">
          @foreach($tags as $tag)
            <label {{ isset($query['tags']) && in_array($tag->id, $query['tags']) ? 'class=is-checked' : '' }}>
              <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
              {{ $tag->name }}
            </label>
          @endforeach
        </div>
      </div>
      <input type="submit" value="検索する" class="m-button default col-12">
    </div>

  </form>
</div>
