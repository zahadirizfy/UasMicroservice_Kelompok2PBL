# Club Service

Microservice untuk mengelola data klub sepak bola - Kelompok 2 PBL UAS Arsitektur.

## Fitur

- ✅ CRUD Club (Create, Read, Update, Delete)
- ✅ Validasi Input & Error Handling
- ✅ Middleware Correlation ID
- ✅ JSON Logging dengan correlation_id
- ✅ Unit Test
- ✅ Dokumentasi API untuk Gateway

## Requirements

- PHP >= 8.2
- Composer
- SQLite / MySQL / PostgreSQL

## Installation

1. **Clone dan masuk ke direktori project:**
```bash
cd Club_Service/club_service
```

2. **Install dependencies:**
```bash
composer install
```

3. **Setup environment:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Buat database SQLite (jika menggunakan SQLite):**
```bash
# Windows
type nul > database/database.sqlite

# Linux/Mac
touch database/database.sqlite
```

5. **Jalankan migrasi:**
```bash
php artisan migrate
```

6. **Seed data (opsional):**
```bash
php artisan db:seed
```

## Running the Service

```bash
# Development (port 8001)
php artisan serve --port=8001

# Atau gunakan composer script
composer dev
```

Service akan berjalan di: `http://localhost:8001`

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/health | Health check |
| GET | /api/clubs | Get all clubs |
| POST | /api/clubs | Create new club |
| GET | /api/clubs/{id} | Get club by ID |
| PUT | /api/clubs/{id} | Update club |
| DELETE | /api/clubs/{id} | Delete club |

Dokumentasi lengkap: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

## Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=ClubServiceTest

# Run with coverage
php artisan test --coverage
```

## Project Structure

```
club_service/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── ClubController.php      # CRUD Controller
│   │   └── Middleware/
│   │       └── CorrelationIdMiddleware.php
│   ├── Models/
│   │   └── Club.php                    # Club Model
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php                         # Middleware registration
├── config/
│   ├── app.php
│   ├── database.php
│   └── logging.php                     # JSON logging config
├── database/
│   ├── factories/
│   │   └── ClubFactory.php
│   ├── migrations/
│   │   └── 2025_12_09_000001_create_clubs_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── routes/
│   └── api.php                         # API routes
├── storage/
│   └── logs/
│       └── club-service.log            # JSON logs
├── tests/
│   └── Feature/
│       └── ClubServiceTest.php         # Unit tests
├── API_DOCUMENTATION.md                # API docs for Gateway
├── composer.json
└── README.md
```

## Logging

Log disimpan dalam format JSON di `storage/logs/club-service.log`:

```json
{
  "message": "[ClubService] POST /clubs called",
  "context": {
    "correlation_id": "550e8400-e29b-41d4-a716-446655440000",
    "service": "club-service"
  },
  "level_name": "INFO",
  "datetime": "2025-12-09T10:00:00.000000+07:00"
}
```

## Correlation ID

Service mendukung tracking request menggunakan `X-Correlation-ID` header:

- Jika header `X-Correlation-ID` ada di request, nilainya akan diteruskan
- Jika tidak ada, service akan generate UUID baru
- Correlation ID disertakan di semua log entries

## Environment Variables

```env
APP_NAME="Club Service"
APP_URL=http://localhost:8001
LOG_CHANNEL=json
DB_CONNECTION=sqlite
```

## Gateway Integration

Untuk integrasi dengan Gateway/Orchestrator:

1. Base URL: `http://localhost:8001`
2. Health Check: `GET /api/health`
3. Semua endpoint menggunakan prefix `/api/clubs`

Lihat [API_DOCUMENTATION.md](API_DOCUMENTATION.md) untuk konfigurasi routing gateway.

## Author

Kelompok 2 PBL - UAS Microservice Architecture

