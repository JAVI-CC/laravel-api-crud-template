@php
$titleHeaderStyles = 'font-weight: bold; background-color: #2197ff; color: #FFFFFF; text-align: center; font-size: 18px;';
$subtitleHeaderStyles = 'font-weight: bold; background-color: #607d8b; color: #FFFFFF;';
@endphp
<table>
    <thead>
        <tr>
            <th colspan="5" style="{{ $titleHeaderStyles }}">{{ __('List of Users') }}</th>
        </tr>
        <tr>
            <th style="{{ $subtitleHeaderStyles }}">ID</th>
            <th style="{{ $subtitleHeaderStyles }}">{{ __('Name') }}</th>
            <th style="{{ $subtitleHeaderStyles }}">{{ __('Surnames') }}</th>
            <th style="{{ $subtitleHeaderStyles }}">{{ __('Email') }}</th>
            <th style="{{ $subtitleHeaderStyles }}">{{ __('Role') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->nombre }}</td>
            <td>{{ $user->apellidos }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ __($user->rol->nombre) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>