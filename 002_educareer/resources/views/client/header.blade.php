<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">Education Career</a>
        </div>
        @if(Auth::client()->get())
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <div>
                        <span style="margin-right: 10px">{{ Auth::client()->get()->load('client')->client->company_name }}</span>
                        <span>{{ Auth::client()->get()->email }}</span>
                    </div>
                </li>
                <li><a href="{{ url('/rep/'.Auth::client()->get()->id.'/edit') }}">アカウント設定</a></li>
                <li><a href="{{ url('/logout') }}">ログアウト</a></li>
            </ul>
        </div>
        @endif
    </div>
</nav>