# DOKUMENTASI GATEWAY ORCHESTRATION

## Untuk Presentasi ke Dosen

---

## 1. APA ITU GATEWAY?

Gateway adalah **pintu gerbang utama** microservices kamu. Semua request dari client masuk ke sini dulu, baru di-forward ke service lain (User Service, Club Service). 

**Keuntungan menggunakan Gateway:**
- Client tidak perlu tahu alamat service lain (hanya tahu Gateway saja)
- Semua request bisa di-log & monitor dari satu tempat
- Bisa menambahkan security layer di satu tempat
- Bisa standardisasi format request/response untuk semua service

---

## 2. FITUR-FITUR YANG DIIMPLEMENTASIKAN

### A. Routing CRUD (Create, Read, Update, Delete)

Di file `routes/api.php`, saya buat routing untuk semua endpoint:

**User Service Endpoints:**
```
GET    /api/users           → Ambil semua user
POST   /api/users           → Buat user baru
GET    /api/users/{id}      → Ambil user dengan ID tertentu
PUT    /api/users/{id}      → Edit user dengan ID tertentu
DELETE /api/users/{id}      → Hapus user dengan ID tertentu
```

**Club Service Endpoints:**
```
GET    /api/clubs           → Ambil semua club
POST   /api/clubs           → Buat club baru
GET    /api/clubs/{id}      → Ambil club dengan ID tertentu
PUT    /api/clubs/{id}      → Edit club dengan ID tertentu
DELETE /api/clubs/{id}      → Hapus club dengan ID tertentu
```

### B. Proxy Controller (Meneruskan Request)

Di file `ApiGatewayController.php`, setiap endpoint melakukan 3 langkah:

**Langkah 1: Terima request** dari client (dengan header Authorization & Correlation ID)

**Langkah 2: Forward request** ke service tujuan dengan header yang sama

**Langkah 3: Wrap response** dalam format standar: `{ success, message, data }`

**Contoh kode (getUsers):**
```php
public function getUsers(Request $request)
{
    // Langkah 2: Forward request dengan header yang sama
    $response = Http::withHeaders([
        'Authorization'    => $request->header('Authorization'),        // Teruskan token
        'X-Correlation-ID' => $request->header('X-Correlation-ID'),    // Teruskan ID tracking
    ])->get($this->userService . '/users');                            // Call User Service
    
    // Langkah 3: Bungkus response dalam format standar
    return $this->wrapResponse($response);
}
```

**Kode untuk wrapping response:**
```php
private function wrapResponse($response)
{
    if ($response->failed()) {
        // Jika error, bungkus error dalam format standar
        return response()->json([
            'success' => false,
            'message' => 'Service error',
            'status'  => $response->status(),
            'data'    => $response->json(),
        ], $response->status());
    }

    // Jika sukses, bungkus data dalam format standar
    return response()->json([
        'success' => true,
        'message' => 'OK',
        'data'    => $response->json(),
    ]);
}
```

---

## 3. MIDDLEWARE (Guard yang Menjaga Request)

Semua request melewati 3 middleware sebelum sampai ke controller:

### A. CorrelationId Middleware

**Fungsi:** Membuat ID unik untuk setiap request (untuk tracking request)

**Proses:**
1. Jika client mengirim `X-Correlation-ID` di header, ambil itu
2. Jika tidak, gateway membuat ID baru (UUID format)
3. ID ini diteruskan ke User Service & Club Service
4. Semua service mencatat ID yang sama

**Keuntungan:** Bisa trace satu request dari awal sampai akhir melalui semua service

**Analogi:** Seperti nomor antrian di warung makan — satu nomor untuk satu pelanggan dari awal sampai selesai.

### B. ApiLogging Middleware

**Fungsi:** Mencatat setiap request masuk & response keluar

**Log yang dicatat:**
- `incoming_request`: siapa, dari mana, minta apa, dengan data apa
- `outgoing_response`: status respons, data respons

