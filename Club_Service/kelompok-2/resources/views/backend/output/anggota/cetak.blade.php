<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Anggota</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 60px 20px;
        }

        .card {
            width: 500px;
            background: linear-gradient(135deg, #8B0000, #000000);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            margin: auto;
            display: flex;
            gap: 20px;
            padding: 20px;
            color: white;
            border: 3px solid #ffffff;
            position: relative;
            overflow: hidden;

            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            background-image: url('{{ asset('dashboard/assets/images/logoporlempika.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
        }

        .card > * {
            position: relative;
            z-index: 1;
        }

        .foto {
            width: 140px;
            height: 180px;
            object-fit: cover;
            border: 2px solid #ffffff;
            border-radius: 6px;
        }

        .foto-placeholder {
            width: 140px;
            height: 180px;
            background: #ddd;
            border: 2px solid #ffffff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }

        .info {
            flex: 1;
        }

        .info .judul {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .judul-text {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .logo-group img {
            height: 35px;
            margin-left: 5px;
        }

        .info h3 {
            margin: 8px 0 12px;
            font-size: 22px;
            color: #ffc107;
        }

        .info p {
            margin: 6px 0;
            font-size: 14px;
        }

        @media print {
            body {
                background: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: 3px solid #ffffff;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="card">
        {{-- Foto --}}
        @if ($anggota->foto)
            <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" class="foto">
        @else
            <div class="foto-placeholder">Tidak Ada Foto</div>
        @endif

        {{-- Info --}}
        <div class="info">
            <div class="judul">
                <h2 class="judul-text">Kartu Tanda Anggota Porlempika</h2>
                <div class="logo-group">
                    <img src="{{ asset('dashboard/assets/images/logoporlempika.png') }}" alt="Logo Porlempika">
                    
                </div>
                <div class="logo-group">
                    <img src="{{ asset('frontend/assets/images/koni.png') }}" alt="Logo KONI">
                    </div>
            </div>
            <hr>
            <h3>{{ strtoupper($anggota->nama) }}</h3>
            <p><strong>Klub:</strong> {{ $anggota->klub }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $anggota->tgl_lahir }}</p>
            <p><strong>Peran:</strong> {{ $anggota->peran }}</p>
            <p><strong>Kontak WA:</strong> {{ $anggota->kontak }}</p>
        </div>
    </div>
</body>
</html>
