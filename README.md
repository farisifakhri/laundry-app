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

### Core System
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=F7DF1E)

### Frontend & Styling
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)

### Library & Tools
![jQuery](https://img.shields.io/badge/jquery-%230769AD.svg?style=for-the-badge&logo=jquery&logoColor=white)
![Chart.js](https://img.shields.io/badge/chart.js-F5788D.svg?style=for-the-badge&logo=chart.js&logoColor=white)
![SweetAlert2](https://img.shields.io/badge/sweetalert2-7367F0.svg?style=for-the-badge&logo=sweetalert2&logoColor=white)

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
