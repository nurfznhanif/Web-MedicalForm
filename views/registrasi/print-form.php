<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */

$this->title = 'Print Form Pengkajian';

/**
 * Helper class untuk data processing dengan error handling
 */
class FormHelper
{
    private $model;
    private $registrasi;
    private $data;

    public function __construct($model)
    {
        $this->model = $model;
        $this->registrasi = $model->registrasi ?? null;

        try {
            $this->data = $model->getDisplayData() ?? [];
        } catch (Exception $e) {
            Yii::error("Error getting display data: " . $e->getMessage());
            $this->data = [];
        }
    }

    /**
     * Safe get dengan fallback value
     */
    private function safeGet($object, $key, $default = '')
    {
        if (is_array($object)) {
            return $object[$key] ?? $default;
        } elseif (is_object($object)) {
            return $object->$key ?? $default;
        }
        return $default;
    }

    /**
     * Format tanggal dengan safe handling
     */
    private function formatDate($date, $format = 'd F Y')
    {
        if (!$date) return '-';
        try {
            return date($format, strtotime($date));
        } catch (Exception $e) {
            return '-';
        }
    }

    /**
     * Get patient data dengan error handling
     */
    public function getPatientData()
    {
        return [
            'nama_pasien' => Html::encode($this->safeGet($this->registrasi, 'nama_pasien', 'NAMA PASIEN')),
            'tanggal_lahir' => $this->formatDate($this->safeGet($this->registrasi, 'tanggal_lahir')),
            'no_rekam_medis' => Html::encode($this->safeGet($this->registrasi, 'no_rekam_medis', 'RM-XXXX')),
            'nik' => Html::encode($this->safeGet($this->registrasi, 'nik', '-')),
        ];
    }

    /**
     * Get form basic info
     */
    public function getFormInfo()
    {
        return [
            'tanggal_pengkajian' => $this->safeGet($this->data, 'tanggal_pengkajian') ?:
                $this->safeGet($this->model, 'tanggal_pengkajian', date('d/m/Y')),
            'jam_pengkajian' => $this->safeGet($this->data, 'jam_pengkajian') ?:
                $this->safeGet($this->model, 'jam_pengkajian', date('H:i')),
            'poliklinik' => $this->safeGet($this->data, 'poliklinik') ?:
                $this->safeGet($this->model, 'poliklinik', 'KLINIK OBGYN'),
        ];
    }

    /**
     * Get assessment data
     */
    public function getAssessmentData()
    {
        return [
            'cara_masuk' => $this->safeGet($this->data, 'cara_masuk') ?: $this->safeGet($this->model, 'cara_masuk'),
            'anamnesis' => $this->safeGet($this->data, 'anamnesis') ?: $this->safeGet($this->model, 'anamnesis'),
            'anamnesis_diperoleh' => Html::encode($this->safeGet($this->data, 'anamnesis_diperoleh', '_________________')),
            'anamnesis_hubungan' => Html::encode($this->safeGet($this->data, 'anamnesis_hubungan', '_________________')),
            'alergi' => Html::encode($this->safeGet($this->data, 'alergi') ?:
                $this->safeGet($this->model, 'alergi', 'Tidak ada alergi yang diketahui')),
            'keluhan_utama' => nl2br(Html::encode($this->safeGet($this->data, 'keluhan_utama') ?:
                $this->safeGet($this->model, 'keluhan_utama', 'Tidak ada keluhan khusus'))),
        ];
    }

    /**
     * Get physical exam data
     */
    public function getPhysicalExam()
    {
        return [
            'keadaan_umum' => $this->safeGet($this->data, 'keadaan_umum') ?: $this->safeGet($this->model, 'keadaan_umum'),
            'warna_kulit' => $this->safeGet($this->data, 'warna_kulit') ?: $this->safeGet($this->model, 'warna_kulit'),
            'kesadaran' => $this->safeGet($this->data, 'kesadaran') ?: $this->safeGet($this->model, 'kesadaran'),
            'status_gizi' => $this->safeGet($this->data, 'status_gizi') ?: $this->safeGet($this->model, 'status_gizi'),
        ];
    }

