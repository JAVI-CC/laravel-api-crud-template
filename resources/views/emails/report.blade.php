<div>
    <h2><u>{{ __('Report') }}:</u></h2>
    <div style="margin-left: 20px">
        <p><b>ID: </b><span>{{ $id }}</span></p>
        <p><b>URI: </b><span>{{ $uri }}</span></p>
        <p><b>{{ __('Message') }}: </b><span>{{ $mensaje }}</span></p>
        <p><b>{{ __('Date') }}: </b><span>{{ $fecha }}</span></p>
    </div>

    <h2><u>{{ __('User') }}:</u></h2>
    <div style="margin-left: 20px">
        @if ($user)
            <p><b>ID: </b><span>{{ $user->id }}</span></p>
            <p><b>{{ __('Name') }}: </b><span>{{ $user->nombre }}</span></p>
            <p><b>Email: </b><span>{{ $user->email }}</span></p>
        @else
            <p><b>{{ __('You are not logged in') }}</b></p>
        @endif
    </div>

    <h2><u>{{ __('Parameters') }}:</u></h2>
    <div style="margin-left: 20px">
        @if ($parameters && $parameters != [])
            <p>{{ $parameters }}</p>
        @else
            <p><b>{{ __('It has no parameters') }}</b></p>
        @endif
    </div>
</div>
