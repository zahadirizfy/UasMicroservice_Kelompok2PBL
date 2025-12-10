<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Anggota</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <h2>Data Anggota</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Klub</th>
                <th>Tanggal Lahir</th>
                <th>Peran</th>
                <th>WA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggotas as $index => $anggota)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $anggota->nama }}</td>
                    <td>{{ $anggota->klub }}</td>
                    <td>{{ $anggota->tgl_lahir }}</td>
                    <td>{{ $anggota->peran }}</td>
                    <td>{{ $anggota->kontak }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