    /**
     * Get vital signs
     */
    public function getVitalSigns()
    {
        return [
            'td' => Html::encode($this->safeGet($this->data, 'tanda_vital_td') ?:
                $this->safeGet($this->model, 'tanda_vital_td', '120/80 mmHg')),
            'p' => Html::encode($this->safeGet($this->data, 'tanda_vital_p') ?:
                $this->safeGet($this->model, 'tanda_vital_p', '20 x/menit')),
            'n' => Html::encode($this->safeGet($this->data, 'tanda_vital_n') ?:
                $this->safeGet($this->model, 'tanda_vital_n', '80 x/menit')),
            's' => Html::encode($this->safeGet($this->data, 'tanda_vital_s') ?:
                $this->safeGet($this->model, 'tanda_vital_s', '36.5°C')),
        ];
    }

    /**
     * Get antropometri data
     */
    public function getAntropometri()
    {
        return [
            'berat' => $this->safeGet($this->data, 'antro_berat') ?: $this->safeGet($this->model, 'antro_berat', '-'),
            'tinggi' => $this->safeGet($this->data, 'antro_tinggi') ?: $this->safeGet($this->model, 'antro_tinggi', '-'),
            'lingkar' => $this->safeGet($this->data, 'antro_lingkar') ?: $this->safeGet($this->model, 'antro_lingkar', '-'),
            'imt' => Html::encode($this->safeGet($this->data, 'antro_imt') ?: $this->safeGet($this->model, 'antro_imt', '-')),
        ];
    }

    /**
     * Get functional data
     */
    public function getFunctionalData()
    {
        return [
            'alat_bantu' => Html::encode($this->safeGet($this->data, 'fungsi_alat_bantu') ?:
                $this->safeGet($this->model, 'fungsi_alat_bantu', '-')),
            'prothesa' => Html::encode($this->safeGet($this->data, 'fungsi_prothesa') ?:
                $this->safeGet($this->model, 'fungsi_prothesa', '-')),
            'cacat_tubuh' => Html::encode($this->safeGet($this->data, 'fungsi_cacat_tubuh') ?:
                $this->safeGet($this->model, 'fungsi_cacat_tubuh', '-')),
            'adl' => Html::encode($this->safeGet($this->data, 'fungsi_adl') ?:
                $this->safeGet($this->model, 'fungsi_adl', 'Mandiri')),
            'riwayat_jatuh' => Html::encode($this->safeGet($this->data, 'riwayat_jatuh_fungsional') ?:
                $this->safeGet($this->model, 'riwayat_jatuh_fungsional', 'Negatif')),
        ];
    }

    /**
     * Get medical history
     */
    public function getMedicalHistory()
    {
        return [
            'penyakit_sekarang' => $this->safeGet($this->data, 'riwayat_penyakit_sekarang') ?:
                $this->safeGet($this->model, 'riwayat_penyakit_sekarang'),
            'penyakit_sebelum' => $this->safeGet($this->data, 'riwayat_penyakit_sebelumnya') ?:
                $this->safeGet($this->model, 'riwayat_penyakit_sebelumnya'),
            'penyakit_keluarga' => $this->safeGet($this->data, 'riwayat_penyakit_keluarga') ?:
                $this->safeGet($this->model, 'riwayat_penyakit_keluarga'),
            'riwayat_operasi' => $this->safeGet($this->data, 'riwayat_operasi') ?:
                $this->safeGet($this->model, 'riwayat_operasi'),
            'operasi_apa' => Html::encode($this->safeGet($this->data, 'operasi_apa', 'APP')),
            'operasi_kapan' => Html::encode($this->safeGet($this->data, 'operasi_kapan', '2017')),
            'riwayat_dirawat' => $this->safeGet($this->data, 'riwayat_pernah_dirawat') ?:
                $this->safeGet($this->model, 'riwayat_pernah_dirawat'),
            'penyakit_apa' => Html::encode($this->safeGet($this->data, 'penyakit_apa', 'Post operasi')),
            'dirawat_kapan' => Html::encode($this->safeGet($this->data, 'dirawat_kapan', '2017')),
        ];
    }

    /**
     * Get risk assessment data
     */
    public function getRiskAssessment()
    {
        $riskScores = [25, 15, 0, 20, 0, 0]; // Default values

        if (isset($this->data['resiko_jatuh_scores']) && is_array($this->data['resiko_jatuh_scores'])) {
            $riskScores = $this->data['resiko_jatuh_scores'];
        } elseif (isset($this->data['resiko_jatuh']) && is_array($this->data['resiko_jatuh'])) {
            foreach ($this->data['resiko_jatuh'] as $index => $item) {
                if (isset($item['hasil'])) {
                    $riskScores[$index] = (int)$item['hasil'];
                }
            }
        }

        return $riskScores;
    }

