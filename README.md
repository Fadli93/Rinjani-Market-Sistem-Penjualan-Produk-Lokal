# Rinjani Market - Sistem Penjualan Produk Lokal 🛍️

Aplikasi *e-commerce* berbasis web yang dibangun dengan PHP Native (Konsep MVC) untuk memfasilitasi penjualan produk lokal (kerajinan, tenun, dll) secara online. Aplikasi ini dirancang untuk membantu UMKM memasarkan produk mereka dengan fitur transaksi yang lengkap dan mudah digunakan.

## 🚀 Fitur Unggulan

### 👨‍💼 Panel Admin
- **Dashboard**: Statistik ringkasan penjualan, jumlah produk, dan pesanan masuk.
- **Manajemen Produk & Kategori**: Tambah, edit, hapus produk beserta gambar dan deskripsi.
- **Kelola Pesanan**: Memproses pesanan masuk (Update status: Pending, Proses, Dikirim, Selesai).
- **Laporan Penjualan**: Rekapitulasi transaksi untuk analisis bisnis.
- **Manajemen Pengguna**: Mengelola data pelanggan terdaftar.

### 👤 Pelanggan (Customer)
- **Katalog Produk**: Menjelajahi produk berdasarkan kategori.
- **Keranjang Belanja**: Menambahkan produk ke cart sebelum checkout.
- **Checkout System**: Proses pemesanan dengan input alamat pengiriman.
- **Manajemen Profil**: Mengelola data diri, alamat, dan ganti password.
- **Riwayat Pesanan**: Melacak status pesanan yang telah dibuat.

## 🛠️ Teknologi yang Digunakan
- **Bahasa Pemrograman**: PHP 8+ (Custom MVC Architecture)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 (Custom/Bootstrap), JavaScript
- **Server**: Apache / PHP Built-in Server

## 💻 Cara Instalasi & Menjalankan

### Persiapan Database
1. Pastikan **XAMPP** sudah terinstall dan MySQL berjalan.
2. Buat database baru di phpMyAdmin dengan nama `db_penjualan_lokal`.
3. Import file `db_penjualan_lokal.sql` yang ada di folder root proyek.

### Konfigurasi (Opsional)
Jika password database MySQL Anda bukan kosong, edit file `app/config/config.php`:
```php
define('DB_PASS', 'password_anda');
```

### Menjalankan Aplikasi
**Cara Otomatis (Windows):**
Klik 2x file `JALANKAN_APLIKASI.bat`.

**Cara Manual (Terminal):**
```bash
php -S localhost:8080 -t public
```
Lalu buka browser ke `http://localhost:8080`.

## 🔐 Akun Demo

| Role | Username | Password |
|------|----------|----------|
| **Admin** | `admin` | `admin123` |
| **Pelanggan** | `fadli123` | `fadli1212` |

---
*Dikembangkan untuk mendukung produk lokal Indonesia.* 🇮🇩