**Contoh log (JSON format):**
```json
{
  "message": "incoming_request",
  "context": {
    "correlation_id": "abc-123-xyz",
    "method": "GET",
    "url": "http://127.0.0.1:8000/api/users",
    "ip": "127.0.0.1",
    "body": []
  },
  "level": 200,
  "channel": "gateway",
  "datetime": "2025-12-09T14:30:45.123456+00:00"
}
```

### C. ResponseWrapper Middleware

**Fungsi:** Membuat format response konsisten untuk semua endpoint

**Format standar untuk semua response:**
```json
{
  "success": true,
  "message": "OK",
  "data": {
    // data yang diminta
  }
}
```

**Jika ada error:**
```json
{
  "success": false,
  "message": "Service error",
  "status": 500,
  "data": {
    // detail error dari service
  }
}
```

---

## 4. LOGGING TERDISTRIBUSI (Distributed Logging)

### Masalah:
Ketika 3 service bekerja sama (Gateway → User Service → Club Service), logging mereka terpisah di file berbeda. Bagaimana cara trace satu request di 3 tempat berbeda?

### Solusi: Correlation ID

**Proses:**
1. Gateway terima request dengan `X-Correlation-ID` (atau buat baru jika tidak ada)
2. Gateway forward `X-Correlation-ID` ke User Service & Club Service
3. Ketiga service mencatat request dengan `X-Correlation-ID` yang sama
4. Jika ada error, bisa cek log ketiga service dengan filter Correlation ID yang sama

**Contoh:**
```
Request dari client ke Gateway:
  Correlation ID: "req-123-abc"
  
Gateway log:
  "incoming_request" dengan Correlation ID: "req-123-abc"
  
Gateway forward ke User Service dengan header:
  X-Correlation-ID: "req-123-abc"
  
User Service log:
  "user_created" dengan Correlation ID: "req-123-abc"
  
Gateway forward ke Club Service dengan header:
  X-Correlation-ID: "req-123-abc"
  
Club Service log:
  "club_updated" dengan Correlation ID: "req-123-abc"
  
Gateway log:
  "outgoing_response" dengan Correlation ID: "req-123-abc"
```

**Hasil:** Semua log terhubung seperti "jejak" satu request yang melewati 3 service.

---

## 5. CHANNEL "GATEWAY" (Mengapa Log di File Terpisah?)

Semua log Gateway disimpan di file khusus: `storage/logs/gateway.log`

**Keuntungan:**
- Log Gateway terpisah dari service lain
- User Service punya lognya sendiri (`User_Service/storage/logs/...`)
- Club Service punya lognya sendiri (`Club_Service/storage/logs/...`)
- Tidak berantakan, mudah di-debug
- Bisa filter log spesifik untuk Gateway saja

**Implementasi:**
Di file `config/logging.php`, ada konfigurasi channel `gateway`:
```php
'gateway' => [
    'driver' => 'single',
    'path' => storage_path('logs/gateway.log'),
    'level' => 'info',
    'formatter' => \Monolog\Formatter\JsonFormatter::class,
    'tap' => [App\Logging\SetChannelName::class],
],
```

Class `SetChannelName` memastikan nama channel di log selalu "gateway":
```php
class SetChannelName
{
    public function __invoke(Logger $logger)
    {
        $logger->setName('gateway');
    }
}
```

---

## 6. ERROR HANDLING (Bagaimana Kalau Service Lain Error?)

Jika User Service atau Club Service error (status 400, 500, dll):

**Proses:**
1. Gateway catch error dari service
2. Return response konsisten ke client dengan format standar
3. Tidak ada error yang tidak tertangani

**Contoh respons error:**
```json
{
  "success": false,
  "message": "Service error",
  "status": 500,
  "data": {
    "error": "Database connection failed",
    "detail": "..."
  }
}
```

