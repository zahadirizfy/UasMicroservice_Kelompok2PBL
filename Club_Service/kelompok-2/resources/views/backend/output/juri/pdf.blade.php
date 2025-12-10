<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Juri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>

    <h2>Data Juri</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Juri</th>
                <th>Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($juris as $juri)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $juri->nama_juri }}</td>
                    <td>{{ \Carbon\Carbon::parse($juri->tanggal_lahir)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
