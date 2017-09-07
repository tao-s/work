@extends('customer.mobile.layout')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
@stop

@section('custom_js')
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script>
    $(function(){


      var $elem = $(".search-button"), //表示の操作をするオブジェクト(フッター)
              $content = $(".floating-button"), //表示を変更する基準となるオブジェクト
              $win = $(window); //windowオブジェクト

      var contentTop = 0; //表示変更をする基準点


      $win
              .load(function(){
                updatePosition();
                update();
              })
              .resize(function(){
                updatePosition();
                update();
              })
              .scroll(function(){
                update();
              });


      // HTMLが動的に変わることを考えて、contentTopを最新の状態に更新します
      function updatePosition(){
        contentTop = $content.offset().top + $elem.outerHeight();
      }


      // スクロールのたびにチェック
      function update(){
        // 現在のスクロール位置 + 画面の高さで画面下の位置を求めます
        if( $win.scrollTop() + $win.height() > contentTop ){
          $elem.addClass("static");
        }else if( $elem.hasClass("static") ){
          $elem.removeClass("static");
        }
      }


    });
    $("input:checkbox").on('click', function() {
      // in the handler, 'this' refers to the box clicked on
      var $box = $(this);
      if ($box.is(":checked")) {
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        if ($box.attr("name") == "business_type") {
          var grand_group = "input:checkbox[name='grand_" + $box.attr("name") + "']";
          $(grand_group).prop("checked", false);
        }
        if ($box.attr("name") == "grand_business_type") {
          var child_group = "input:checkbox[name='" + $box.attr("name").replace('grand_', '') + "']";
          $(child_group).prop("checked", false);
        }

        // the checked state of the group/box on the other hand will change
        // and the current value is retrieved using .prop() method
        $(group).prop("checked", false);
        $box.prop("checked", true);
      } else {
        $box.prop("checked", false);
      }
    });
  </script>
@stop

@section('content')
  <div class="search-box">
    <form action="{{ url('/job') }}" method="get">
      <div class="job-search">
        <p class="title">職種で絞り込む</p>
        <div class="form-area">
        @foreach ($job_categories as $jc)
          <div class="">
            <input id="{{ $jc->slug }}" name="job_category" type="checkbox" value="{{ $jc->id }}">
            <label for="{{ $jc->slug }}" class="">{{ $jc->title }}</label>
          </div>
        @endforeach
        </div>
      </div>
      <hr class="hr">
      <div class="area-search">
        <p class="title">勤務地で絞り込む</p>
        @foreach ($areas as $area)
          <div class="form-area">
            <p class="sub-title">{{ $area->title }}</p>
            <div class="sub-form-area">
              @foreach ($area->prefectures as $prefecture)

                <input id="{{ $prefecture->slug }}" name="prefecture" type="checkbox" value="{{ $prefecture->id }}">
                <label for="{{ $prefecture->slug }}">{{ $prefecture->casual_title }}</label>
                @if ($prefecture->slug == 'iwate')
                  <br>
                @endif

              @endforeach
            </div>
          </div>
        @endforeach
      </div>
      <hr class="hr">
      <div class="biz-search">
        <p class="title">業種・業態で絞り込む</p>
        @foreach ($grand_business_types as $gbt)
          <div class="form-area">
            <input id="{{ $gbt->slug }}" name="grand_business_type" type="checkbox" value="{{ $gbt->id }}">
            <label for="{{ $gbt->slug }}" class="sub-title">{{ $gbt->title }}</label>
            <div class="link-sub-area">
              @foreach ($gbt->business_types as $bt)
                <input id="{{ $bt->slug }}" name="business_type" type="checkbox" value="{{ $bt->id }}">
                <label for="{{ $bt->slug }}">{{ $bt->title }}</label>
                <?php
                  $line_breaks = [
                    'high-school',
                    'college',
                    'elementary-school',
                    'kinder-garden',
                    'programming-school',
                    'design-school',
                    'cooking-school',
                    'yoga-school',
                    'publishing',
                    'web',
                    'schooling',
                  ];
                ?>
                @if (in_array($bt->slug, $line_breaks))
                  <br>
                @endif
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
      <hr class="hr">
      <div class="work-style-search">
        <p class="title">働き方で絞り込む</p>
        <div class="form-area">
          @foreach ($employment_status as $es)
            <input id="{{ $es->slug }}" name="employment_status" type="checkbox" value="{{ $es->id }}">
            <label for="{{ $es->slug }}">{{ $es->title }}</label><br>
          @endforeach
        </div>
      </div>

      <div class="floating-button">
        <button type="submit" class="search-button floating">選択した条件で探す</button>
      </div>
  </form>
  </div>
@stop
