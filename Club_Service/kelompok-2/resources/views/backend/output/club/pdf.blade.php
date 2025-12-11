<!DOCTYPE html>
<html>
<head>
    <title>Data Klub</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
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
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">DATA KLUB</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Klub</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clubs as $club)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $club->nama }}</td>
                    <td>{{ $club->lokasi }}</td>
                    <td>{{ $club->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
