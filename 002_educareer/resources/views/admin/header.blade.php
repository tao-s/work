<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Education Career</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            @if (Auth::admin()->get())
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <div>{{ Auth::admin()->get()->email }}</div>
                    </li>
                    <li><a href="{{ url('/admin/'.Auth::admin()->get()->id.'/edit') }}">アカウント設定</a></li>
                    <li><a href="{{ url('/logout') }}">ログアウト</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>