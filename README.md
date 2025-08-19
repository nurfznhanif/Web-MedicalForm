# Medical Form System

> **Sistem Pengkajian Keperawatan Poliklinik Kebidanan**  
> Developed by PT BIGS Integrasi Teknologi

## 📋 Deskripsi Project

Medical Form System adalah aplikasi web untuk mengelola pengkajian keperawatan di poliklinik kebidanan. Sistem ini memungkinkan perawat untuk:

- 📝 Melakukan registrasi pasien
- 🏥 Mengisi form pengkajian keperawatan lengkap
- 📊 Menghitung BMI dan risk assessment otomatis
- 🖨️ Mencetak form hasil pengkajian
- 📁 Mengelola data pasien dan riwayat medis

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 8.2, Yii2 Framework
- **Database**: PostgreSQL 16
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Server**: Apache/Nginx
- **Package Manager**: Composer

## 📁 Struktur Project

```
medical-form-system/
├── assets/              # Asset bundles
├── commands/            # Console commands
├── config/              # Configuration files
├── controllers/         # Controllers
├── migrations/          # Database migrations
├── models/              # Model classes
├── runtime/             # Runtime files
├── views/               # View templates
├── web/                 # Web accessible files
├── widgets/             # Custom widgets
├── composer.json        # Dependencies
└── README.md
```

## 🚀 Instalasi

### Prerequisites

- PHP 8.2+
- PostgreSQL 16
- Composer
- Apache/Nginx

### Langkah Instalasi

