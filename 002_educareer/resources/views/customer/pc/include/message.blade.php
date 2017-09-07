    @if(Session::has('flash_msg'))
      <div class="m-message m-message--{{ Session::get('flash_msg')->type() }}">
        <ul class="l-group l-group--xs">
          <li>{{ Session::get('flash_msg')->message() }}</li>
        </ul>
      </div>
    @endif

    @if ($errors->count() > 0)
    <div class="m-message m-message--error">
      <ul class="l-group l-group--xs">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

