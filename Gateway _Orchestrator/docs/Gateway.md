# Gateway Orchestrator — Dokumentasi Singkat

Dokumen ini menjelaskan alur panggilan, header yang diteruskan, format response/error, dan contoh log untuk `Gateway _Orchestrator`.

## Ringkasan Fungsi
- Gateway menerima request dari klien dan meneruskan (proxy) ke layanan internal (`User Service`, `Club Service`).
- Gateway juga menyediakan endpoint orchestration yang memanggil beberapa layanan dan menggabungkan hasilnya.
- Gateway menerapkan Correlation ID dan meneruskan token `Authorization` ke layanan downstream.

## Endpoint yang tersedia (di Gateway)
- `GET /api/users/{id}`  — Proxy ke `User Service` (`{USER_SERVICE_URL}/api/users/{id}`)
- `GET /api/clubs/{id}`  — Proxy ke `Club Service` (`{CLUB_SERVICE_URL}/api/clubs/{id}`)
- `GET /api/orchestrate/{userId}/{clubId}` — Memanggil `User Service` dan `Club Service`, menggabungkan respons.

Base URL layanan dikonfigurasi di `config/services.php`:
- `services.user.base` — gunakan env `USER_SERVICE_URL`
- `services.club.base` — gunakan env `CLUB_SERVICE_URL`

## Header dan Context
- Correlation ID:
  - Middleware `App\Http\Middleware\CorrelationIdMiddleware` akan:
    - Membaca header `X-Correlation-ID` jika ada, atau membuat UUID baru.
    - Menyimpan value ke `Context` dan men-set header `X-Correlation-ID` pada request yang diteruskan.
    - Menambahkan header `X-Correlation-ID` pada response.
- Authorization:
  - Jika request masuk memiliki header `Authorization`, gateway akan meneruskannya ke layanan downstream.
  - `ApiGatewayController::proxyGet` menyalin header `Authorization` dari request masuk ke panggilan Http.

## Format Response (standarisasi)
- Response sukses:
  {
    "status": "success",
    "meta": { "timestamp": "...", "correlation_id": "..." , ...},
    "data": { ... }
  }

- Response error (global rendering di `bootstrap/app.php`):
  {
    "status": "error",
    "meta": { "timestamp": "...", "correlation_id": "..." },
    "error": { "code": 500, "message": "..." }
  }

- Proxy/upstream failure (contoh dari gateway):
  - Jika upstream mengembalikan error atau tidak dapat dijangkau, gateway akan mengembalikan `502 Bad Gateway` dengan payload error di atas dan `correlation_id` dilampirkan.

## Logging & Distributed Tracing (cuplikan)
- Setiap error atau event penting di-log dengan menambahkan `correlation_id` ke context/data log.
- Contoh log JSON (kesalahan saat memanggil upstream):

{
  "level": "error",
  "message": "Upstream service returned failure: http://user-service.local/api/users/1",
  "correlation_id": "d7a3f9c6-...",
  "status": 500,
  "timestamp": "2025-12-12T12:34:56Z"
}

- Dengan `correlation_id` yang sama, Anda bisa menggabungkan log di semua service (gateway + user + club) untuk men-trace satu transaksi end-to-end.

## Cara menjalankan test lokal (singkat)
1. Pastikan PHP dan Composer terinstall di mesin Anda.
2. Masuk ke folder project Gateway:

```powershell
Set-Location 'd:\5th\Arsitektur Berbasis Layanan\UAS_ARSITEKTUR\UasMicroservice_Kelompok2PBL\Gateway _Orchestrator'
composer install --no-interaction --prefer-dist
php artisan test
```

- Test yang saya tambahkan: `tests/Feature/GatewayOrchestrationTest.php` (mem-fake HTTP dan memeriksa header + format respons).

## Catatan Integrasi
- Test saat ini menggunakan HTTP fakes; untuk uji integrasi nyata, jalankan `User Service` dan `Club Service` di alamat yang sesuai (`USER_SERVICE_URL` dan `CLUB_SERVICE_URL`) lalu panggil endpoint Gateway.

---
Dokumentasi singkat ini bisa diperpanjang dengan diagram sequence dan contoh log nyata setelah menjalankan layanan dan mengumpulkan log JSON.