    /**
     * Calculate risk category
     */
    public function getRiskCategory($totalScore)
    {
        if ($totalScore <= 24) {
            return [
                'kategori' => 'TIDAK BERISIKO (0-24)',
                'rekomendasi' => 'Perawatan standar dan pemantauan rutin',
                'warna' => '#059669',
                'ikon' => '✅'
            ];
        } elseif ($totalScore <= 44) {
            return [
                'kategori' => 'RISIKO RENDAH (25-44)',
                'rekomendasi' => 'Lakukan intervensi jatuh standar dan pemantauan berkala',
                'warna' => '#f59e0b',
                'ikon' => '⚠️'
            ];
        } else {
            return [
                'kategori' => 'RISIKO TINGGI (≥45)',
                'rekomendasi' => 'Lakukan intervensi jatuh risiko tinggi dan pengawasan ketat',
                'warna' => '#dc2626',
                'ikon' => '🚨'
            ];
        }
    }
}

// Inisialisasi helper
$helper = new FormHelper($model);
$patientData = $helper->getPatientData();
$formInfo = $helper->getFormInfo();
$assessmentData = $helper->getAssessmentData();
$physicalExam = $helper->getPhysicalExam();
$vitalSigns = $helper->getVitalSigns();
$antropometri = $helper->getAntropometri();
$functionalData = $helper->getFunctionalData();
$medicalHistory = $helper->getMedicalHistory();
$riskScores = $helper->getRiskAssessment();

