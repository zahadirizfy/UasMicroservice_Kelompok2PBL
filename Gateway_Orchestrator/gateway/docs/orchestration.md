# Orchestration (Gateway)

Ringkasan:

- Gateway bertanggung jawab meneruskan panggilan ke service User dan Club.
- Header yang diteruskan: `Authorization` dan `X-Correlation-ID`.
- Semua response dibungkus menjadi format standar: `{ success, message, data }` via middleware `ResponseWrapper`.
- Logging request/response dilakukan oleh `ApiLogging` middleware; Correlation ID di-handle oleh `CorrelationId` middleware.

Alur panggilan singkat:

1. Client → Gateway: kirim `Authorization` (jika ada) dan `X-Correlation-ID` (boleh kosong).
2. `CorrelationId` middleware: set/cipta `X-Correlation-ID` dan tambahkan ke response.
3. `ApiLogging` middleware: buat log `incoming_request` dan `outgoing_response` di channel `gateway`.
4. `ApiGatewayController` meneruskan request ke service tujuan dengan `Http::withHeaders()`.
5. Jika service tujuan gagal, Gateway mengembalikan response konsisten yang berisi `success:false`, `message`, `status`, dan `data` (detail error dari service downstream).

Env yang dipakai (contoh `.env`):

- `USER_SERVICE_BASEURL` e.g. `http://127.0.0.1:8001`
- `CLUB_SERVICE_BASEURL` e.g. `http://127.0.0.1:8002`

Endpoint di Gateway (contoh):

- `GET /api/users` → forward ke `{USER_SERVICE_BASEURL}/api/users`
- `POST /api/users` → forward ke `{USER_SERVICE_BASEURL}/api/users`
- `GET /api/users/{id}` → forward ke `{USER_SERVICE_BASEURL}/api/users/{id}`
- `PUT /api/users/{id}` → forward ke `{USER_SERVICE_BASEURL}/api/users/{id}`
- `DELETE /api/users/{id}` → forward ke `{USER_SERVICE_BASEURL}/api/users/{id}`

- `GET /api/clubs` etc. (mirip dengan users)

Catatan debugging:

- Pastikan `php artisan config:clear` dijalankan bila ada perubahan config atau `.env`.
- Periksa `storage/logs/gateway.log` untuk cuplikan log terdistribusi.
