    @if ($errors->count() > 0)
        <div class="l-box s">
            <div class="m-message m-message--error">
                @foreach($errors->all() as $error)
                    <label class="error-msg">{{ $error }}</label><br>
                @endforeach
            </div>
        </div>
    @endif

    @if(Session::has('flash_msg'))
        <div class="m-message m-message--{{ Session::get('flash_msg')->type() }}" role="alert">
            {{ Session::get('flash_msg')->message() }}
        </div>
    @endif

