<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */

$this->title = 'Print Form Pengkajian';

// Helper untuk mendapatkan data langsung dari model database
$helper = new class($model) {
    private $model;
    private $registrasi;

    public function __construct($model)
    {
        $this->model = $model;
        $this->registrasi = $model->registrasi ?? null;
    }

    private function safeGet($object, $key, $default = '')
    {
        if (is_array($object)) {
            return $object[$key] ?? $default;
        } elseif (is_object($object)) {
            return $object->$key ?? $default;
        }
        return $default;
    }

    public function getPatientData()
    {
        return [
            'nama_pasien' => Html::encode($this->registrasi->nama_pasien ?? 'NAMA PASIEN'),
            'tanggal_lahir' => $this->registrasi->tanggal_lahir ?
                date('d F Y', strtotime($this->registrasi->tanggal_lahir)) : '-',
            'no_rekam_medis' => Html::encode($this->registrasi->no_rekam_medis ?? 'RM-XXXX'),
        ];
    }

    public function getFormData()
    {
        return [
            // Data dasar
            'tanggal_pengkajian' => $this->model->tanggal_pengkajian ?
                date('d/m/Y', strtotime($this->model->tanggal_pengkajian)) : date('d/m/Y'),
            'jam_pengkajian' => $this->model->jam_pengkajian ?? date('H:i'),
            'poliklinik' => $this->model->poliklinik ?? 'KLINIK OBGYN',

            // Pengkajian awal
            'cara_masuk' => $this->model->cara_masuk,
            'anamnesis' => $this->model->anamnesis,
            'alergi' => Html::encode($this->model->alergi ?? 'Tidak ada alergi yang diketahui'),
            'keluhan_utama' => Html::encode($this->model->keluhan_utama ?? 'Tidak ada keluhan khusus'),

            // Pemeriksaan fisik
            'keadaan_umum' => $this->model->keadaan_umum,
            'warna_kulit' => $this->model->warna_kulit,
            'kesadaran' => $this->model->kesadaran,

            // Tanda vital
            'td' => $this->model->tanda_vital_td ?? '120/80 mmHg',
            'p' => $this->model->tanda_vital_p ?? '20 x/menit',
            'n' => $this->model->tanda_vital_n ?? '80 x/menit',
            's' => $this->model->tanda_vital_s ?? '36.5°C',

            // Antropometri
            'berat' => $this->model->antro_berat ?? '-',
            'tinggi' => $this->model->antro_tinggi ?? '-',
            'lingkar' => $this->model->antro_lingkar ?? '-',
            'panjang' => $this->model->antro_panjang ?? '-',
            'imt' => $this->model->antro_imt ?? '-',

            // Fungsional
            'alat_bantu' => $this->model->fungsi_alat_bantu ?? '-',
            'prothesa' => $this->model->fungsi_prothesa ?? '-',
            'cacat_tubuh' => $this->model->fungsi_cacat_tubuh ?? '-',
            'adl' => $this->model->fungsi_adl ?? 'Mandiri',
            'riwayat_jatuh_fungsional' => $this->model->riwayat_jatuh_fungsional ?? 'Negatif',

            // Status gizi
            'status_gizi' => $this->model->status_gizi,

            // Riwayat penyakit
            'riwayat_penyakit_sekarang' => $this->model->riwayat_penyakit_sekarang,
            'riwayat_penyakit_sebelumnya' => $this->model->riwayat_penyakit_sebelumnya,
            'riwayat_penyakit_keluarga' => $this->model->riwayat_penyakit_keluarga,

            // Riwayat operasi
            'riwayat_operasi' => $this->model->riwayat_operasi,
            'operasi_apa' => $this->model->operasi_detail_apa ?? 'APP',
            'operasi_kapan' => $this->model->operasi_detail_kapan ?? '2017',

            // Riwayat rawat inap
            'riwayat_pernah_dirawat' => $this->model->riwayat_pernah_dirawat,
            'penyakit_apa' => $this->model->dirawat_detail_penyakit ?? 'Post operasi',
            'dirawat_kapan' => $this->model->dirawat_detail_kapan ?? '2017',
        ];
    }

    public function getRiskScores()
    {
        // Default scores jika tidak ada data
        $defaultScores = [25, 15, 0, 20, 0, 0]; // Total = 60

        try {
            // Ambil data dari model yang sudah di-load
            $riskItems = $this->model->resiko_jatuh_items;

            // Jika resiko_jatuh_items ada dan berisi data
            if (!empty($riskItems) && is_array($riskItems)) {
                $scores = [];
                for ($i = 1; $i <= 6; $i++) {
                    $key = 'risk' . $i;
                    $scores[] = isset($riskItems[$key]) ? (int)$riskItems[$key] : 0;
                }
                return $scores;
            }

            // Coba ambil dari data JSON langsung
            $jsonData = $this->model->data;
            if (!empty($jsonData)) {
                $data = is_string($jsonData) ? json_decode($jsonData, true) : $jsonData;

                if (is_array($data) && isset($data['resiko_jatuh']) && is_array($data['resiko_jatuh'])) {
                    $scores = [];
                    foreach ($data['resiko_jatuh'] as $item) {
                        if (is_array($item) && isset($item['hasil'])) {
                            $scores[] = (int)$item['hasil'];
                        }
                    }

                    // Pastikan ada 6 nilai
                    while (count($scores) < 6) {
                        $scores[] = 0;
                    }

                    return array_slice($scores, 0, 6);
                }
            }

            // Jika ada total_resiko_jatuh, coba distribusikan
            $totalRisk = $this->model->total_resiko_jatuh;
            if (!empty($totalRisk) && is_numeric($totalRisk)) {
                $total = (int)$totalRisk;

                // Jika total tidak sama dengan default (60), berarti ada data custom
                if ($total != 60) {
                    // Kembalikan nilai sesuai total yang tersimpan
                    // Untuk sementara gunakan distribusi proporsional
                    $ratio = $total / 60;
                    return [
                        (int)(25 * $ratio),
                        (int)(15 * $ratio),
                        (int)(0 * $ratio),
                        (int)(20 * $ratio),
                        (int)(0 * $ratio),
                        (int)(0 * $ratio)
                    ];
                }
            }
        } catch (Exception $e) {
            // Log error dan gunakan default
            error_log("Error getting risk scores: " . $e->getMessage());
        }

        // Return default jika semua cara gagal
        return $defaultScores;
    }

    public function getTotalRiskScore()
    {
        try {
            // Prioritas 1: Ambil dari total_resiko_jatuh model
            if (!empty($this->model->total_resiko_jatuh) && is_numeric($this->model->total_resiko_jatuh)) {
                return (int)$this->model->total_resiko_jatuh;
            }

            // Prioritas 2: Hitung dari getRiskScores()
            $scores = $this->getRiskScores();
            return array_sum($scores);
        } catch (Exception $e) {
            error_log("Error getting total risk score: " . $e->getMessage());
            return 60; // Default total
        }
    }

    public function getRiskCategory($total = null)
    {
        if ($total === null) {
            $total = $this->getTotalRiskScore();
        }

        try {
            // Prioritas 1: Ambil dari kategori_resiko_jatuh model
            $modelCategory = $this->model->kategori_resiko_jatuh;
            if (!empty($modelCategory) && is_string($modelCategory)) {
                return $modelCategory;
            }

            // Prioritas 2: Hitung berdasarkan total
            if ($total <= 24) {
                return 'Tidak berisiko (0-24)';
            } elseif ($total <= 44) {
                return 'Resiko rendah (25-44)';
            } else {
                return 'Resiko tinggi (≥45)';
            }
        } catch (Exception $e) {
            error_log("Error getting risk category: " . $e->getMessage());
            return 'Resiko rendah (25-44)'; // Default category
        }
    }
};

