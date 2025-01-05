# Sistem Pendaftaran Beasiswa

Aplikasi web untuk pendaftaran beasiswa dengan fitur validasi IPK dan upload berkas.

## Instalasi
1. Clone repository ke htdocs
2. Import db_beasiswa.sql 
3. Setting koneksi di config/db.php
4. Akses via http://localhost/beasiswa

## Struktur Folder
```
beasiswa/
├── assets/        # File statis (CSS, JavaScript, gambar)
│   ├── css/       # File CSS
│   ├── js/        # File JavaScript
│   └── images/    # Gambar (logo, ikon, dll.)
├── config/        # File konfigurasi (database, dll.)
├── uploads/       # Direktori penyimpanan file yang diunggah
├── db_beasiswa.sql # File database
└── *.php          # File sumber utama (index.php, daftar.php, dll.)

```

## Requirements
- PHP 7.4+
- MySQL 5.7+
- XAMPP