1. **Clone atau Download Project**
   ```bash
   git clone https://github.com/pt-bigs/medical-form-system.git
   cd medical-form-system
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Database**
   ```bash
   # Login ke PostgreSQL
   sudo -u postgres psql
   
   # Buat database dan user
   CREATE DATABASE medical_form_db;
   CREATE USER medical_user WITH PASSWORD 'medical_pass123';
   GRANT ALL PRIVILEGES ON DATABASE medical_form_db TO medical_user;
   ```

4. **Konfigurasi Database**
   Edit file `config/db.php`:
   ```php
   return [
       'class' => 'yii\db\Connection',
       'dsn' => 'pgsql:host=localhost;port=5432;dbname=medical_form_db',
       'username' => 'medical_user',
       'password' => 'medical_pass123',
       'charset' => 'utf8',
   ];
   ```

5. **Run Migration**
   ```bash
   ./yii migrate
   ```

6. **Set Permissions**
   ```bash
   chmod 755 runtime web/assets
   chmod -R 777 runtime web/assets
   ```

7. **Setup Web Server**
   Lihat [Installation Guide](installation-guide.md) untuk konfigurasi detail.

8. **Testing**
   ```bash
   # Built-in server
   php yii serve --port=8080
   
   # Akses: http://localhost:8080
   ```

## 💻 Fitur Utama

### 1. Manajemen Registrasi
- ➕ Tambah registrasi pasien baru
- ✏️ Edit data registrasi
- 🗑️ Hapus data registrasi
- 📋 Daftar semua registrasi

### 2. Form Pengkajian Keperawatan
- 🏥 Input data pengkajian lengkap sesuai lampiran
- 📏 Perhitungan BMI otomatis
- ⚠️ Risk assessment dengan scoring
- ✅ Validasi form real-time
- 💾 Auto-save functionality

### 3. Laporan dan Print
- 🖨️ Print form pengkajian
- 📄 Layout print yang sesuai dengan format medis
- 📊 Summary risk assessment

## 📝 Cara Penggunaan

### 1. Tambah Registrasi Pasien
1. Akses menu "Data Registrasi"
2. Klik "Tambah Registrasi"
3. Isi data pasien (nama, NIK, tanggal lahir)
4. Klik "Simpan"

### 2. Input Form Medis
1. Dari daftar registrasi, klik tombol "Input"
2. Isi form pengkajian keperawatan:
   - Data dasar pasien
   - Pemeriksaan fisik
   - Riwayat penyakit
   - Risk assessment
3. BMI akan dihitung otomatis
4. Risk score akan dihitung otomatis
5. Klik "Simpan Data Form"

### 3. Print Form
1. Dari daftar registrasi, klik tombol "Print"
2. Form akan terbuka di tab baru
3. Gunakan Ctrl+P atau klik tombol Print

## 🔧 Konfigurasi

### Database Configuration
```php
// config/db.php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=medical_form_db',
    'username' => 'medical_user',
    'password' => 'medical_pass123',
    'charset' => 'utf8',
];
```

### Web Configuration
```php
// config/web.php
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'registrasi' => 'registrasi/index',
        'registrasi/input-form/<id:\d+>' => 'registrasi/input-form',
        // ... other rules
    ],
],
```

## 🧪 Demo Data

Untuk testing, jalankan script demo data:

```bash
psql -h localhost -U medical_user -d medical_form_db -f demo-data.sql
```

Demo data include:
- 10 registrasi pasien
- 5 form pengkajian dengan berbagai skenario
- Data untuk testing BMI calculation
- Data untuk testing risk assessment

## 🎯 BMI Calculation

Sistem menghitung BMI secara otomatis:

```
BMI = Berat Badan (kg) / (Tinggi Badan (m))²
```

Kategori BMI:
- **< 18.5**: Kurang Berat Badan
- **18.5 - 25.0**: Normal
- **25.0 - 27.0**: Gemuk
- **> 27.0**: Obesitas

## ⚠️ Risk Assessment

Risk assessment menggunakan skoring berdasarkan 6 faktor:

1. Riwayat jatuh (0-25 poin)
2. Diagnosa medis sekunder (0-15 poin)  
3. Alat bantu jalan (0-30 poin)
4. Akses IV/heparin (0-20 poin)
5. Cara berjalan/berpindah (0-20 poin)
6. Status mental (0-15 poin)

**Kategori Risk:**
- **0-24**: Tidak berisiko
- **25-44**: Resiko rendah (intervensi standar)
- **≥45**: Resiko tinggi (intervensi khusus)

## 🔐 Security Features

- ✅ SQL Injection protection
- ✅ XSS protection
- ✅ CSRF protection
- ✅ Input validation
- ✅ File access restrictions
- ✅ Secure headers

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

## 🚨 Troubleshooting

### Common Issues

**Database Connection Error:**
```bash
# Check PostgreSQL service
sudo systemctl status postgresql-16

# Test connection
psql -h localhost -U medical_user -d medical_form_db
```

**Permission Denied:**
```bash
sudo chown -R www-data:www-data /var/www/medical-form-system
sudo chmod -R 777 runtime web/assets
```

**Composer Issues:**
```bash
composer clear-cache
composer install --no-dev --optimize-autoloader
```

## 📞 Support

Jika mengalami masalah:

1. 📋 Check [Installation Guide](installation-guide.md)
2. 📋 Check application logs di `runtime/logs/`
3. 📋 Check web server logs
4. 📋 Verify database connection
5. 📧 Contact: support@ptbigs.com

## 🤝 Contributing

1. Fork project ini
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add some amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📜 License

Distributed under the BSD-3-Clause License. See `LICENSE` for more information.

## 👥 Team

**PT BIGS Integrasi Teknologi**
- 🏢 Website: [www.ptbigs.com](https://www.ptbigs.com)
- 📧 Email: info@ptbigs.com
- 📞 Phone: +62-xxx-xxxx-xxxx

## 🎉 Acknowledgments

- [Yii2 Framework](https://www.yiiframework.com/)
- [Bootstrap](https://getbootstrap.com/)
- [PostgreSQL](https://www.postgresql.org/)
- [Font Awesome](https://fontawesome.com/)

---

**© 2024 PT BIGS Integrasi Teknologi. All rights reserved.**