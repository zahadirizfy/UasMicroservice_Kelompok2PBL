<!DOCTYPE html>
<html>
<head>
    <title>Data Atlet</title>
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
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 0;
        }
        .foto {
            width: 3cm;
            height: 3cm;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Data Atlet</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Klub</th>
                <th>Prestasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($atlets as $atlet)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($atlet->foto)
                            <img src="{{ public_path('storage/' . $atlet->foto) }}" alt="Foto" class="foto">
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td>{{ $atlet->nama }}</td>
                    <td>{{ $atlet->club->nama ?? '-' }}</td>
                    <td>{{ $atlet->prestasi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
