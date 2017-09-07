<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li class="{{ ViewHelper::active_class($module_key, 'posting') }}">
            <a href="{{ url('/posting') }}">求人管理</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'application') }}">
            <a href="{{ url('/application') }}">応募管理</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'company') }}">
            <a href="{{ url('/company/' . Auth::client()->get()->client_id . '/edit') }}">会社情報管理</a>
        </li>
        <li class="{{ ViewHelper::active_class($module_key, 'client_rep') }}">
            <a href="{{ url('/rep') }}">担当者管理</a>
        </li>
    </ul>
</div>