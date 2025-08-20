<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */

$this->title = 'Detail Form Pengkajian Medis';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->registrasi->nama_pasien ?? 'Pasien', 'url' => ['view', 'id' => $model->id_registrasi]];
$this->params['breadcrumbs'][] = $this->title;

// Load data dari JSON
$data = $model->data;
if (is_string($data)) {
    $data = json_decode($data, true);
}

// Register modern CSS
$this->registerCss("
:root {
    --primary-blue: #1e3a8a;
    --secondary-blue: #3b82f6;
    --accent-yellow: #f59e0b;
    --light-blue: #dbeafe;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --bg-light: #f8fafc;
    --white: #ffffff;
    --border-light: #e5e7eb;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --border-radius: 12px;
    --transition: all 0.3s ease;
}

.data-form-view {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.view-header {
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    color: white;
    padding: 2.5rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.view-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: rotate(45deg);
}

.view-header h1 {
    margin: 0 0 1rem 0;
    font-size: 2.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-modern {
    padding: 0.875rem 1.75rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
}

.btn-print-modern {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-print-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

.btn-edit-modern {
    background: linear-gradient(135deg, var(--warning), #d97706);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-edit-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

.btn-delete-modern {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-delete-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

.patient-info-section {
    margin-bottom: 2rem;
}

.info-card-modern {
    background: linear-gradient(135deg, var(--white), var(--bg-light));
    border: 2px solid var(--border-light);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
}

.info-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.card-header-modern {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 700;
    font-size: 1.1rem;
}

.card-header-primary {
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    color: white;
}

.card-header-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
}

.card-header-success {
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
}

.card-body-modern {
    padding: 2rem;
}

.patient-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin-right: 1.5rem;
    flex-shrink: 0;
}

.patient-details {
    flex: 1;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-value {
    color: var(--text-light);
    font-weight: 500;
}

.form-info-card {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(8, 145, 178, 0.05));
    border: 2px solid rgba(6, 182, 212, 0.2);
}

.main-content-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    margin-bottom: 2rem;
}

.content-section {
    padding: 2rem;
    border-bottom: 2px solid var(--bg-light);
}

.content-section:last-child {
    border-bottom: none;
}

.section-title-modern {
    color: var(--primary-blue);
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 3px solid var(--light-blue);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.data-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.data-item {
    background: var(--bg-light);
    padding: 1rem;
    border-radius: 8px;
    border: 2px solid transparent;
    transition: var(--transition);
}

.data-item:hover {
    border-color: var(--light-blue);
    background: rgba(59, 130, 246, 0.05);
}

.data-label {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.data-value {
    color: var(--text-light);
    font-size: 1rem;
}

.vital-signs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.vital-item {
    text-align: center;
    background: var(--bg-light);
    padding: 1rem;
    border-radius: 8px;
    border: 2px solid var(--border-light);
}

.vital-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 0.5rem;
}

.vital-label {
    font-size: 0.8rem;
    color: var(--text-light);
    font-weight: 600;
}

.risk-assessment-table {
    background: var(--white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 2px solid var(--border-light);
}

.risk-assessment-table table {
    width: 100%;
    margin: 0;
}

.risk-assessment-table th {
    background: linear-gradient(135deg, var(--primary-blue), #1e40af);
    color: white;
    padding: 1rem;
    font-weight: 600;
    text-align: left;
}

.risk-assessment-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-light);
    vertical-align: middle;
}

.risk-assessment-table tr:hover td {
    background: var(--bg-light);
}

.risk-category-badge {
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

.risk-low {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    color: var(--success);
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.risk-medium {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
    color: var(--warning);
    border: 2px solid rgba(245, 158, 11, 0.3);
}

.risk-high {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
    color: var(--danger);
    border: 2px solid rgba(239, 68, 68, 0.3);
}

.navigation-section {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 3rem;
    padding: 2rem;
    background: var(--bg-light);
    border-radius: var(--border-radius);
}

.btn-nav-modern {
    padding: 1rem 2rem;
    border-radius: var(--border-radius);
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: var(--transition);
    border: 2px solid var(--border-light);
    background: var(--white);
    color: var(--text-dark);
}

.btn-nav-modern:hover {
    background: var(--secondary-blue);
    color: white;
    border-color: var(--secondary-blue);
    transform: translateY(-2px);
    text-decoration: none;
}

.form-status-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(16, 185, 129, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@media (max-width: 768px) {
    .data-form-view {
        padding: 1rem;
    }
    
    .view-header {
        padding: 2rem 1.5rem;
    }
    
    .view-header h1 {
        font-size: 2rem;
    }
    
    .header-actions {
        justify-content: center;
    }
    
    .data-grid {
        grid-template-columns: 1fr;
    }
    
    .vital-signs-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .navigation-section {
        flex-direction: column;
        align-items: center;
    }
}
");
?>

<div class="data-form-view">
    <!-- Modern Header -->
    <div class="view-header">
        <div class="form-status-badge">
            <div class="status-dot"></div>
            Form Tersimpan
        </div>

        <h1>
            <i class="fas fa-clipboard-check"></i>
            <?= Html::encode($this->title) ?>
        </h1>

        <div class="header-actions">
            <?= Html::a('<i class="fas fa-print"></i> Print Form', ['print-form', 'id' => $model->id_form_data], [
                'class' => 'btn-modern btn-print-modern',
                'target' => '_blank'
            ]) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Edit Form', ['edit-form', 'id' => $model->id_form_data], [
                'class' => 'btn-modern btn-edit-modern'
            ]) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Hapus Form', '#', [
                'class' => 'btn-modern btn-delete-modern',
                'onclick' => "
            if (confirm('Apakah Anda yakin ingin menghapus form pengkajian ini?\\n\\nData yang dihapus tidak dapat dikembalikan!')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '" . \yii\helpers\Url::to(['delete-form', 'id' => $model->id_form_data]) . "';
                var token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_csrf';
                token.value = '" . Yii::$app->request->getCsrfToken() . "';
                form.appendChild(token);
                document.body.appendChild(form);
                form.submit();
            }
            return false;
        ",
            ]) ?>
        </div>
    </div>

    <!-- Patient Information Section -->
    <div class="patient-info-section">
        <div class="row">
            <div class="col-lg-8">
                <div class="info-card-modern">
                    <div class="card-header-modern card-header-primary">
                        <i class="fas fa-user"></i>
                        Informasi Pasien
                    </div>
                    <div class="card-body-modern">
                        <div class="d-flex align-items-center">
                            <div class="patient-avatar">
                                <?= strtoupper(substr($model->registrasi->nama_pasien ?? 'UN', 0, 2)) ?>
                            </div>
                            <div class="patient-details">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-id-card"></i>
                                        No. Registrasi
                                    </span>
                                    <span class="detail-value"><?= Html::encode($model->registrasi->no_registrasi ?? '-') ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-file-medical"></i>
                                        No. Rekam Medis
                                    </span>
                                    <span class="detail-value"><?= Html::encode($model->registrasi->no_rekam_medis ?? '-') ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-user-circle"></i>
                                        Nama Pasien
                                    </span>
                                    <span class="detail-value"><?= Html::encode($model->registrasi->nama_pasien ?? '-') ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-birthday-cake"></i>
                                        Tanggal Lahir
                                    </span>
                                    <span class="detail-value">
                                        <?= $model->registrasi->tanggal_lahir ? date('d/m/Y', strtotime($model->registrasi->tanggal_lahir)) : '-' ?>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-id-card-alt"></i>
                                        NIK
                                    </span>
                                    <span class="detail-value"><?= Html::encode($model->registrasi->nik ?? '-') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="info-card-modern form-info-card">
                    <div class="card-header-modern card-header-info">
                        <i class="fas fa-calendar-alt"></i>
                        Info Form Pengkajian
                    </div>
                    <div class="card-body-modern">
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-hashtag"></i>
                                ID Form
                            </span>
                            <span class="detail-value">FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-calendar"></i>
                                Tanggal Pengkajian
                            </span>
                            <span class="detail-value"><?= $data['tanggal_pengkajian'] ?? '-' ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-clock"></i>
                                Jam Pengkajian
                            </span>
                            <span class="detail-value"><?= $data['jam_pengkajian'] ?? '-' ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-hospital"></i>
                                Poliklinik
                            </span>
                            <span class="detail-value"><?= $data['poliklinik'] ?? '-' ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-plus-circle"></i>
                                Dibuat
                            </span>
                            <span class="detail-value"><?= date('d/m/Y H:i', strtotime($model->create_time_at)) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content-card">
        <div class="card-header-modern card-header-success">
            <i class="fas fa-clipboard-list"></i>
            Data Pengkajian Medis Lengkap
        </div>

        <!-- Pengkajian Awal -->
        <div class="content-section">
            <h6 class="section-title-modern">
                <div class="section-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                Pengkajian Saat Datang
            </h6>
            <div class="data-grid">
                <?php
                // Safe access to assessment data
                $caraMasuk = $data['cara_masuk'] ?? $model->cara_masuk ?? null;
                $anamnesis = $data['anamnesis'] ?? $model->anamnesis ?? null;
                $alergi = $data['alergi'] ?? $model->alergi ?? null;
                $keluhanUtama = $data['keluhan_utama'] ?? $model->keluhan_utama ?? null;
                ?>
                <div class="data-item">
                    <div class="data-label">Cara Masuk</div>
                    <div class="data-value"><?= $caraMasuk ? ucwords(str_replace('_', ' ', $caraMasuk)) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Anamnesis</div>
                    <div class="data-value"><?= $anamnesis ? ucwords($anamnesis) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Alergi</div>
                    <div class="data-value"><?= $alergi ?? '-' ?></div>
                </div>
            </div>
            <div class="data-item">
                <div class="data-label">Keluhan Utama</div>
                <div class="data-value"><?= $keluhanUtama ?? '-' ?></div>
            </div>
        </div>

        <!-- Pemeriksaan Fisik -->
        <div class="content-section">
            <h6 class="section-title-modern">
                <div class="section-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                Pemeriksaan Fisik
            </h6>

            <div class="data-grid">
                <?php
                // Safe access to physical examination data
                $keadaanUmum = $data['keadaan_umum'] ?? $model->keadaan_umum ?? null;
                $warnaKulit = $data['warna_kulit'] ?? $model->warna_kulit ?? null;
                $kesadaran = $data['kesadaran'] ?? $model->kesadaran ?? null;
                $statusGizi = $data['status_gizi'] ?? $model->status_gizi ?? null;
                ?>
                <div class="data-item">
                    <div class="data-label">Keadaan Umum</div>
                    <div class="data-value"><?= $keadaanUmum ? ucwords(str_replace('_', ' ', $keadaanUmum)) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Warna Kulit</div>
                    <div class="data-value"><?= $warnaKulit ? ucwords($warnaKulit) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Kesadaran</div>
                    <div class="data-value"><?= $kesadaran ? ucwords(str_replace('_', ' ', $kesadaran)) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Status Gizi</div>
                    <div class="data-value"><?= $statusGizi ? ucwords($statusGizi) : '-' ?></div>
                </div>
            </div>

            <!-- Tanda Vital -->
            <div style="margin-top: 2rem;">
                <h6 style="color: var(--primary-blue); font-weight: 600; margin-bottom: 1rem;">
                    <i class="fas fa-heartbeat me-2"></i>
                    Tanda Vital
                </h6>
                <div class="vital-signs-grid">
                    <?php
                    // Safe access to vital signs data
                    $td = $data['tanda_vital_td'] ?? $model->tanda_vital_td ?? null;
                    $p = $data['tanda_vital_p'] ?? $model->tanda_vital_p ?? null;
                    $n = $data['tanda_vital_n'] ?? $model->tanda_vital_n ?? null;
                    $s = $data['tanda_vital_s'] ?? $model->tanda_vital_s ?? null;
                    ?>
                    <div class="vital-item">
                        <div class="vital-value"><?= $td ?? '-' ?></div>
                        <div class="vital-label">Tekanan Darah</div>
                    </div>
                    <div class="vital-item">
                        <div class="vital-value"><?= $p ?? '-' ?></div>
                        <div class="vital-label">Pernapasan</div>
                    </div>
                    <div class="vital-item">
                        <div class="vital-value"><?= $n ?? '-' ?></div>
                        <div class="vital-label">Nadi</div>
                    </div>
                    <div class="vital-item">
                        <div class="vital-value"><?= $s ?? '-' ?></div>
                        <div class="vital-label">Suhu</div>
                    </div>
                </div>
            </div>

            <!-- Antropometri -->
            <div style="margin-top: 2rem;">
                <h6 style="color: var(--primary-blue); font-weight: 600; margin-bottom: 1rem;">
                    <i class="fas fa-weight me-2"></i>
                    Antropometri
                </h6>
                <div class="data-grid">
                    <?php
                    // Safe access to anthropometric data
                    $beratBadan = $data['antro_berat'] ?? $model->antro_berat ?? null;
                    $tinggiBadan = $data['antro_tinggi'] ?? $model->antro_tinggi ?? null;
                    $lingkarBadan = $data['antro_lingkar'] ?? $model->antro_lingkar ?? null;
                    $imt = $data['antro_imt'] ?? $model->antro_imt ?? null;
                    ?>
                    <div class="data-item">
                        <div class="data-label">Berat Badan</div>
                        <div class="data-value"><?= $beratBadan ? $beratBadan . ' Kg' : '-' ?></div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">Tinggi Badan</div>
                        <div class="data-value"><?= $tinggiBadan ? $tinggiBadan . ' Cm' : '-' ?></div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">Lingkar Badan</div>
                        <div class="data-value"><?= $lingkarBadan ? $lingkarBadan . ' Cm' : '-' ?></div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">IMT</div>
                        <div class="data-value"><?= $imt ?? '-' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Penyakit -->
        <div class="content-section">
            <h6 class="section-title-modern">
                <div class="section-icon">
                    <i class="fas fa-history"></i>
                </div>
                Riwayat Penyakit dan Operasi
            </h6>
            <div class="data-grid">
                <?php
                // Safe access to medical history data
                $riwayatSekarang = $data['riwayat_penyakit_sekarang'] ?? $model->riwayat_penyakit_sekarang ?? null;
                $riwayatSebelumnya = $data['riwayat_penyakit_sebelumnya'] ?? $model->riwayat_penyakit_sebelumnya ?? null;
                $riwayatKeluarga = $data['riwayat_penyakit_keluarga'] ?? $model->riwayat_penyakit_keluarga ?? null;
                $riwayatOperasi = $data['riwayat_operasi'] ?? $model->riwayat_operasi ?? null;
                $riwayatDirawat = $data['riwayat_pernah_dirawat'] ?? $model->riwayat_pernah_dirawat ?? null;
                ?>
                <div class="data-item">
                    <div class="data-label">Riwayat Penyakit Sekarang</div>
                    <div class="data-value"><?= $riwayatSekarang ? ucwords($riwayatSekarang) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Riwayat Penyakit Sebelumnya</div>
                    <div class="data-value"><?= $riwayatSebelumnya ? ucwords($riwayatSebelumnya) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Riwayat Penyakit Keluarga</div>
                    <div class="data-value"><?= $riwayatKeluarga ? ucwords($riwayatKeluarga) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Riwayat Operasi</div>
                    <div class="data-value"><?= $riwayatOperasi ? ucwords($riwayatOperasi) : '-' ?></div>
                </div>
                <div class="data-item">
                    <div class="data-label">Riwayat Dirawat di RS</div>
                    <div class="data-value"><?= $riwayatDirawat ? ucwords($riwayatDirawat) : '-' ?></div>
                </div>
            </div>
        </div>

        <!-- Pengkajian Resiko Jatuh -->
        <div class="content-section">
            <h6 class="section-title-modern">
                <div class="section-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                Pengkajian Risiko Jatuh
            </h6>

            <?php
            // Calculate risk score from form data
            $totalRisk = 0;
            $riskItems = [
                'Riwayat jatuh yang baru atau dalam 3 bulan terakhir',
                'Diagnosa medis sekunder > 1',
                'Alat bantu jalan',
                'Ada akses IV atau terapi heparin lock',
                'Cara berjalan/berpindah',
                'Status mental'
            ];

            // Get risk scores from stored data
            $riskScores = [25, 15, 0, 20, 0, 0]; // Default scores
            if (isset($data['resiko_jatuh_scores'])) {
                $riskScores = $data['resiko_jatuh_scores'];
            }

            $totalRisk = array_sum($riskScores);
            ?>

            <div class="risk-assessment-table">
                <table>
                    <thead>
                        <tr>
                            <th width="8%">No</th>
                            <th width="60%">Faktor Risiko</th>
                            <th width="20%">Skala Penilaian</th>
                            <th width="12%">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riskItems as $index => $item): ?>
                            <tr>
                                <td style="text-align: center; font-weight: 600;"><?= $index + 1 ?></td>
                                <td><?= Html::encode($item) ?></td>
                                <td style="font-size: 0.9rem;">
                                    <?php
                                    $scaleOptions = [
                                        0 => 'Tidak = 0<br>Ya = 25',
                                        1 => 'Tidak = 0<br>Ya = 15',
                                        2 => 'Mandiri/Bedrest/Dibantu = 0<br>Penopang/Tongkat = 15<br>Mencengkeram furniture = 15',
                                        3 => 'Tidak = 0<br>Ya = 20',
                                        4 => 'Normal = 0<br>Lemah/Terganggu = 10<br>Orientasi sesuai = 20<br>Lupa keterbatasan = 15',
                                        5 => 'Orientasi baik = 0<br>Lupa keterbatasan = 15'
                                    ];
                                    echo $scaleOptions[$index] ?? '-';
                                    ?>
                                </td>
                                <td style="text-align: center; font-weight: 700; font-size: 1.1rem; color: var(--primary-blue);">
                                    <?= $riskScores[$index] ?? 0 ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background: var(--bg-light);">
                            <td colspan="3" style="text-align: right; font-weight: 700; font-size: 1.1rem;">
                                <i class="fas fa-calculator me-2"></i>
                                Total Skor Risiko:
                            </td>
                            <td style="text-align: center; font-weight: 800; font-size: 1.5rem; color: var(--primary-blue);">
                                <?= $totalRisk ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-center" style="margin-top: 1.5rem;">
                <?php
                $riskCategory = '';
                $riskClass = '';
                $riskIcon = '';
                $riskRecommendation = '';

                if ($totalRisk <= 24) {
                    $riskCategory = 'Tidak Berisiko (0-24)';
                    $riskClass = 'risk-low';
                    $riskIcon = 'fas fa-check-circle';
                    $riskRecommendation = 'Perawatan standar';
                } elseif ($totalRisk <= 44) {
                    $riskCategory = 'Risiko Rendah (25-44)';
                    $riskClass = 'risk-medium';
                    $riskIcon = 'fas fa-exclamation-triangle';
                    $riskRecommendation = 'Lakukan intervensi jatuh standar';
                } else {
                    $riskCategory = 'Risiko Tinggi (≥45)';
                    $riskClass = 'risk-high';
                    $riskIcon = 'fas fa-exclamation-circle';
                    $riskRecommendation = 'Lakukan intervensi jatuh risiko tinggi';
                }
                ?>

                <div class="risk-category-badge <?= $riskClass ?>">
                    <i class="<?= $riskIcon ?>"></i>
                    <span><?= $riskCategory ?></span>
                </div>

                <div style="margin-top: 1rem; padding: 1rem; background: rgba(59, 130, 246, 0.05); border-radius: 8px; border: 2px solid rgba(59, 130, 246, 0.1);">
                    <h6 style="color: var(--primary-blue); margin-bottom: 0.5rem;">
                        <i class="fas fa-stethoscope me-2"></i>
                        Rekomendasi Perawatan
                    </h6>
                    <p style="margin: 0; color: var(--text-dark); font-weight: 500;">
                        <?= $riskRecommendation ?>
                    </p>
                </div>

                <div style="margin-top: 1rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem; font-size: 0.85rem;">
                    <div style="background: rgba(16, 185, 129, 0.1); padding: 0.75rem; border-radius: 6px; border: 1px solid rgba(16, 185, 129, 0.2);">
                        <strong style="color: var(--success);">Tidak berisiko: 0-24</strong><br>
                        <small>Perawatan standar</small>
                    </div>
                    <div style="background: rgba(245, 158, 11, 0.1); padding: 0.75rem; border-radius: 6px; border: 1px solid rgba(245, 158, 11, 0.2);">
                        <strong style="color: var(--warning);">Risiko rendah: 25-44</strong><br>
                        <small>Intervensi standar</small>
                    </div>
                    <div style="background: rgba(239, 68, 68, 0.1); padding: 0.75rem; border-radius: 6px; border: 1px solid rgba(239, 68, 68, 0.2);">
                        <strong style="color: var(--danger);">Risiko tinggi: ≥45</strong><br>
                        <small>Intervensi khusus</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="navigation-section">
        <?= Html::a(
            '<i class="fas fa-arrow-left"></i> Kembali ke Detail Pasien',
            ['view', 'id' => $model->id_registrasi],
            ['class' => 'btn-nav-modern']
        ) ?>
    </div>
</div>

<?php
// Enhanced JavaScript for better user experience
$this->registerJs("
// Enhanced view functionality
$(document).ready(function() {
    console.log('=== FORM VIEW INITIALIZED ===');
    
    // Add smooth scroll for navigation
    $('.btn-nav-modern').on('click', function(e) {
        $(this).addClass('clicked');
        setTimeout(() => {
            $(this).removeClass('clicked');
        }, 200);
    });
    
    // Add print shortcut
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            window.open('" . \yii\helpers\Url::to(['print-form', 'id' => $model->id_form_data]) . "', '_blank');
        }
    });
    
    // Add copy functionality for form ID
    $('.detail-value').on('click', function() {
        var text = $(this).text().trim();
        if (text.startsWith('FM')) {
            navigator.clipboard.writeText(text).then(function() {
                // Show temporary feedback
                var originalText = $('.detail-value:contains(\"' + text + '\")').html();
                $('.detail-value:contains(\"' + text + '\")').html('<i class=\"fas fa-check text-success\"></i> Copied!');
                setTimeout(function() {
                    $('.detail-value:contains(\"Copied!\")').html(originalText);
                }, 1500);
            });
        }
    });
    
    // Enhanced delete confirmation
    $('.btn-delete-modern').on('click', function(e) {
        $(this).addClass('shake');
        setTimeout(() => {
            $(this).removeClass('shake');
        }, 600);
    });
    
    // Add tooltips for better UX
    $('[data-toggle=\"tooltip\"]').tooltip();
    
    console.log('=== FORM VIEW READY ===');
});

// Add shake animation for delete button
$('<style>')
.prop('type', 'text/css')
.html(`
.clicked {
    transform: scale(0.95) !important;
}
.shake {
    animation: shake 0.6s ease-in-out;
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
    20%, 40%, 60%, 80% { transform: translateX(3px); }
}
`)
.appendTo('head');
", \yii\web\View::POS_END);
?>