// Register CSS
$this->registerCss("
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

@media print {
    .no-print { display: none !important; }
    body { 
        font-size: 11px; 
        line-height: 1.3; 
        margin: 0;
        padding: 15px;
        font-family: 'Arial', sans-serif;
        color: #000;
        background: white;
    }
    .print-header { 
        border-bottom: 3px solid #000; 
        padding-bottom: 15px; 
        margin-bottom: 20px; 
        page-break-inside: avoid;
    }
    .form-section { 
        margin-bottom: 20px; 
        border: 2px solid #000; 
        padding: 15px; 
        page-break-inside: avoid;
        border-radius: 5px;
    }
    .section-title { 
        font-weight: bold; 
        background-color: #f0f0f0; 
        padding: 8px; 
        margin: -15px -15px 15px -15px; 
        border-bottom: 2px solid #000;
        font-size: 12px;
    }
    .vital-grid, .antropometri-grid { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 10px; 
        margin: 10px 0;
    }
    @page { size: A4; margin: 1.5cm 1cm; }
}

/* Screen styles */
body { 
    font-family: 'Arial', sans-serif; 
    font-size: 12px; 
    line-height: 1.4; 
    color: #000; 
    background: white; 
    margin: 0; 
    padding: 20px; 
    max-width: 210mm;
    margin: 0 auto;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.print-preview { background: white; padding: 20px; min-height: 297mm; }

.print-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    border-bottom: 3px solid #000; 
    padding-bottom: 15px; 
    margin-bottom: 25px; 
}

.logo-section { text-align: right; font-weight: bold; color: #2563eb; }

.patient-info { 
    background: #f8f9fa; 
    border: 2px solid #000; 
    padding: 15px; 
    margin-bottom: 20px; 
    border-radius: 5px;
}

.form-section { 
    border: 2px solid #000; 
    padding: 15px; 
    margin-bottom: 20px; 
    border-radius: 5px;
    background: #fdfdfd;
}

.section-title { 
    font-weight: bold; 
    background: linear-gradient(135deg, #e5e7eb, #f3f4f6); 
    padding: 10px; 
    margin: -15px -15px 15px -15px; 
    border-bottom: 2px solid #000;
    border-radius: 3px 3px 0 0;
    font-size: 13px;
}

.checkbox-group { display: flex; flex-wrap: wrap; gap: 15px; margin: 10px 0; }
.checkbox-item { 
    display: flex; 
    align-items: center; 
    gap: 8px; 
    margin-bottom: 8px;
    font-size: 12px;
}

.vital-grid, .antropometri-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
    gap: 15px; 
    margin: 15px 0;
}

.vital-item, .antropometri-item {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #dee2e6;
    text-align: center;
}

.resiko-table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 15px; 
    background: white;
}

.resiko-table th, .resiko-table td { 
    border: 2px solid #000; 
    padding: 10px; 
    font-size: 11px; 
    vertical-align: top;
}

.resiko-table th { 
    background: linear-gradient(135deg, #e5e7eb, #f3f4f6); 
    font-weight: bold; 
    text-align: center;
}

/* Utility classes */
.text-center { text-align: center; }
.text-right { text-align: right; }
.flex-between { display: flex; justify-content: space-between; align-items: center; }
.mb-2 { margin-bottom: 15px; }
.row { display: flex; flex-wrap: wrap; gap: 10px; }
.col-6 { width: calc(50% - 5px); }
.col-4 { width: calc(33.33% - 7px); }
.col-3 { width: calc(25% - 8px); }

.risk-category-display {
    background: #f0f9ff;
    border: 2px solid #0369a1;
    padding: 15px;
    margin-top: 15px;
    border-radius: 8px;
}

.no-print-controls {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    gap: 10px;
}

.btn-modern {
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.btn-secondary { background: linear-gradient(135deg, #6b7280, #4b5563); color: white; }

@media (max-width: 768px) {
    body { padding: 10px; font-size: 11px; }
    .row { flex-direction: column; }
    .col-6, .col-4, .col-3 { width: 100%; }
}
");
?>

<!-- Print Controls -->
<div class="no-print no-print-controls">
    <?= Html::button('<i class="fas fa-print"></i> Print', [
        'onclick' => 'window.print()',
        'class' => 'btn-modern btn-primary'
    ]) ?>
    <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['view-form', 'id' => $model->id_form_data], [
        'class' => 'btn-modern btn-secondary'
    ]) ?>
</div>

<div class="print-preview">
    <!-- Header -->
    <div class="print-header">
        <div>
            <h2 style="margin: 0; font-size: 18px; font-weight: bold;">LAMPIRAN 1</h2>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Form Pengkajian Medis</p>
        </div>
        <div class="logo-section">
            <div style="font-size: 16px; line-height: 1.2;">
                <strong style="color: #dc2626;">PT BIGS</strong><br>
                <strong style="color: #2563eb;">INTEGRASI</strong><br>
                <strong style="color: #059669;">TEKNOLOGI</strong>
            </div>
            <div style="font-size: 10px; margin-top: 5px; color: #666;">Medical Form System</div>
        </div>
    </div>

    <!-- Title -->
    <div class="text-center mb-2">
        <h1 style="margin: 0; font-size: 20px; font-weight: bold; color: #1e40af;">PENGKAJIAN KEPERAWATAN</h1>
        <div style="margin-top: 10px; font-size: 11px; color: #666;">
            ID Form: FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?> |
            Tanggal Cetak: <?= date('d/m/Y H:i:s') ?>
        </div>
    </div>

    <!-- Patient Info -->
    <div class="patient-info">
        <div class="row">
            <div class="col-6">
                <div style="font-weight: bold; margin-bottom: 8px;">
                    👤 Nama Lengkap: <?= $patientData['nama_pasien'] ?>
                </div>
                <div style="margin-bottom: 8px;">📅 Tanggal Lahir: <?= $patientData['tanggal_lahir'] ?></div>
                <div style="margin-bottom: 8px;">📋 No. RM: <?= $patientData['no_rekam_medis'] ?></div>
                <div>🆔 NIK: <?= $patientData['nik'] ?></div>
            </div>
            <div class="col-6 text-right">
                <div style="border: 2px solid #000; padding: 15px; display: inline-block; border-radius: 8px; background: #f9f9f9;">
                    <div style="font-weight: bold; margin-bottom: 10px; color: #1e40af;">PETUGAS MEDIS</div>
                    <div style="margin-bottom: 8px;">📅 Tanggal/Pukul: <?= date('d/m/Y H:i') ?></div>
                    <div style="margin-bottom: 15px;">👨‍⚕️ Nama Lengkap: _________________</div>
                    <div>✍️ Tanda Tangan: _________________</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Basic Info -->
    <div class="form-section">
        <div class="flex-between mb-2">
            <div><strong>📅 Tanggal Pengkajian:</strong> <?= $formInfo['tanggal_pengkajian'] ?></div>
            <div><strong>⏰ Jam Pengkajian:</strong> <?= $formInfo['jam_pengkajian'] ?></div>
            <div><strong>🏥 Poliklinik:</strong> <?= $formInfo['poliklinik'] ?></div>
        </div>
    </div>

    <!-- Assessment Section -->
    <div class="form-section">
        <div class="section-title">📋 Pengkajian saat datang</div>

        <div class="row mb-2">
            <div class="col-6">
                <strong>1. Cara masuk:</strong><br>
                <div class="checkbox-group">
                    <?php
                    $caraMasukOptions = [
                        'jalan_tanpa_bantuan' => 'Jalan tanpa bantuan',
                        'kursi_tanpa_bantuan' => 'Kursi tanpa bantuan',
                        'tempat_tidur_dorong' => 'Tempat tidur dorong',
                        'lain_lain' => 'Lain-lain'
                    ];
                    foreach ($caraMasukOptions as $value => $label): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" <?= $assessmentData['cara_masuk'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-6">
                <strong>2. Anamnesis:</strong><br>
                <div class="checkbox-group">
                    <?php
                    $anamnesisOptions = ['autoanamnesis' => 'Autoanamnesis', 'aloanamnesis' => 'Aloanamnesis'];
                    foreach ($anamnesisOptions as $value => $label): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" <?= $assessmentData['anamnesis'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="margin-top: 10px; background: #f8f9fa; padding: 8px; border-radius: 5px;">
                    Diperoleh dari: <u><?= $assessmentData['anamnesis_diperoleh'] ?></u><br>
                    Hubungan: <u><?= $assessmentData['anamnesis_hubungan'] ?></u>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <strong>⚠️ Alergi:</strong>
            <div style="background: #fef3c7; padding: 10px; border-radius: 5px; margin-top: 5px; border: 1px solid #f59e0b;">
                <?= $assessmentData['alergi'] ?>
            </div>
        </div>

        <div class="mb-2">
            <strong>3. Keluhan utama saat ini:</strong><br>
            <div style="background: #f0f9ff; padding: 10px; border-radius: 5px; margin-top: 5px; border: 1px solid #0369a1;">
                <?= $assessmentData['keluhan_utama'] ?>
            </div>
        </div>
    </div>

    <!-- Physical Exam -->
    <div class="form-section">
        <div class="section-title">🔍 Pemeriksaan Fisik</div>

        <div class="row mb-2">
            <div class="col-4">
                <strong>a. Keadaan umum:</strong><br>
                <?php
                $keadaanOptions = [
                    'tidak_tampak_sakit' => 'Tidak tampak sakit',
                    'sakit_ringan' => 'Sakit ringan',
                    'sedang' => 'Sedang',
                    'berat' => 'Berat'
                ];
                foreach ($keadaanOptions as $value => $label): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= $physicalExam['keadaan_umum'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-4">
                <strong>b. Warna kulit:</strong><br>
                <?php
                $warnaOptions = ['normal' => 'Normal', 'sianosis' => 'Sianosis', 'pucat' => 'Pucat', 'kemerahan' => 'Kemerahan'];
                foreach ($warnaOptions as $value => $label): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= $physicalExam['warna_kulit'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-4">
                <strong>c. Kesadaran:</strong><br>
                <?php
                $kesadaranOptions = [
                    'compos_mentis' => 'Compos mentis',
                    'apatis' => 'Apatis',
                    'somnolent' => 'Somnolent',
                    'sopor' => 'Sopor',
                    'soporokoma' => 'Soporokoma',
                    'koma' => 'Koma'
                ];
                foreach ($kesadaranOptions as $value => $label): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= $physicalExam['kesadaran'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Vital Signs -->
        <div class="mb-2">
            <strong>💓 Tanda Vital:</strong>
            <div class="vital-grid">
                <div class="vital-item"><strong>TD:</strong> <?= $vitalSigns['td'] ?></div>
                <div class="vital-item"><strong>P:</strong> <?= $vitalSigns['p'] ?></div>
                <div class="vital-item"><strong>N:</strong> <?= $vitalSigns['n'] ?></div>
                <div class="vital-item"><strong>S:</strong> <?= $vitalSigns['s'] ?></div>
            </div>
        </div>

        <!-- Functional & Antropometri -->
        <div class="row mb-2">
            <div class="col-6">
                <strong>🏃‍♂️ Fungsional:</strong><br>
                <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; font-size: 11px;">
                    1. Alat bantu: <?= $functionalData['alat_bantu'] ?><br>
                    2. Prothesa: <?= $functionalData['prothesa'] ?><br>
                    3. Cacat tubuh: <?= $functionalData['cacat_tubuh'] ?><br>
                    4. ADL: <?= $functionalData['adl'] ?><br>
                    5. Riwayat jatuh: <?= $functionalData['riwayat_jatuh'] ?>
                </div>
            </div>
            <div class="col-6">
                <strong>⚖️ Antropometri:</strong><br>
                <div class="antropometri-grid">
                    <div class="antropometri-item">
                        <strong>Berat:</strong><br><?= $antropometri['berat'] ? $antropometri['berat'] . ' Kg' : '-' ?>
                    </div>
                    <div class="antropometri-item">
                        <strong>Tinggi:</strong><br><?= $antropometri['tinggi'] ? $antropometri['tinggi'] . ' Cm' : '-' ?>
                    </div>
                    <div class="antropometri-item">
                        <strong>Lingkar:</strong><br><?= $antropometri['lingkar'] ? $antropometri['lingkar'] . ' Cm' : '-' ?>
                    </div>
                    <div class="antropometri-item">
                        <strong>IMT:</strong><br><?= $antropometri['imt'] ?>
                    </div>
                </div>
                <div style="margin-top: 8px; font-size: 10px; color: #666;">
                    <strong>Catatan:</strong> PB & LK Khusus Pediatri
                </div>
            </div>
        </div>

        <!-- Status Gizi -->
        <div class="mb-2">
            <strong>🍎 Status Gizi:</strong>
            <div class="checkbox-group">
                <?php
                $giziOptions = ['ideal' => 'Ideal', 'kurang' => 'Kurang', 'obesitas' => 'Obesitas / Overweight'];
                foreach ($giziOptions as $value => $label): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= $physicalExam['status_gizi'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Medical History -->
    <div class="form-section">
        <div class="section-title">📚 Riwayat Penyakit dan Operasi</div>

        <div class="row mb-2">
            <div class="col-4">
                <strong>5. Riwayat penyakit sekarang:</strong><br>
                <?php
                $penyakitOptions = ['dm' => 'DM', 'hipertensi' => 'Hipertensi', 'jantung' => 'Jantung', 'tidak_ada' => 'Tidak Ada'];
                foreach ($penyakitOptions as $value => $label): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= $medicalHistory['penyakit_sekarang'] == $value ? 'checked' : '' ?> readonly> <?= $label ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-4">
                <strong>6. Riwayat penyakit sebelumnya:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['penyakit_sebelum'] == 'tidak' ? 'checked' : '' ?> readonly> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['penyakit_sebelum'] == 'ya' ? 'checked' : '' ?> readonly> Ya
                </div>
            </div>
            <div class="col-4">
                <strong>7. Riwayat penyakit keluarga:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['penyakit_keluarga'] == 'tidak' ? 'checked' : '' ?> readonly> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['penyakit_keluarga'] == 'ya' ? 'checked' : '' ?> readonly> Ya
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <strong>9. Riwayat operasi:</strong>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['riwayat_operasi'] == 'tidak' ? 'checked' : '' ?> readonly> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['riwayat_operasi'] == 'ya' ? 'checked' : '' ?> readonly> Ya
                </div>
                <?php if ($medicalHistory['riwayat_operasi'] == 'ya'): ?>
                    <div style="margin-left: 20px; background: #fef3c7; padding: 8px; border-radius: 5px; margin-top: 5px;">
                        Operasi apa? <?= $medicalHistory['operasi_apa'] ?><br>
                        Kapan? <?= $medicalHistory['operasi_kapan'] ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-6">
                <strong>10. Riwayat pernah dirawat di RS:</strong>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['riwayat_dirawat'] == 'tidak' ? 'checked' : '' ?> readonly> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= $medicalHistory['riwayat_dirawat'] == 'ya' ? 'checked' : '' ?> readonly> Ya
                </div>
                <?php if ($medicalHistory['riwayat_dirawat'] == 'ya'): ?>
                    <div style="margin-left: 20px; background: #fef3c7; padding: 8px; border-radius: 5px; margin-top: 5px;">
                        Penyakit apa? <?= $medicalHistory['penyakit_apa'] ?><br>
                        Kapan? <?= $medicalHistory['dirawat_kapan'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Risk Assessment -->
    <div class="form-section">
        <div class="section-title">⚠️ Pengkajian Risiko Jatuh</div>

        <table class="resiko-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="55%">Faktor Risiko</th>
                    <th width="25%">Skala Penilaian</th>
                    <th width="15%">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $riskItems = [
                    'Riwayat jatuh yang baru atau dalam 3 bulan terakhir',
                    'Diagnosa medis sekunder > 1',
                    'Alat bantu jalan',
                    'Ada akses IV atau terapi heparin lock',
                    'Cara berjalan/berpindah',
                    'Status mental'
                ];

                $skalaOptions = [
                    1 => 'Tidak = 0<br>Ya = 25',
                    2 => 'Tidak = 0<br>Ya = 15',
                    3 => 'Mandiri/Bedrest = 0<br>Penopang/Tongkat = 15<br>Mencengkeram = 15',
                    4 => 'Tidak = 0<br>Ya = 20',
                    5 => 'Normal = 0<br>Lemah = 10<br>Terganggu = 20<br>Lupa = 15',
                    6 => 'Orientasi baik = 0<br>Lupa keterbatasan = 15'
                ];

                $totalResiko = 0;
                foreach ($riskItems as $index => $item):
                    $no = $index + 1;
                    $hasil = $riskScores[$index] ?? 0;
                    $totalResiko += $hasil;
                ?>
                    <tr>
                        <td style="text-align: center; font-weight: bold;"><?= $no ?></td>
                        <td><?= Html::encode($item) ?></td>
                        <td style="font-size: 10px; line-height: 1.2;"><?= $skalaOptions[$no] ?? '' ?></td>
                        <td style="text-align: center; font-weight: bold; font-size: 14px; color: <?= $hasil > 0 ? '#dc2626' : '#059669' ?>;">
                            <?= $hasil ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background: #f3f4f6;">
                    <td colspan="3" style="text-align: right; font-weight: bold; font-size: 13px;">
                        🧮 TOTAL SKOR RISIKO:
                    </td>
                    <td style="text-align: center; font-weight: bold; font-size: 18px; color: #1e40af;">
                        <?= $totalResiko ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Risk Category Display -->
        <?php $riskCategory = $helper->getRiskCategory($totalResiko); ?>
        <div class="risk-category-display">
            <div style="text-align: center; margin-bottom: 15px;">
                <div style="background: <?= $riskCategory['warna'] ?>; color: white; padding: 12px 20px; border-radius: 25px; display: inline-block; font-weight: bold; font-size: 14px;">
                    <?= $riskCategory['ikon'] ?> <?= $riskCategory['kategori'] ?>
                </div>
            </div>

            <div style="background: white; padding: 15px; border-radius: 8px; border: 2px solid <?= $riskCategory['warna'] ?>;">
                <div style="font-weight: bold; margin-bottom: 8px; color: #1e40af;">
                    📋 REKOMENDASI PERAWATAN:
                </div>
                <div style="color: #374151; line-height: 1.4;">
                    <?= $riskCategory['rekomendasi'] ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #dee2e6; padding-top: 15px;">
        <div style="margin-bottom: 5px;">
            <strong style="color: #2563eb;">PT BIGS INTEGRASI TEKNOLOGI</strong> - Medical Form System
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
            <div>Form ID: <strong>FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?></strong></div>
            <div>Tanggal Cetak: <strong><?= date('d/m/Y H:i:s') ?></strong></div>
            <div>Halaman: <strong>1 dari 1</strong></div>
        </div>
        <div style="margin-top: 8px; font-size: 9px; color: #9ca3af;">
            ⚠️ Dokumen ini adalah hasil cetak resmi dari sistem dan memiliki kekuatan hukum yang sama dengan dokumen asli.
        </div>
    </div>
</div>

<?php
// Register JavaScript for enhanced printing functionality
$this->registerJs("
document.addEventListener('DOMContentLoaded', function() {
    console.log('Print form initialized');
    
    // Enhanced print function
    window.printForm = function() {
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
            printForm();
        }
        if (e.key === 'Escape') {
            window.history.back();
        }
    });
    
    // Print event handlers
    window.addEventListener('beforeprint', function() {
        console.log('Preparing document for printing...');
        document.body.style.margin = '0';
        document.querySelector('.print-preview').style.padding = '10mm';
    });
    
    window.addEventListener('afterprint', function() {
        console.log('Print completed');
        document.body.style.margin = '';
        document.querySelector('.print-preview').style.padding = '20px';
    });
});
", \yii\web\View::POS_END);
?>