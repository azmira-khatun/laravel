<!DOCTYPE html>
<html>

<head>
    <title>Cars & Owners</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Cars & Owners List</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Car Name</th>
                <th>Details</th>
                <th>Owner Name</th>
                <th>Owner Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $index => $car)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $car->name }}</td>
                    <td>{{ $car->details }}</td>
                    <td>{{ $car->owner->name ?? 'No Owner' }}</td>
                    <td>{{ $car->owner->email ?? 'No Email' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>