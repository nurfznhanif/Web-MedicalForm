-- MEDICAL FORM SYSTEM DATABASE SETUP

-- 1. CREATE TABLE USERS
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. CREATE TABLE REGISTRASI (sudah ada di sistem)
CREATE TABLE IF NOT EXISTS registrasi (
    id_registrasi SERIAL PRIMARY KEY,
    no_registrasi VARCHAR(64) UNIQUE,
    no_rekam_medis VARCHAR(64),
    nama_pasien VARCHAR(255) NOT NULL,
    tanggal_lahir DATE,
    nik VARCHAR(64),
    create_by INTEGER,
    create_time_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_by INTEGER,
    update_time_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. CREATE TABLE DATA_FORM (sudah ada di sistem)
CREATE TABLE IF NOT EXISTS data_form (
    id_form_data SERIAL PRIMARY KEY,
    id_form INTEGER,
    id_registrasi INTEGER REFERENCES registrasi(id_registrasi),
    data JSONB,
    is_delete BOOLEAN DEFAULT FALSE,
    create_by INTEGER,
    update_by INTEGER,
    create_time_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_time_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. INSERT USER DEFAULT
INSERT INTO users (username, password, full_name) VALUES 
('admin', 'admin123', 'Administrator')
ON CONFLICT (username) DO NOTHING;

-- 5. INSERT SAMPLE DATA REGISTRASI
INSERT INTO registrasi (no_registrasi, no_rekam_medis, nama_pasien, tanggal_lahir, nik) VALUES 
('REG20241201001', 'RM24001', 'NURFAUZAN HANIF', '2003-07-19', '1234567890123456'),
('REG20241201002', 'RM24002', 'BUDI SANTOSO', '1985-08-22', '2345678901234567'),
('REG20241201003', 'RM24003', 'DEWI SARTIKA', '1992-12-10', '3456789012345678')
ON CONFLICT (no_registrasi) DO NOTHING;

-- 6. CEK DATA USERS
SELECT 'USERS TABLE:' as info;
SELECT * FROM users;

-- 7. CEK DATA REGISTRASI
SELECT 'REGISTRASI TABLE:' as info;
SELECT * FROM registrasi;

-- 8. CEK DATA FORM
SELECT 'DATA_FORM TABLE:' as info;
SELECT * FROM data_form;

-- 9. CREATE INDEXES UNTUK PERFORMANCE
CREATE INDEX IF NOT EXISTS idx_registrasi_no_registrasi ON registrasi(no_registrasi);
CREATE INDEX IF NOT EXISTS idx_registrasi_no_rekam_medis ON registrasi(no_rekam_medis);
CREATE INDEX IF NOT EXISTS idx_registrasi_nik ON registrasi(nik);
CREATE INDEX IF NOT EXISTS idx_data_form_id_registrasi ON data_form(id_registrasi);
CREATE INDEX IF NOT EXISTS idx_data_form_create_time ON data_form(create_time_at);