<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li class="{{ ViewHelper::active_class($module_key, 'home') }}">
            <a href="{{ url('/') }}">サービス概要 <span class="sr-only">(current)</span></a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'customer') }}">
            <a href="{{ url('/customer') }}">カスタマー</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'application') }}">
            <a href="{{ url('/application') }}">応募</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'client') }}">
            <a href="{{ url('/client') }}">クライアント</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'client_rep') }}">
            <a href="{{ url('/client_rep') }}">クライアント担当者</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'admin') }}">
            <a href="{{ url('/admin') }}">オペレーター</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'job') }}">
            <a href="{{ url('/job') }}">求人</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'interview') }}">
            <a href="{{ url('/interview') }}">インタビュー記事</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'ip') }}">
            <a href="{{ url('/ip') }}">IP設定</a>
        </li>
        {{--<li class="{{ ViewHelper::active_class($module_key, 'franchise') }}">--}}
        {{--<a href="{{ url('/franchise') }}">求人（フランチャイズ）</a>--}}
        {{--</li>--}}
    </ul>
</div>