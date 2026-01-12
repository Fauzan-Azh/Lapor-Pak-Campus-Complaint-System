# 📢 Lapor Pak! - Campus Complaint System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem pelaporan keluhan kampus berbasis web yang memungkinkan mahasiswa untuk melaporkan masalah fasilitas kampus (AC Panas, WiFi Mati, Kursi Patah, dll) dan memungkinkan admin untuk menindaklanjuti dengan cepat.

## 📋 Daftar Isi

- [Latar Belakang](#-latar-belakang)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Cara Menjalankan](#-cara-menjalankan)
- [Struktur Database](#-struktur-database)
- [Akun Default](#-akun-default)
- [Struktur Project](#-struktur-project)
- [Fitur Detail](#-fitur-detail)

## 🎯 Latar Belakang

Fasilitas kampus sering mengalami kerusakan seperti AC panas, WiFi mati, atau kursi patah. Namun, mahasiswa sering bingung harus melaporkan ke mana. Kampus membutuhkan sistem pelaporan terpusat agar bagian Sarana & Prasarana bisa menindaklanjuti keluhan dengan cepat dan efisien.

**Lapor Pak!** adalah solusi berbasis web yang menyediakan platform terpusat untuk:
- Mahasiswa: Melaporkan keluhan dengan mudah, dilengkapi bukti foto
- Admin: Memantau, menindaklanjuti, dan mengelola semua laporan dari satu tempat

## ✨ Fitur Utama

### 1. **Sistem Tiket Pelaporan dengan Upload Foto**
- ✅ Form pelaporan lengkap (Judul, Deskripsi, Lokasi, Kategori)
- ✅ Upload bukti foto (Maksimal 2MB, format JPG/PNG)
- ✅ Validasi file upload menggunakan Storage Facade
- ✅ Symlink untuk akses file publik

### 2. **Kategori Divisi**
- ✅ Sistem kategori untuk membedakan divisi penanggung jawab
- ✅ Kategori default: IT & Jaringan, Kebersihan, Fasilitas Kelas, Sarana & Prasarana, Keamanan
- ✅ Data kategori diisi menggunakan Database Seeding

### 3. **Status Workflow**
- ✅ Tiga status: **Pending** (Merah), **In Progress** (Kuning), **Resolved** (Hijau)
- ✅ Badge warna berbeda untuk setiap status
- ✅ Status default: Pending
- ✅ Tiket tidak bisa dihapus, hanya status yang berubah

### 4. **Sistem Komentar/Diskusi**
- ✅ Nested comments pada setiap tiket
- ✅ Admin bisa bertanya klarifikasi
- ✅ Mahasiswa bisa membalas komentar
- ✅ Menampilkan nama user dan timestamp

### 5. **Role-Based Access Control (RBAC)**
- ✅ Dua level akses: **Admin** dan **User**
- ✅ **User Biasa**: Hanya melihat tiket miliknya sendiri
- ✅ **Admin**: Bisa melihat semua tiket, mengubah status, dan berkomentar
- ✅ Middleware untuk proteksi route
- ✅ Policy-based authorization

### 6. **Authentication System**
- ✅ Login dan Register
- ✅ Session-based authentication
- ✅ Remember me functionality
- ✅ Password hashing dengan bcrypt

### 7. **Filter & Pencarian**
- ✅ Filter berdasarkan status (Pending, In Progress, Resolved)
- ✅ Filter berdasarkan kategori divisi
- ✅ Pagination untuk daftar tiket

## 🛠 Teknologi yang Digunakan

- **Framework**: Laravel 12.x
- **Bahasa**: PHP 8.2+
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Frontend**: 
  - Bootstrap 5.3.0
  - Bootstrap Icons
  - Blade Templating Engine
- **Storage**: Laravel Storage Facade dengan Public Disk
- **Authentication**: Laravel Session-based Auth

## 📦 Persyaratan Sistem

- PHP >= 8.2
- Composer
- SQLite (sudah termasuk) atau MySQL/PostgreSQL
- Web Server (Apache/Nginx) atau PHP Built-in Server
- Extension PHP:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath

## 🚀 Instalasi

### 1. Clone Repository (jika dari Git)
```bash
git clone <repository-url>
cd LASTTHT
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database
```bash
# Untuk SQLite (default)
php artisan migrate:fresh --seed

# Untuk MySQL/PostgreSQL, edit .env terlebih dahulu
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Create Storage Link
```bash
php artisan storage:link
```

### 6. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## ▶️ Cara Menjalankan

### Opsi 1: Menggunakan Laragon (Recommended untuk Windows)
1. Pastikan Laragon sudah running
2. Buka browser dan akses:
   - `http://lasttht.test` atau
   - `http://localhost/lasttht/public`

### Opsi 2: Menggunakan PHP Artisan Serve
```bash
php artisan serve
```
Kemudian buka browser: **http://localhost:8000**

### Opsi 3: Menggunakan XAMPP/WAMP
1. Copy folder project ke `htdocs` atau `www`
2. Akses melalui: `http://localhost/LASTTHT/public`

## 🔐 Akun Default

Setelah menjalankan seeder, tersedia akun default:

### Admin
- **Email**: `admin@example.com`
- **Password**: `password`
- **Hak Akses**: 
  - Melihat semua tiket
  - Mengubah status tiket
  - Berkomentar di semua tiket

### User Biasa
- **Email**: `user@example.com`
- **Password**: `password`
- **Hak Akses**: 
  - Melihat tiket miliknya saja
  - Membuat tiket baru
  - Berkomentar di tiket miliknya

## 🗄 Struktur Database

### Tabel `users`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Nama user |
| email | string | Email (unique) |
| password | string | Password (hashed) |
| is_admin | boolean | Status admin (default: false) |
| timestamps | timestamp | created_at, updated_at |

### Tabel `categories`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Nama kategori |
| timestamps | timestamp | created_at, updated_at |

**Kategori Default:**
- IT & Jaringan
- Kebersihan
- Fasilitas Kelas
- Sarana & Prasarana
- Keamanan

### Tabel `tickets`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key ke users |
| category_id | bigint | Foreign key ke categories |
| title | string | Judul keluhan |
| description | text | Deskripsi detail |
| location | string | Lokasi keluhan |
| image_path | string (nullable) | Path gambar bukti |
| status | enum | pending, in_progress, resolved (default: pending) |
| timestamps | timestamp | created_at, updated_at |

### Tabel `comments`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| ticket_id | bigint | Foreign key ke tickets |
| user_id | bigint | Foreign key ke users |
| message | text | Isi komentar |
| timestamps | timestamp | created_at, updated_at |

### Relasi Database
```
users
  ├── hasMany tickets
  └── hasMany comments

categories
  └── hasMany tickets

tickets
  ├── belongsTo user
  ├── belongsTo category
  └── hasMany comments

comments
  ├── belongsTo ticket
  └── belongsTo user
```

## 📁 Struktur Project

```
LASTTHT/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Login, Register, Logout
│   │   │   ├── TicketController.php     # CRUD Tickets
│   │   │   └── CommentController.php    # Comments Management
│   │   └── Middleware/
│   │       └── AdminMiddleware.php      # Admin Access Control
│   └── Models/
│       ├── User.php                     # User Model dengan relasi
│       ├── Category.php                 # Category Model
│       ├── Ticket.php                   # Ticket Model dengan accessor
│       └── Comment.php                  # Comment Model
├── database/
│   ├── migrations/                      # Database migrations
│   ├── seeders/
│   │   ├── CategorySeeder.php          # Seed categories
│   │   └── DatabaseSeeder.php          # Main seeder
│   └── database.sqlite                  # SQLite database
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Master layout
│       ├── auth/
│       │   ├── login.blade.php         # Login page
│       │   └── register.blade.php      # Register page
│       └── tickets/
│           ├── index.blade.php         # List tickets
│           ├── create.blade.php        # Create ticket form
│           └── show.blade.php          # Ticket detail
├── routes/
│   └── web.php                         # Web routes
├── storage/
│   └── app/
│       └── public/
│           └── ticket-images/          # Uploaded images
└── public/
    └── storage -> ../storage/app/public # Storage symlink
```

## 🎨 Fitur Detail

### 1. Membuat Tiket Baru
- Form lengkap dengan validasi
- Upload foto bukti (maksimal 2MB, JPG/PNG)
- Preview gambar sebelum upload
- Pilih kategori divisi yang tepat
- Validasi lokasi dan deskripsi

### 2. Daftar Tiket
- Tampilan card untuk setiap tiket
- Badge status berwarna (Merah/Kuning/Hijau)
- Filter berdasarkan status dan kategori
- Pagination (10 tiket per halaman)
- User hanya melihat tiket miliknya
- Admin melihat semua tiket

### 3. Detail Tiket
- Informasi lengkap tiket
- Tampilan foto bukti (jika ada)
- Daftar komentar dengan timestamp
- Form tambah komentar
- Admin dapat mengubah status

### 4. Sistem Komentar
- Komentar nested (tidak ada reply, hanya flat)
- Menampilkan nama user dan waktu
- Badge "Admin" untuk admin
- Validasi panjang komentar (max 1000 karakter)

### 5. Manajemen Status (Admin Only)
- Dropdown untuk mengubah status
- Tiga status: Pending, In Progress, Resolved
- Visual feedback dengan badge warna
- Update status tanpa refresh halaman (dengan redirect)

### 6. File Upload
- Menggunakan Laravel Storage Facade
- File disimpan di `storage/app/public/ticket-images`
- Symlink untuk akses publik
- Validasi ukuran (max 2MB) dan format (JPG/PNG)
- Nama file auto-generated

## 🔒 Security Features

- ✅ Password hashing dengan bcrypt
- ✅ CSRF protection pada semua form
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Authorization checks (Middleware & Policy)
- ✅ File upload validation
- ✅ Session-based authentication

## 📝 Routes Available

### Public Routes
- `GET /` - Redirect ke login atau dashboard
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `GET /register` - Halaman register
- `POST /register` - Proses register

### Authenticated Routes
- `POST /logout` - Logout
- `GET /tickets` - Daftar tiket
- `GET /tickets/create` - Form buat tiket
- `POST /tickets` - Simpan tiket baru
- `GET /tickets/{id}` - Detail tiket
- `POST /tickets/{id}/status` - Update status (Admin only)
- `POST /tickets/{id}/comments` - Tambah komentar

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run dengan coverage
php artisan test --coverage
```

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Credits

Dibuat sebagai **Take Home Task** untuk Praktikum Pemrograman Web.

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

---

**Dibuat dengan ❤️ menggunakan Laravel Framework**
