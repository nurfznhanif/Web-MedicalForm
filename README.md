# Medical Form System

> **Sistem Pengkajian Keperawatan Poliklinik Kebidanan**  
> Developed by PT BIGS Integrasi Teknologi

## 📋 Deskripsi Project

Medical Form System adalah aplikasi web untuk mengelola pengkajian keperawatan di poliklinik kebidanan. Sistem ini memungkinkan perawat untuk:

- 📝 Melakukan registrasi pasien
- 🏥 Mengisi form pengkajian keperawatan
- 📊 Menghitung BMI dan risk assessment otomatis
- 🖨️ Mencetak form hasil pengkajian
- 📁 Mengelola data pasien dan riwayat medis

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 8.2, Yii2 Framework
- **Database**: PostgreSQL 16
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Server**: Apache/Nginx
- **Package Manager**: Composer


## 🚀 Instalasi

### Prerequisites

- PHP 8.2+
- PostgreSQL 16
- Composer
- Apache/Nginx

### Langkah Instalasi

1. **Clone atau Download Project**
   ```bash
   git clone https://github.com/nurfznhanif/Web-MedicalForm.git
   cd Web-MedicalForm
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi Database**
   Edit file `config/db.php`:
   ```php
   return [
       'class' => 'yii\db\Connection',
       'dsn' => 'pgsql:host=localhost;port=5432;dbname=medical_form_db',
       'username' => 'Sesuaikan',
       'password' => 'Sesuaikan',
       'charset' => 'utf8',
   ];
   ```
4. **Run Migration**
   ```bash
   ./yii migrate
   ```

5. **Set Permissions**
   ```bash
   chmod 755 runtime web/assets
   chmod -R 777 runtime web/assets
   ```

6. **Testing**
   ```bash
   # Built-in server
   php yii serve --port=8080
   
   # Akses: http://localhost:8080
   ```

## 📊 Database Schema

### Table: registrasi
| Field | Type | Description |
|-------|------|-------------|
| id_registrasi | BIGSERIAL | Primary key |
| no_registrasi | BIGINT | Nomor registrasi |
| no_rekam_medis | BIGINT | Nomor rekam medis |
| nama_pasien | VARCHAR(255) | Nama pasien |
| tanggal_lahir | DATE | Tanggal lahir |
| nik | BIGINT | NIK pasien |

### Table: data_form
| Field | Type | Description |
|-------|------|-------------|
| id_form_data | BIGSERIAL | Primary key |
| id_form | BIGINT | Form ID |
| id_registrasi | BIGINT | Foreign key |
| data | JSON | Form data |
| is_delete | BOOLEAN | Soft delete flag |

**© 2025 Nurfauzan Hanif. All rights reserved.**