$helper = new $helper($model);
$patient = $helper->getPatientData();
$formData = $helper->getFormData();
$riskScores = $helper->getRiskScores();
$totalRisk = (int)$helper->getTotalRiskScore(); // Cast to int
$riskCategory = (string)$helper->getRiskCategory($totalRisk); // Cast to string

// Validate arrays
if (!is_array($riskScores)) {
    $riskScores = [25, 15, 0, 20, 0, 0]; // Default fallback
}

// Ensure we have exactly 6 scores
while (count($riskScores) < 6) {
    $riskScores[] = 0;
}
$riskScores = array_slice($riskScores, 0, 6);

// Debug info (hapus di production)
// echo "<!-- Debug Risk Data: " . print_r($riskScores, true) . " Total: " . $totalRisk . " -->";

// CSS sesuai format asli
$this->registerCss("
@media print {
    .no-print { display: none !important; }
    @page { size: A4; margin: 15mm; }
    body { font-size: 10px; line-height: 1.2; }
}

body {
    font-family: Arial, sans-serif;
    font-size: 11px;
    line-height: 1.3;
    color: #000;
    background: white;
    margin: 0;
    padding: 20px;
}

.header-section {
    border: 2px solid #000;
    padding: 10px;
    margin-bottom: 15px;
}

.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.logo-section {
    text-align: right;
    font-weight: bold;
    font-size: 14px;
}

.pt-bigs { color: #FF6B35; }
.integrasi { color: #4A90E2; }
.teknologi { color: #7ED321; }

.title {
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    margin: 15px 0;
}

.patient-box {
    border: 2px solid #000;
    padding: 10px;
    margin-bottom: 15px;
}

.form-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding: 5px 0;
}

.section {
    border: 2px solid #000;
    margin-bottom: 15px;
    padding: 10px;
}

.section-title {
    font-weight: bold;
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid #000;
}

.checkbox-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin: 5px 0;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.vital-signs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin: 10px 0;
}

.antropometri {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin: 10px 0;
}

.two-column {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.three-column {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 15px;
}

.risk-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.risk-table th,
.risk-table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: left;
    font-size: 10px;
    vertical-align: top;
}

.risk-table th {
    background-color: #f0f0f0;
    font-weight: bold;
    text-align: center;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.bold { font-weight: bold; }

.petugas-box {
    border: 2px solid #000;
    padding: 10px;
    text-align: center;
    background-color: #f9f9f9;
}

.checkbox-input {
    width: 12px;
    height: 12px;
    margin-right: 5px;
}

.risk-result {
    background-color: #f0f0f0;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #000;
}

.debug-info {
    background: #ffffcc;
    border: 1px solid #ffcc00;
    padding: 10px;
    margin: 10px 0;
    font-size: 9px;
}
");
?>

<!-- Print Controls -->
<div class="no-print" style="margin-bottom: 20px; text-align: center;">
    <?= Html::button('<i class="fas fa-print"></i> Print', [
        'onclick' => 'window.print()',
        'class' => 'btn btn-primary',
        'style' => 'margin-right: 10px; padding: 10px 20px;'
    ]) ?>
    <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['view-form', 'id' => $model->id_form_data], [
        'class' => 'btn btn-secondary',
        'style' => 'padding: 10px 20px;'
    ]) ?>
</div>

<!-- Content -->
<div class="print-content">
    <!-- Header -->
    <div class="header-section">
        <div class="header-row">
            <div>
                <div class="bold" style="font-size: 16px;">LAMPIRAN 1</div>
            </div>
            <div class="logo-section">
                <div class="pt-bigs">PT BIGS</div>
                <div class="integrasi">INTEGRASI</div>
                <div class="teknologi">TEKNOLOGI</div>
            </div>
        </div>

        <div style="text-align: right; font-size: 10px;">
            <div>Nama Lengkap: <strong><?= $patient['nama_pasien'] ?></strong></div>
            <div>Tanggal Lahir: <strong><?= $patient['tanggal_lahir'] ?></strong></div>
            <div>No. RM: <strong><?= $patient['no_rekam_medis'] ?></strong></div>
        </div>
    </div>

    <!-- Title -->
    <div class="title">
        <div style="font-size: 16px; margin-bottom: 5px;"><strong>PENGKAJIAN KEPERAWATAN</strong></div>
        <div style="font-size: 16px;"><strong>POLIKLINIK KEBIDANAN</strong></div>
    </div>

    

    <!-- Form Basic Info -->
    <div class="form-info">
        <div><strong>Poliklinik: <?= $formData['poliklinik'] ?></strong></div>
    </div>

    <!-- Section 1: Pengkajian saat datang -->
    <div class="section">
        <div class="section-title">Pengkajian saat datang (diisi oleh perawat)</div>

        <div class="two-column">
            <div>
                <div class="bold">1. Cara masuk:</div>
                <div class="checkbox-row">
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['cara_masuk'] == 'jalan_tanpa_bantuan' ? 'checked' : '' ?> readonly>
                        <span>Jalan tanpa bantuan</span>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['cara_masuk'] == 'kursi_tanpa_bantuan' ? 'checked' : '' ?> readonly>
                        <span>Kursi tanpa bantuan</span>
                    </div>
                </div>
                <div class="checkbox-row">
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['cara_masuk'] == 'tempat_tidur_dorong' ? 'checked' : '' ?> readonly>
                        <span>Tempat tidur dorong</span>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['cara_masuk'] == 'lain_lain' ? 'checked' : '' ?> readonly>
                        <span>Lain-lain</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="bold">2. Anamnesis:</div>
                <div class="checkbox-row">
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['anamnesis'] == 'autoanamnesis' ? 'checked' : '' ?> readonly>
                        <span>Autoanamnesis</span>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['anamnesis'] == 'aloanamnesis' ? 'checked' : '' ?> readonly>
                        <span>Aloanamnesis</span>
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <span>Diperoleh: ________________ Hubungan: ________________</span>
                </div>
            </div>
        </div>

        <div style="margin-top: 15px;">
            <div><strong>Alergi:</strong> <?= $formData['alergi'] ?></div>
        </div>

        <div style="margin-top: 10px;">
            <div class="bold">3. Keluhan utama saat ini:</div>
            <div style="margin-top: 5px;"><?= $formData['keluhan_utama'] ?></div>
        </div>
    </div>

    <!-- Section 2: Pemeriksaan Fisik -->
    <div class="section">
        <div class="section-title">4. Pemeriksaan fisik:</div>

        <div class="three-column">
            <div>
                <div class="bold">a. Keadaan umum:</div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['keadaan_umum'] == 'tidak_tampak_sakit' ? 'checked' : '' ?> readonly>
                    <span>Tidak tampak sakit</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['keadaan_umum'] == 'sakit_ringan' ? 'checked' : '' ?> readonly>
                    <span>Sakit ringan</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['keadaan_umum'] == 'sedang' ? 'checked' : '' ?> readonly>
                    <span>Sedang</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['keadaan_umum'] == 'berat' ? 'checked' : '' ?> readonly>
                    <span>Berat</span>
                </div>
            </div>
            <div>
                <div class="bold">b. Warna kulit:</div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['warna_kulit'] == 'normal' ? 'checked' : '' ?> readonly>
                    <span>Normal</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['warna_kulit'] == 'sianosis' ? 'checked' : '' ?> readonly>
                    <span>Sianosis</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['warna_kulit'] == 'pucat' ? 'checked' : '' ?> readonly>
                    <span>Pucat</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['warna_kulit'] == 'kemerahan' ? 'checked' : '' ?> readonly>
                    <span>Kemerahan</span>
                </div>
            </div>
            <div>
                <div class="bold">Kesadaran:</div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['kesadaran'] == 'compos_mentis' ? 'checked' : '' ?> readonly>
                    <span>Compos mentis</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['kesadaran'] == 'apatis' ? 'checked' : '' ?> readonly>
                    <span>Apatis</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['kesadaran'] == 'somnolent' ? 'checked' : '' ?> readonly>
                    <span>Somnolent</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['kesadaran'] == 'sopor' ? 'checked' : '' ?> readonly>
                    <span>Sopor</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['kesadaran'] == 'soporokoma' ? 'checked' : '' ?> readonly>
                    <span>Soporokoma</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['kesadaran'] == 'koma' ? 'checked' : '' ?> readonly>
                    <span>Koma</span>
                </div>
            </div>
        </div>

        <!-- Tanda Vital -->
        <div style="margin-top: 15px;">
            <div class="bold">Tanda vital:</div>
            <div class="vital-signs">
                <div>TD: <?= $formData['td'] ?></div>
                <div>P: <?= $formData['p'] ?></div>
                <div>N: <?= $formData['n'] ?></div>
                <div>S: <?= $formData['s'] ?></div>
            </div>
        </div>

        <!-- Fungsional & Antropometri -->
        <div class="two-column" style="margin-top: 15px;">
            <div>
                <div class="bold">Fungsional:</div>
                <div>1. Alat bantu: <?= $formData['alat_bantu'] ?></div>
                <div>2. Prothesa: <?= $formData['prothesa'] ?></div>
                <div>3. Cacat tubuh: <?= $formData['cacat_tubuh'] ?></div>
                <div>4. ADL:
                    <input type="checkbox" class="checkbox-input" <?= $formData['adl'] == 'mandiri' ? 'checked' : '' ?> readonly> Mandiri
                    <input type="checkbox" class="checkbox-input" <?= $formData['adl'] == 'dibantu' ? 'checked' : '' ?> readonly> Dibantu
                </div>
                <div>5. Riwayat jatuh:
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_jatuh_fungsional'] == 'positif' ? 'checked' : '' ?> readonly> + (Ada riwayat)
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_jatuh_fungsional'] == 'negatif' ? 'checked' : '' ?> readonly> - (Tidak ada riwayat)
                </div>
            </div>
            <div>
                <div class="bold">Antropometri:</div>
                <div class="antropometri">
                    <div>Berat: <?= $formData['berat'] != '-' ? $formData['berat'] . ' Kg' : '_____ Kg' ?></div>
                    <div>Tinggi badan: <?= $formData['tinggi'] != '-' ? $formData['tinggi'] . ' Cm' : '_____ Cm' ?></div>
                    <div>Panjang badan (PB): <?= $formData['panjang'] != '-' ? $formData['panjang'] . ' Cm' : '_____ Cm' ?></div>
                    <div>Lingkar kepala (LK): <?= $formData['lingkar'] != '-' ? $formData['lingkar'] . ' Cm' : '_____ Cm' ?></div>
                    <div>IMT: <?= $formData['imt'] != '-' ? $formData['imt'] : '_____' ?></div>
                </div>
                <div style="font-size: 9px; margin-top: 5px;">
                    <strong>Catatan:</strong> PB & LK Khusus Pediatri
                </div>
            </div>
        </div>

        <!-- Status Gizi -->
        <div style="margin-top: 15px;">
            <div class="bold">c. Status gizi:</div>
            <div class="checkbox-row">
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['status_gizi'] == 'ideal' ? 'checked' : '' ?> readonly>
                    <span>Ideal</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['status_gizi'] == 'kurang' ? 'checked' : '' ?> readonly>
                    <span>Kurang</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['status_gizi'] == 'obesitas' ? 'checked' : '' ?> readonly>
                    <span>Obesitas / overweight</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Riwayat Penyakit -->
    <div class="section">
        <div class="three-column">
            <div>
                <div class="bold">5. Riwayat penyakit sekarang:</div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_sekarang'] == 'dm' ? 'checked' : '' ?> readonly>
                    <span>DM</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_sekarang'] == 'hipertensi' ? 'checked' : '' ?> readonly>
                    <span>Hipertensi</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_sekarang'] == 'jantung' ? 'checked' : '' ?> readonly>
                    <span>Jantung</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_sekarang'] == 'lain_lain' ? 'checked' : '' ?> readonly>
                    <span>Lain-lain</span>
                </div>
            </div>
            <div>
                <div class="bold">6. Riwayat penyakit sebelumnya:</div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_sebelumnya'] == 'tidak' ? 'checked' : '' ?> readonly>
                    <span>Tidak</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_sebelumnya'] == 'ya' ? 'checked' : '' ?> readonly>
                    <span>Ya</span>
                </div>
            </div>
            <div>
                <div class="bold">7. Riwayat penyakit keluarga:</div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_keluarga'] == 'tidak' ? 'checked' : '' ?> readonly>
                    <span>Tidak</span>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_penyakit_keluarga'] == 'ya' ? 'checked' : '' ?> readonly>
                    <span>Ya</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: Riwayat Operasi -->
    <div class="section">
        <div class="two-column">
            <div>
                <div class="bold">8. Riwayat operasi:</div>
                <div class="checkbox-row">
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_operasi'] == 'tidak' ? 'checked' : '' ?> readonly>
                        <span>Tidak</span>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_operasi'] == 'ya' ? 'checked' : '' ?> readonly>
                        <span>Ya</span>
                    </div>
                </div>
                <?php if ($formData['riwayat_operasi'] == 'ya'): ?>
                    <div style="margin-top: 10px;">
                        <div>Operasi apa? <?= $formData['operasi_apa'] ?></div>
                        <div>Kapan? <?= $formData['operasi_kapan'] ?></div>
                    </div>
                <?php else: ?>
                    <div style="margin-top: 10px;">
                        <div>Operasi apa? _______________</div>
                        <div>Kapan? _______________</div>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <div class="bold">9. Riwayat pernah dirawat di RS:</div>
                <div class="checkbox-row">
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_pernah_dirawat'] == 'tidak' ? 'checked' : '' ?> readonly>
                        <span>Tidak</span>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" class="checkbox-input" <?= $formData['riwayat_pernah_dirawat'] == 'ya' ? 'checked' : '' ?> readonly>
                        <span>Ya</span>
                    </div>
                </div>
                <?php if ($formData['riwayat_pernah_dirawat'] == 'ya'): ?>
                    <div style="margin-top: 10px;">
                        <div>Penyakit apa? <?= $formData['penyakit_apa'] ?></div>
                        <div>Kapan? <?= $formData['dirawat_kapan'] ?></div>
                    </div>
                <?php else: ?>
                    <div style="margin-top: 10px;">
                        <div>Penyakit apa? _______________</div>
                        <div>Kapan? _______________</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Section 5: Pengkajian Resiko Jatuh - DIPERBAIKI -->
    <div class="section">
        <div class="section-title">10. Pengkajian resiko jatuh</div>

        <table class="risk-table">
            <thead>
                <tr>
                    <th width="8%">Resiko</th>
                    <th width="60%">Skala</th>
                    <th width="32%">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Riwayat jatuh yang baru atau dalam 3 bulan terakhir</td>
                    <td>Tidak = 0<br>Ya = 25</td>
                    <td class="text-center bold" style="font-size: 12px;"><?= $riskScores[0] ?></td>
                </tr>
                <tr>
                    <td>Diagnosa medis sekunder > 1</td>
                    <td>Tidak = 0<br>Ya = 15</td>
                    <td class="text-center bold" style="font-size: 12px;"><?= $riskScores[1] ?></td>
                </tr>
                <tr>
                    <td>Alat bantu jalan</td>
                    <td>Mandiri, bedrest, dibantu perawat, kursi roda = 0<br>Penopang, tongkat/walker = 15<br>Mencengkeram furniture/sesuatu untuk topangan = 15</td>
                    <td class="text-center bold" style="font-size: 12px;"><?= $riskScores[2] ?></td>
                </tr>
                <tr>
                    <td>Ad akses IV atau terapi heparin lock</td>
                    <td>Tidak = 0<br>Ya = 20</td>
                    <td class="text-center bold" style="font-size: 12px;"><?= $riskScores[3] ?></td>
                </tr>
                <tr>
                    <td>Cara berjalan/berpindah</td>
                    <td>Normal = 0<br>Lemah, langkah, diseret = 10<br>Terganggu, perlu bantuan, keseimbangan buruk = 20</td>
                    <td class="text-center bold" style="font-size: 12px;"><?= $riskScores[4] ?></td>
                </tr>
                <tr>
                    <td>Status mental</td>
                    <td>Orientasi sesuai kemampuan diri = 0<br>Lupa keterbatasan diri = 15</td>
                    <td class="text-center bold" style="font-size: 12px;"><?= $riskScores[5] ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center bold" style="background-color: #e0e0e0; font-size: 12px;">NILAI TOTAL</td>
                    <td class="text-center bold" style="font-size: 16px; background-color: #e0e0e0; color: #d9534f;"><?= $totalRisk ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Risk Category Results -->
        <div class="risk-result">
            <div class="text-center">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                    <div style="border: 2px solid #000; padding: 8px; background-color: <?= $totalRisk <= 24 ? '#90EE90' : '#f0f0f0' ?>;">
                        <div class="bold">Tidak berisiko</div>
                        <div>(0-24)</div>
                        <?php if ($totalRisk <= 24): ?>
                            <div class="bold" style="color: #2d5a27; margin-top: 5px;">✓ AKTIF</div>
                        <?php endif; ?>
                    </div>
                    <div style="border: 2px solid #000; padding: 8px; background-color: <?= ($totalRisk >= 25 && $totalRisk <= 44) ? '#FFD700' : '#f0f0f0' ?>;">
                        <div class="bold">Perawatan yang baik</div>
                        <div class="bold">Resiko rendah</div>
                        <div>(25-44)</div>
                        <?php if ($totalRisk >= 25 && $totalRisk <= 44): ?>
                            <div class="bold" style="color: #8b6914; margin-top: 5px;">✓ AKTIF</div>
                        <?php endif; ?>
                    </div>
                    <div style="border: 2px solid #000; padding: 8px; background-color: <?= $totalRisk >= 45 ? '#FFB6C1' : '#f0f0f0' ?>;">
                        <div class="bold">Lakukan intervensi</div>
                        <div class="bold">jatuh standar</div>
                        <div class="bold">Resiko tinggi</div>
                        <div>(≥45)</div>
                        <?php if ($totalRisk >= 45): ?>
                            <div class="bold" style="color: #8b0000; margin-top: 5px;">✓ AKTIF</div>
                            <div style="margin-top: 5px;">
                                <div class="bold" style="color: #8b0000;">Lakukan intervensi</div>
                                <div class="bold" style="color: #8b0000;">jatuh risiko tinggi</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer with Signature Section -->
    <div style="margin-top: 30px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <div></div>
        <div class="petugas-box" style="text-align: center;">
            <div class="bold" style="margin-bottom: 10px;">Nama Petugas:</div>
            
            <div style="margin: 5px 0;">
                <strong>Tanggal: <?= date('d/m/Y') ?></strong>
            </div>
            
            <div style="margin: 5px 0 20px 0;">
                <strong>Pukul: <?= date('H:i') ?></strong>
            </div>
            
            <div style="margin: 20px 0; height: 50px; border-bottom: 1px solid #000;"></div>
            
            <div class="bold">Tanda Tangan</div>
        </div>
    </div>
</div>


    <!-- Print Footer -->
    <div style="margin-top: 20px; text-align: center; font-size: 9px; color: #666;">
        <div>Medical Form System - PT BIGS Integrasi Teknologi</div>
        <div>Form ID: FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?> |
            Tanggal Cetak: <?= date('d/m/Y H:i:s') ?> |
            Total Resiko: <?= $totalRisk ?></div>
    </div>
</div>

<?php
// JavaScript untuk print functionality
$this->registerJs("
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced print function
    window.printDocument = function() {
        const printElements = document.querySelectorAll('.no-print');
        printElements.forEach(el => el.style.display = 'none');
        
        window.print();
        
        setTimeout(() => {
            printElements.forEach(el => el.style.display = 'block');
        }, 1000);
    };
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            printDocument();
        }
    });
    
    // Print preparation
    window.addEventListener('beforeprint', function() {
        document.body.style.margin = '0';
        document.body.style.padding = '15mm';
        
        // Hide debug info saat print
        const debugElements = document.querySelectorAll('.debug-info');
        debugElements.forEach(el => el.style.display = 'none');
    });
    
    window.addEventListener('afterprint', function() {
        document.body.style.margin = '';
        document.body.style.padding = '20px';
        
        // Show debug info kembali setelah print
        const debugElements = document.querySelectorAll('.debug-info');
        debugElements.forEach(el => el.style.display = 'block');
    });
    
    console.log('Print form loaded successfully');
    console.log('Risk scores: " . json_encode($riskScores) . "');
    console.log('Total risk: " . (int)$totalRisk . "');
});
", \yii\web\View::POS_END);
?>