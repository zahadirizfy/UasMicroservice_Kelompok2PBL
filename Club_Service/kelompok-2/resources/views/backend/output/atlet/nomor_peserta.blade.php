<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nomor Peserta</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 40px;
        }

        .card {
            width: 500px;
            margin: auto;
            border: 3px solid #000;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .logo {
            width: 60px;
            position: absolute;
            top: 20px;
        }

        .logo-left {
            left: 20px;
        }

        .logo-right {
            right: 20px;
        }

        .title {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .nomor {
            margin: 40px 0;
            font-size: 48px;
            font-weight: bold;
            color: #b30000;
        }

        .info {
            font-size: 16px;
            margin-top: 20px;
        }

        @media print {
            body {
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: 3px solid #000;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="card">
        {{-- Logo kiri --}}
        <img src="{{ asset('dashboard/assets/images/logoporlempika.png') }}" class="logo logo-left" alt="Logo Porlempika">
        
        {{-- Logo kanan --}}
        <img src="{{ asset('frontend/assets/images/koni.png') }}" class="logo logo-right" alt="Logo KONI">

        <div class="title"><h2>Nomor Peserta</h2></div>

        {{-- Nomor Peserta (pakai ID atau format custom) --}}
         <div class="nomor">{{ $nomorPeserta }}</div>

        {{-- Informasi Atlet --}}
        <div class="info">
            <p><strong>Nama:</strong> {{ $atlet->nama }}</p>
            <p><strong>Klub:</strong> {{ $atlet->club->nama ?? '-' }}</p>
            
        </div>
    </div>
</body>
</html>
