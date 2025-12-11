<!DOCTYPE html>
<html>
<head>
    <title>Data Penyelenggara Event</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Data Penyelenggara Event</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyelenggara</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penyelenggaras as $index => $penyelenggara)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penyelenggara->nama_penyelenggara_event }}</td>
                    <td>{{ $penyelenggara->kontak }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
