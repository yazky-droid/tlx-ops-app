# 🚀 TLX Ops System - Shipment & Invoicing Management

Proyek ini adalah pemenuhan test programming dengan menampilkan demonstrasi sistem manajemen operasional TLX, dibangun menggunakan **Laravel 12** dan **Filament PHP v3**.

Fokus utama adalah pada asumsi fitur untuk tim operasional, otomatisasi flow operasional, dan penyediaan **API** salah satu Resource yang aman.

---

## 🛠️ Fitur Teknis Utama

### 1. Model & Data Integrity

* **Eloquent Observer:** Menggunakan `ShipmentTrackingObserver` untuk **memperbarui status kiriman secara real-time** pada tabel `shipments` setiap kali *log tracking* baru ditambahkan.

* **Model Events:** Nomor Referensi / Resi dan Nomor Invoice dibuat secara **otomatis dan unik** di *layer Model* (`reference_no` dan `invoice_number`).

### 2. User Interface (Filament)

* **Dashboard Vital:** Menampilkan statistik operasional utama (*Total Kiriman*, *Dalam Proses*, *Invoice Pending*) secara *real-time*.

* **Menu:** Menampilkan Client, Shipment dan Invoice (*pengirim dan penerima*, *data pengiriman*, *data invoice*).

* **Aksi Kontekstual:** Tombol **"Buat Invoice"** di halaman *Edit Shipment* hanya muncul jika *invoice* terkait belum ada, dan akan mengisi `shipment_id` secara otomatis.

### 3. API Gateway

* **Laravel Sanctum:** Digunakan untuk autentikasi *Personal Access Token* yang aman.

* **CRUD Penuh:** Menyediakan *endpoint* **CRUD** (Create, Read, Update, Delete) untuk *resource* **Shipment**.

---

## 💻 Panduan Instalasi & Setup

Ikuti langkah-langkah berikut untuk mengkloning dan menjalankan proyek menggunakan **MySQL** sebagai *database*.

### Persyaratan Sistem

* PHP 8.2+
* Composer
* MySQL

### Langkah Setup

1.  **Clone Repositori:**

    ```bash
    git clone https://github.com/yazky-droid/tlx-ops-app.git
    cd tlx-ops-app
    ```

2.  **Instal Dependensi:**

    ```bash
    composer install
    ```

3.  **Konfigurasi Environment:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    *(Pastikan konfigurasi `DB_CONNECTION=mysql` dan detail koneksi database sudah diatur di file `.env`)*

4.  **Migrasi Database & Data Seeder:**

    Pilih salah satu opsi di bawah ini untuk menyiapkan akun admin:

    | Pilihan | Command | Deskripsi | 
    | :--- | :--- | :--- |
    | **Opsi A (Disarankan)** | `php artisan migrate --seed` | Menjalankan migrasi, membuat **User Admin**, dan mengisi data dummy (Client, Shipment, Invoice) agar Dashboard terisi secara otomatis. | 
    | **Opsi B (Manual)** | `php artisan migrate` | Hanya menjalankan migrasi. Anda harus membuat akun admin secara manual menggunakan `php artisan make:filament-user`. | 

    Jika memilih **Opsi A**, gunakan kredensial berikut untuk login:

    * **Email:** `admin@tlx-ops.com`
    * **Password:** `password`

    **Langkah Akhir Setup:**

    ```bash
    php artisan optimize:clear
    ```

5.  **Jalankan Server:**

    ```bash
    php artisan serve
    ```

    Akses Panel Admin di: `http://127.0.0.1:8000/admin`

---

## 🌐 Panduan Pengujian API

API ini memerlukan **Bearer Token** yang diperoleh melalui proses login.

### 1. Mendapatkan Access Token (Login)

Token diperlukan untuk mengakses semua *endpoint* Kiriman.

* **URL:** `http://127.0.0.1:8000/api/login`

* **Method:** `POST`

* **Body (JSON):** Gunakan kredensial Admin.

    ```json
    {
        "email": "admin@tlx-ops.com",
        "password": "password"
    }
    ```

* **Action:** Salin nilai `access_token` dari respons.

### 2. Pengujian CRUD Shipment

Gunakan *token* yang didapat di Langkah 1 sebagai *Header* `Authorization: Bearer <TOKEN>` untuk semua *request* berikut.

* **Endpoint Dasar:** `/api/v1/shipments`

* **Methods yang Didukung:**

    * `GET /api/admin/shipments` (List Semua)
    * `GET /api/admin/shipments/{id}` (Detail Pengiriman)
    * `POST /api/admin/shipments` (Buat Pengiriman Baru)
    * `PUT /api/admin/shipments/{id}` (Update Pengiriman)
    * `DELETE /api/admin/shipments/{id}` (Hapus Pengiriman)

### 🔗 Dokumentasi Postman

Untuk pengujian API yang terstruktur dan siap pakai, silakan impor *Collection* Postman berikut:

* **[API DOCS](https://documenter.getpostman.com/view/18351570/2sB3QJPqqv)**