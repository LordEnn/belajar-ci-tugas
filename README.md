# TokoApp – Aplikasi Kasir & Web Service (CodeIgniter 4)

TokoApp adalah aplikasi berbasis CodeIgniter 4 yang digunakan untuk mengelola produk, kategori, diskon harian, keranjang belanja, transaksi, serta menyediakan API untuk integrasi dashboard monitoring. Aplikasi ini dibangun untuk mendemonstrasikan implementasi backend web development dan konsumsi web service secara praktis.

## 1. Fitur

### Manajemen Produk
- Tambah, ubah, hapus produk
- Upload foto produk
- Pengelompokan berdasarkan kategori

### Manajemen Kategori
- Tambah, ubah, hapus kategori produk

### Diskon Harian
- Admin dapat menambahkan diskon untuk tanggal tertentu
- Validasi agar tidak bisa menambahkan lebih dari satu diskon di tanggal yang sama
- Diskon langsung mengurangi harga saat:
  - Produk dimasukkan ke keranjang
  - Produk disimpan sebagai detail transaksi

### Role-Based Access
- Admin memiliki akses penuh ke fitur diskon
- User hanya dapat melihat dan belanja produk

### Keranjang Belanja
- Menambahkan, mengubah, menghapus produk
- Harga otomatis terpengaruh oleh diskon aktif

### Checkout
- Input alamat dan pencarian kelurahan menggunakan Select2 + API RajaOngkir
- Memilih layanan ekspedisi dan menghitung ongkir otomatis
- Menyimpan transaksi ke database

### Web Service (API)
- Endpoint: /api
- Protected by API key
- Menyediakan data transaksi beserta detail pembelian

### Dashboard Monitoring (Frontend terpisah)
- Mengambil dan menampilkan data dari API
- Menampilkan jumlah item yang dibeli per transaksi
- Dilengkapi jam real-time

## 2. Instalasi

### Langkah-langkah

1. Clone repositori:

   bash
   git clone https://github.com/roroyyan/belajar-ci-tugas.git
   cd belajar-ci-tugas
   

2. Install dependency:

   bash
   composer install
   

3. Konfigurasi file .env:

   
   app.baseURL = 'http://localhost:8080/'
   database.default.hostname = localhost
   database.default.database = dbci4
   database.default.username = root
   database.default.password = 
   

4. Import database:

   - Buka phpMyAdmin
   - Import file db_ci4.sql

5. Jalankan aplikasi:

   bash
   php spark serve
   

   Akses di: http://localhost:8080

6. Menjalankan Dashboard Monitoring:

   - Salin file dashboard.html ke dalam folder public/
   - Jalankan aplikasi toko seperti biasa
   - Akses dashboard: http://localhost:8080/dashboard.html

## 3. Struktur Proyek

| Folder/File              | Keterangan                                              |
|--------------------------|----------------------------------------------------------|
| app/Controllers        | Logic aplikasi (produk, diskon, transaksi, web API)     |
| app/Models             | Query builder untuk interaksi database                  |
| app/Views              | Tampilan HTML (produk, keranjang, diskon, checkout)     |
| public/                | Aset publik: Bootstrap, gambar, dan file dashboard      |
| app/Config/Routes.php  | Routing endpoint aplikasi                               |
| .env                   | Konfigurasi koneksi database dan baseURL                |
| README.md              | Dokumentasi proyek ini                                  |

## 4. Dokumentasi Web Service

- Endpoint: GET /api
- Headers:
  - Content-Type: application/x-www-form-urlencoded
  - key: random123678abcghi
- Response format:

  json
  {
    "status": "success",
    "results": [
      {
        "id": 1,
        "username": "royyan",
        "alamat": "Jl. Melati",
        "total_harga": "155000",
        "ongkir": "10000",
        "status": 0,
        "created_at": "2025-07-04 22:45:10",
        "details": [
          {
            "product_id": 2,
            "jumlah": 1,
            "diskon": 2000,
            "subtotal_harga": 49000
          }
        ]
      }
    ]
  }
  

## 5. Pengembang

Nama: Royyan Firdaus
GitHub: [github.com/LordEnn](https://github.com/LordEnn)  
Repository: [belajar-ci-tugas](https://github.com/LordEnn/belajar-ci-tugas)  
Framework: CodeIgniter 4  
Bahasa: PHP 8.1  
Tugas Uas PWL