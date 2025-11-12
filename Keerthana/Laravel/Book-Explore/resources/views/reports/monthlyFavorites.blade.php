<!DOCTYPE html>
<html>

<head>
    <title>Monthly Favorites Report</title>
    <style>
        table {
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <h2>Monthly User Favorite Books Report</h2>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Month</th>
                <th>Favorites Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
            @foreach($user->favorites as $fav)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ DateTime::createFromFormat('!m', $fav->month)->format('F') }}</td>
                <td>{{ $fav->total }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>