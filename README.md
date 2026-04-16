# 🧺 Nugraha Laundry Management System

**Nugraha Laundry** adalah aplikasi manajemen operasional laundry berbasis web yang dirancang untuk memudahkan pemilik laundry dalam mengelola transaksi, data pelanggan, hingga laporan keuangan secara *real-time* dan modern.

---

## ✨ Fitur Utama
Aplikasi ini dilengkapi dengan fitur-fitur mutakhir untuk mendukung efisiensi kerja:

* **Dashboard Interaktif**: Visualisasi data transaksi harian dan statistik pelanggan menggunakan **Chart.js**.
* **WhatsApp Notification**: Kirim notifikasi otomatis kepada pelanggan saat cucian selesai tanpa perlu mengetik manual.
* **Nota & Barcode System**: Cetak struk belanja yang dilengkapi dengan **Barcode (CODE128)** untuk pelacakan cucian yang lebih mudah.
* **Manajemen Pelanggan**: Database pelanggan yang rapi dengan integrasi fitur *Click-to-Chat* WhatsApp.
* **Laporan Laba/Rugi**: Analisis data pemasukan berdasarkan rentang waktu tertentu.
* **Modern UI/UX**: Tampilan bersih dan responsif menggunakan **Bootstrap 5** dan **Plus Jakarta Sans** font.
* **Multi-Role Access**: Hak akses berbeda untuk Admin dan Owner.

---

## 🛠️ Teknologi yang Digunakan
* **Bahasa Pemrograman**: PHP 8.x
* **Database**: MySQL / MariaDB
* **Frontend**: HTML5, CSS3, JavaScript (ES6+)
* **Framework CSS**: Bootstrap 5.3.3
* **Library JS**:
    * jQuery 3.7.1
    * Chart.js (Grafik)
    * SweetAlert2 (Notifikasi Pop-up)
    * JsBarcode (Generasi Barcode)
    * DataTables (Manajemen Tabel)

---

## 🚀 Cara Instalasi

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/nugraha_laundry.git](https://github.com/username/nugraha_laundry.git)
    ```
2.  **Pindahkan ke Web Server**
    Pindahkan folder project ke `C:\xampp\htdocs\` (XAMPP) atau `/var/www/html/` (Linux).
3.  **Import Database**
    * Buka `phpMyAdmin`.
    * Buat database baru dengan nama `nugraha_laundry`.
    * Import file `.sql` yang tersedia di folder `database/`.
4.  **Konfigurasi Koneksi**
    Buka file `config.php` (atau file koneksi Aa) dan sesuaikan `username` serta `password` database Anda.
5.  **Jalankan Aplikasi**
    Buka browser dan akses `http://localhost/nugraha_laundry`.
---

## 👨‍💻 Kontributor
* **Muhammad Fakhri Alfarisi** - *Lead Developer* - [@farisifakhri](https://github.com/farisifakhri)

---

## 📝 Lisensi
Project ini dibuat untuk tujuan pembelajaran dan pengembangan keterampilan di bidang Teknik Informatika UIN Syarif Hidayatullah Jakarta.