**Kode error handling:**
```php
private function wrapResponse($response)
{
    // Jika status response menunjukkan error (4xx atau 5xx)
    if ($response->failed()) {
        return response()->json([
            'success' => false,
            'message' => 'Service error',
            'status'  => $response->status(),
            'data'    => $response->json(),
        ], $response->status());
    }
    
    // Jika berhasil
    return response()->json([
        'success' => true,
        'message' => 'OK',
        'data'    => $response->json(),
    ]);
}
```

---

## 7. FILE-FILE YANG DIBUAT/DIUBAH

### File yang dimodifikasi:

| File | Fungsi |
|------|--------|
| `routes/api.php` | Definisi semua endpoint CRUD dengan middleware wrapper |
| `app/Http/Controllers/ApiGatewayController.php` | Logic meneruskan request ke service lain & wrapping response |
| `app/Http/Middleware/CorrelationId.php` | Middleware untuk set/create Correlation ID |
| `app/Http/Middleware/ApiLogging.php` | Middleware untuk log incoming request & outgoing response |
| `app/Http/Middleware/ResponseWrapper.php` | Middleware untuk standarisasi format response JSON |
| `config/logging.php` | Konfigurasi channel logging (dengan tap SetChannelName) |

### File yang dibuat baru:

| File | Fungsi |
|------|--------|
| `app/Logging/SetChannelName.php` | Tap untuk enforce nama channel "gateway" di log |
| `tests/Feature/OrchestrationTest.php` | Unit test untuk verifikasi forwarding headers |
| `docs/orchestration.md` | Dokumentasi alur & env variables |
| `docs/PRESENTASI.md` | Dokumentasi ini |

---

## 8. FLOW DIAGRAM LENGKAP

```
┌─────────────────────────────────────────────────────────────────┐
│                          CLIENT                                  │
│  (kirim request dengan Authorization & X-Correlation-ID)        │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│              GATEWAY - CorrelationId Middleware                 │
│  (set/create X-Correlation-ID jika belum ada)                  │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│              GATEWAY - ApiLogging Middleware                    │
│  (log "incoming_request" dengan context)                       │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│              GATEWAY - ApiGatewayController                     │
│  (forward request ke User Service / Club Service)              │
│  (dengan Authorization & X-Correlation-ID headers)             │
└──────────────────────┬──────────────────────────────────────────┘
                       │
          ┌────────────┼────────────┐
          │            │            │
          ▼            ▼            ▼
    ┌─────────┐  ┌─────────┐  ┌─────────┐
    │  User   │  │  Club   │  │ Other   │
    │Service  │  │Service  │  │Services │
    └─────────┘  └─────────┘  └─────────┘
          │            │            │
          └────────────┼────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│              GATEWAY - ApiGatewayController                     │
│  (wrap response dalam format standar)                          │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│              GATEWAY - ResponseWrapper Middleware               │
│  (format JSON: { success, message, data })                     │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│              GATEWAY - ApiLogging Middleware                    │
│  (log "outgoing_response" dengan status & response)            │
└──────────────────────┬──────────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                          CLIENT                                  │
│  (terima response dalam format standar)                         │
└─────────────────────────────────────────────────────────────────┘
```

---

## 9. ENVIRONMENT VARIABLES (`.env`)

**Tambahkan atau pastikan ada di file `.env` Gateway:**

```
# Logging
LOG_CHANNEL=gateway
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Microservice Base URLs
USER_SERVICE_BASEURL=http://127.0.0.1:8001
CLUB_SERVICE_BASEURL=http://127.0.0.1:8002
```

**Penjelasan:**
- `LOG_CHANNEL=gateway` → Default channel untuk logging adalah "gateway"
- `USER_SERVICE_BASEURL` → Alamat User Service (tanpa `/api`, akan ditambah otomatis)
- `CLUB_SERVICE_BASEURL` → Alamat Club Service (tanpa `/api`, akan ditambah otomatis)

---

## 10. UNIT TEST

