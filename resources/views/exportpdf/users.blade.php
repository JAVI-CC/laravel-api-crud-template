<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            text-align: left;
            padding: 4px;
            font-weight: normal;
            font-size: 12px;
            border-bottom: 1px solid #AAAAAA;
        }

        thead {
            border-bottom: 3px solid;
        }
    </style>
</head>

<body>
    <h5>{{__('List of Users')}}</h5>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Surnames')}}</th>
                <th>{{__('Email')}}</th>
                <th>{{__('Role')}}</th>
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
</body>

</html>