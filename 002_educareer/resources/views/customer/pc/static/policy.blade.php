@extends('customer.pc.layout')

@section('title', 'プライバシーポリシー | 教育業界に特化した就職・転職の求人サービス【Education Career】')
@section('description', 'EducationCareerのプライバシーポリシーについて。EducationCareerは教育業界に就職・転職したい方、関心のあるすべての方に向けた求人情報サービスです。正社員や業務委託、パートやアルバイト、インターン、会社を辞めずに手伝えるプロボノやボランティアなど多様な働き方が選べます。')

@section('custom_css')
  {!! Html::style('css/slick.css') !!}
  {!! Html::style('css/slick-theme.css') !!}
  {!! Html::style('css/bootstrap.css') !!}
@stop

@section('custom_js')
@stop

@section('content')

  <div class="globalViewport l-row">
    <div class="globalMain globalMain--narrow">

      <div class="l-group">
        <h1 class="m-heading m-heading--h2">プライバシーポリシー</h1>
        <p>株式会社ファンオブライフは（以下「当社」といいます。）は、当社の提供するサービス（以下（本サービス）といいます。）における、ユーザーについての個人情報を含む利用者情報の取り扱いについて、以下の通りプライバシーポリシー（以下「本ポリシーといいます。」）を定めます。</p>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">1.収集する利用者情報及び収集方法</p>
          <p>本ポリシーにおいて、「利用者情報」とは、ユーザーの識別に係る情報、通信サービス上の行動履歴、その他ユーザーのスマートフォン、PC等の端末においてユーザーまたはユーザーの端末に関連して生成または蓄積された情報であって、本ポリシーに基づき当社が収集するものを意味するものとします。<br>
          本サービスにおいて当社が収集する利用者情報は、その収集方法に応じて、以下のようなものとなります。</p>
          <ol class="m-list m-list--ordered">
            <li class="l-group l-group--xs">
              <p>ユーザーからご提供いただく情報</p>
              <p>ユーザーが本サービスを利用するために、ご提供いただく情報は以下のとおりです。</p>
              <ul class="m-list m-list--unordered">
                <li>氏名</li>
                <li>メールアドレス</li>
                <li>生年月日</li>
                <li>職歴</li>
                <li>学歴</li>
                <li>その他当社が定める入力フォームにユーザーが入力する情報</li>
              </ul>
            </li>
            <li class="l-group l-group--xs">
              <p>ユーザーが本サービスの利用において、他のサービスと連携を許可することにより、当該他のサービスからご提供いただく情報</p>
              <p>ユーザーが、本サービスを利用するにあたり、ソーシャルネットワークサービス等の外部サービスとの連携を許可した場合には、その許可の際にご同意いただいた内容に基づき、以下の情報を当該外部サービスから収集します。</p>
              <ul class="m-list m-list--unordered">
                <li>当該外部サービスでユーザーが利用するID</li>
                <li>その他当該外部サービスのプライバシー設定によりユーザーが連携先に開示を認めた情報</li>  
              </ul>
            </li>
            <li class="l-group l-group--xs">
              <p>ユーザーが本サービスを利用するにあたって、当社が収集する情報</p>
              <p>　当社は、本サービスへのアクセス状況やそのご利用方法に関する情報を収集することがあります。これには以下の情報が含まれます。</p>
              <ul class="m-list m-list--unordered">
                <li>端末情報</li>
                <li>ログ情報</li>
                <li>Cookie及び匿名ID</li>
                <li>位置情報</li>
              </ul>
            </li>
          </ol>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">2.利用目的</p>
          <ol class="m-list m-list--ordered">
            <li>利用者情報は、2-2に定めるとおり本サービスの提供のために利用されるほか、2-3に定めるとおり、その他の目的にも利用される場合があります。</li>
            <li class="l-group l-group--xs">
              <p>本サービスのサービス提供にかかわる利用者情報の具体的な利用目的は以下のとおりです。</p>
              <ol class="m-list m-list--ordered">
                <li>本サービスに関する登録の受付、本人確認、本サービスの提供、維持、保護及び改善のため</li>
                <li>本サービスに関するご案内、お問い合せ等への対応のため</li>
                <li>本サービスに関する当社の規約、ポリシー等（以下「規約等」といいます。）に違反する行為に対する対応のため</li>
                <li>本サービスに関する規約等の変更などを通知するため</li>
                <li>上記の利用目的に付随する利用目的のため</li>
              </ol>
            </li>
            <li class="l-group l-group--xs">
              <p>上記2-2以外の利用目的は以下のとおりです。</p>
              <div>
                <table class="m-table">
                  <thead>
                    <tr>
                      <th>利用目的</th>
                      <th>対応する利用者情報の項目</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>当社のサービスに関連して、個人を識別できない形式に加工した統計データを作成するため</td>
                      <td>
                        <ul class="m-list m-list--unordered">
                          <li>端末情報</li>
                          <li>ログ情報</li>
                          <li>Cookie及び匿名ID</li>
                          <li>位置情報</li>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td>当社または第三者の広告の配信または表示のため</td>
                      <td>
                        <ul class="m-list m-list--unordered">
                          <li>端末情報</li>
                          <li>ログ情報</li>
                          <li>Cookie及び匿名ID</li>
                          <li>位置情報</li>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td>その他マーケティングに利用するため</td>
                      <td>
                        <ul class="m-list m-list--unordered">
                          <li>氏名</li>
                          <li>メールアドレス</li>
                          <li>生年月日</li>
                          <li>その他当社が定める入力フォームにユーザーが入力する情報</li>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </li>
          </ol>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">3.通知・公表または同意取得の方法、利用中止要請の方法</p>
          <ol class="m-list m-list--ordered">
            <li class="l-group l-group--xs">
              <p>以下の利用者情報については、その収集が行われる前にユーザーの同意を得るものとします。</p>
              <ul class="m-list m-list--unordered">
                <li>端末情報</li>
                <li>位置情報</li>  
              </ul>
            </li>
            <li>ユーザーは、本サービスの所定の設定を行うことにより、利用者情報の全部または一部についてその利用の停止を求めることができ、この場合、当社は速やかに、当社の定めるところに従い、その利用を停止します。なお利用者情報の項目によっては、その収集または利用が本サービスの前提となるため、当社所定の方法により本サービスを退会した場合に限り、当社はその収集を停止します。</li>
          </ol>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">4.外部送信、第三者提供、情報収集モジュールの有無</p>
          <p>利用者情報を利用したターゲティング広告の配信のため、Cookieを利用して、下記の企業が提供する行動ターゲティング広告サービスを利用しています。</p>
          <p>このサービスの設定やオプトアウトの方法は、各社の設定ページで行なってください。</p>
          <ul class="m-list m-list--unordered">
            <li><a href="http://www.google.co.jp/intl/ja/policies/technologies/ads/" target="_blank">グーグル株式会社の広告設定</a></li>
            <li><a href="https://www.facebook.com/ad_guidelines.php" target="_blank">Facebookの広告ガイドライン</a></li>
            <li><a href="http://btoptout.yahoo.co.jp/optout/index.html" target="_blank">ヤフー株式会社の広告設定</a></li>
          </ul>
        </div>
        
        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">5.第三者提供</p>
          <p>当社は、利用者情報のうち、個人情報については、個人情報保護法その他の法令に基づき開示が認められる場合を除くほか、あらかじめユーザーの同意を得ないで、第三者に提供しません。但し、次に掲げる場合はこの限りではありません。</p>
          <ol class="m-list m-list--ordered">
             <li>当社が利用目的の達成に必要な範囲内において個人情報の取扱いの全部または一部を委託する場合</li>
            <li>合併その他の事由による事業の承継に伴って個人情報が提供される場合</li>
            <li>第4項の定めに従って、情報収集モジュール提供者へ個人情報が提供される場合</li>
            <li>国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、ユーザーの同意を得ることによって当該事務の遂行に支障を及ぼすおそれがある場合</li>
            <li>その他、個人情報保護法その他の法令で認められる場合</li>
          </ol>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">6.個人情報の開示</p>
          <p>当社は、ユーザーから、個人情報保護法の定めに基づき個人情報の開示を求められたときは、ユーザーご本人からのご請求であることを確認の上で、ユーザーに対し、遅滞なく開示を行います（当該個人情報が存在しないときにはその旨を通知いたします。）。但し、個人情報保護法その他の法令により、当社が開示の義務を負わない場合は、この限りではありません。なお、個人情報の開示につきましては、手数料（1件あたり1,000円）を頂戴しておりますので、あらかじめ御了承ください。</p>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">7.個人情報の訂正及び利用停止等</p>
          <ol class="m-list m-list--ordered">
            <li>当社は、ユーザーから、⑴個人情報が真実でないという理由によって個人情報保護法の定めに基づきその内容の訂正を求められた場合、及び⑵あらかじめ公表された利用目的の範囲を超えて取り扱われているという理由または偽りその他不正の手段により収集されたものであるという理由により、個人情報保護法の定めに基づきその利用の停止を求められた場合には、ユーザーご本人からのご請求であることを確認の上で遅滞なく必要な調査を行い、その結果に基づき、個人情報の内容の訂正または利用停止を行い、その旨をユーザーに通知します。なお、合理的な理由に基づいて訂正または利用停止を行わない旨の決定をしたときは、ユーザーに対しその旨を通知いたします。</li>
            <li>当社は、ユーザーから、ユーザーの個人情報について消去を求められた場合、当社が当該請求に応じる必要があると判断した場合は、ユーザーご本人からのご請求であることを確認の上で、個人情報の消去を行い、その旨をユーザーに通知します。</li>
            <li>個人情報保護法その他の法令により、当社が訂正等または利用停止等の義務を負わない場合は、前2項の規定は適用されません。</li>
          </ol>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">8.お問い合わせ窓口</p>
          <p>ご意見、ご質問、苦情のお申出その他利用者情報の取扱いに関するお問い合わせは、下記の窓口までお願い致します。</p>
          <div>
            <p>住所：〒1500001　東京都渋谷区神宮前6−19−16 U-natura301</p>
            <p>株式会社ファンオブライフ</p>
            <p>E-mail：support@funoflife.co.jp</p>
          </div>
        </div>

        <div class="l-group l-group--xs">
          <p class="m-text m-text--bold">9.プライバシーポリシーの変更手続</p>
          <p>当社は、利用者情報の取扱いに関する運用状況を適宜見直し、継続的な改善に努めるものとし、必要に応じて、本ポリシーを変更することがあります。<br>
変更した場合には、本ページ内に掲示する形でユーザーに通知いたします。<br>
但し、法令上ユーザーの同意が必要となるような内容の変更の場合は、当社所定の方法でユーザーの同意を得るものとします。</p>
        </div>

      </div>

    </div>

  </div>
@stop
