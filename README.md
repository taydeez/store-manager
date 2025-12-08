# 🏬 Store Manager

A Laravel backend application for managing books and storefronts — designed for scalability, caching, and a fast
Octane runtime.  
Frontend is maintained separately.

---

## ✨ Features

- RESTful API for store management
- Authentication & user management
- Product and inventory operations
- Caching support (Redis or Array)
- Docker support with Laravel Octane for high-performance runtime
- Supports both cloud deployment and local development

---

## 🧱 Tech Stack

- **Laravel**
- **PHP 8+**
- **MySQL / PostgreSQL**
- **Redis** (recommended for caching)
- **Docker + Laravel Octane**
- (Frontend hosted separately)

> ⚠️ If Redis is not configured, caching will fallback to **array**.  
> using a different cache type may bread code as they may not support cache structure.

---

## 📌 Backend (Live Demo URL )

[https://bookstore-api-944567162646.europe-west1.run.app/api]

This is used by the standalone frontend application.

---

## 🚀 Getting Started

### Option A — Run with Docker + Laravel Octane (Recommended)

1️⃣ Clone the repository

```bash
git clone https://github.com/taydeez/store-manager.git
cd store-manager
```

2️⃣ Setup environment

```bash
cp .env.example .env
```

Update .env → database, cache, etc.
If using Redis, set:

```bash
CACHE_DRIVER=redis
```

Else fallback to:

```bash
CACHE_DRIVER=array
```

3️⃣ Build & start containers

```bash
docker-compose up -d --build
```

4️⃣ Inside the container:

```bash
composer install
php artisan key:generate
php artisan migrate --seed   # optional if seed data exists
```

```bash
php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
```

Open:

```bash
http://localhost:8000
```

### Option B — Run Directly with Artisan

```
git clone https://github.com/taydeez/store-manager.git
cd store-manager

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed   # optional
php artisan serve
```

Open:

```
http://localhost:8000
```

## 🔑 Environment Variables

Minimum configuration inside .env:

```bash
APP_ENV=local
APP_KEY=
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

CACHE_DRIVER=redis   # use array if Redis is not available
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

## 🗂 Project Structure (Overview)

```text
app/
├─ Http/
├─ Models/
database/
├─ migrations/
routes/
├─ api.php
```

## 📄 API Docs

API route definitions live in:

[Swagger Docs](https://bookstore-api-944567162646.europe-west1.run.app/docs/api)

📦 Deployment Notes

Octane server must bind to 0.0.0.0 in Docker to be reachable externally

Ensure Redis is available in production to avoid cache failures

Optimize config before deploying:

``` bash
php artisan optimize
```