**File:** `tests/Feature/OrchestrationTest.php`

**Test yang dibuat:**
```php
public function test_gateway_forwards_headers_and_returns_wrapped_response()
{
    // Setup: Mock User Service response
    Http::fake([
        '*/api/users' => Http::response(['users' => [['id' => 1, 'name' => 'Alice']]], 200),
    ]);

    // Action: Kirim request dengan headers
    $response = $this->withHeaders([
        'Authorization' => 'Bearer testtoken',
        'X-Correlation-ID' => 'test-cid-123',
    ])->getJson('/api/users');

    // Assertion: Verifikasi response
    $response->assertStatus(200);
    $response->assertJsonStructure(['success', 'message', 'data']);
    $this->assertTrue($response->json('success'));
}
```

**Yang ditest:**
1. Gateway dapat forwarding headers (Authorization & X-Correlation-ID)
2. Response di-wrap dalam format standar (success, message, data)
3. Status code 200 ketika berhasil

---

## 11. CARA MENJALANKAN & TESTING

### Persiapan:

```bash
# 1. Masuk ke folder Gateway
cd Gateway_Orchestrator/gateway

# 2. Bersihkan cache config (penting!)
php artisan config:clear
php artisan cache:clear

# 3. Jalankan server
php artisan serve
```

### Testing dengan Postman/cURL:

**GET /api/users:**
```
GET http://127.0.0.1:8000/api/users
Headers:
  - Authorization: Bearer your-token
  - X-Correlation-ID: test-123
```

**Response:**
```json
{
  "success": true,
  "message": "OK",
  "data": {
    "users": [
      { "id": 1, "name": "Alice" },
      { "id": 2, "name": "Bob" }
    ]
  }
}
```

### Cek Log:

```bash
# Lihat log gateway terbaru (10 baris terakhir)
tail -n 10 storage/logs/gateway.log

# Atau di PowerShell (Windows):
Get-Content storage\logs\gateway.log -Tail 10
```

**Log akan terlihat seperti:**
```json
{"message":"incoming_request","context":{"correlation_id":"test-123","method":"GET","url":"http://127.0.0.1:8000/api/users","ip":"127.0.0.1"},"channel":"gateway","datetime":"2025-12-09T14:30:45.123456+00:00"}
{"message":"outgoing_response","context":{"correlation_id":"test-123","status":200},"channel":"gateway","datetime":"2025-12-09T14:30:45.654321+00:00"}
```

---

## 12. KESIMPULAN TANGGUNG JAWAB

✅ **Setup project Laravel Gateway**
✅ **Membuat routing endpoint Gateway** (CRUD users & clubs)
✅ **Menghubungkan Gateway → User Service** (HTTP request)
✅ **Menghubungkan Gateway → Club Service** (HTTP request)
✅ **Meneruskan Authorization Token** (di header)
✅ **Meneruskan Correlation ID** (di header untuk distributed logging)
✅ **Membuat error handling umum** (wrap semua error dalam format standar)
✅ **Membuat response wrapper** (standarisasi JSON)
✅ **Dokumentasi alur panggilan service** (README di docs/)
✅ **Implementasi logging terdistribusi** dengan channel "gateway"

---

## 13. PENJELASAN SIMPLE UNTUK DOSEN

> **"Gateway adalah seperti resepsionis di hotel. Semua tamu (request) datang ke resepsionis dulu. Resepsionis catat siapa yang datang dengan nomor antrian (Correlation ID), terus arahkan ke kamar yang tepat (User Service / Club Service). Resepsionis juga catat semua tamu yang datang dan yang pergi (ApiLogging). Semua respons dari kamar dibungkus dalam format standar sebelum diberikan ke tamu. Jika ada yang error, resepsionis tangkap dan beri tahu dengan format yang jelas, jadi client tidak bingung."**

---

**Created by: Syarah Izzati**
**Date: 2025-12-09**
**Status: ✅ Completed & Merged to Main**
