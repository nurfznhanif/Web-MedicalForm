<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */
/* @var $registrasi app\models\Registrasi */
/* @var $isEdit boolean */

$isEdit = $isEdit ?? false;

$this->title = $isEdit ? 'Edit Form Pengkajian' : 'Form Pengkajian';

// Register CSS
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

.form-container {
    max-width: 1200px;
    margin: 0 auto;
    background: var(--white);
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--border-light);
}

.form-header {
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    color: white;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.form-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: rotate(45deg);
}

.patient-info-card {
    background: linear-gradient(135deg, var(--light-blue), rgba(59, 130, 246, 0.1));
    border: 2px solid var(--secondary-blue);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin: 2rem;
    position: relative;
}

.patient-info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, var(--secondary-blue), var(--accent-yellow));
    border-radius: 2px;
}

.patient-avatar-large {
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
}

.form-section {
    background: var(--white);
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    border: 1px solid var(--border-light);
    overflow: hidden;
    transition: var(--transition);
}

.form-section:hover {
    box-shadow: var(--shadow-md);
}

.section-header {
    background: linear-gradient(135deg, var(--bg-light), #f1f5f9);
    padding: 1.5rem;
    border-bottom: 2px solid var(--border-light);
    cursor: pointer;
    transition: var(--transition);
}

.section-header:hover {
    background: linear-gradient(135deg, var(--light-blue), rgba(59, 130, 246, 0.1));
}

.section-title {
    color: var(--primary-blue);
    font-weight: 700;
    font-size: 1.2rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
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

.section-content {
    padding: 2rem;
}

.section-content.collapsed {
    display: none;
}

.form-group-modern {
    margin-bottom: 1.5rem;
}

.form-label-modern {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.95rem;
}

.form-control-modern {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-light);
    border-radius: 8px;
    font-size: 0.9rem;
    transition: var(--transition);
    background: var(--white);
}

.form-control-modern:focus {
    outline: none;
    border-color: var(--secondary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 0.75rem;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--bg-light);
    border: 2px solid transparent;
    border-radius: 8px;
    transition: var(--transition);
    cursor: pointer;
}

.checkbox-item:hover {
    background: var(--light-blue);
    border-color: var(--secondary-blue);
    transform: translateY(-1px);
}

.checkbox-item input[type='checkbox'],
.checkbox-item input[type='radio'] {
    width: 18px;
    height: 18px;
    accent-color: var(--secondary-blue);
}

.checkbox-item.checked {
    background: var(--light-blue);
    border-color: var(--secondary-blue);
    color: var(--primary-blue);
    font-weight: 600;
}

.vital-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.anthropometry-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.bmi-calculator {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.05));
    border: 2px solid rgba(16, 185, 129, 0.2);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-top: 1rem;
    text-align: center;
}

.bmi-result {
    font-size: 2rem;
    font-weight: 700;
    color: var(--success);
    margin: 0.5rem 0;
}

.risk-table {
    background: var(--white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
}

.risk-table table {
    width: 100%;
    margin: 0;
}

.risk-table th {
    background: linear-gradient(135deg, var(--primary-blue), #1e40af);
    color: white;
    padding: 1rem;
    font-weight: 600;
    text-align: left;
}

.risk-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-light);
    vertical-align: middle;
}

.risk-table tr:hover td {
    background: var(--bg-light);
}

.risk-select {
    width: 100%;
    padding: 0.5rem;
    border: 2px solid var(--border-light);
    border-radius: 8px;
    transition: var(--transition);
}

.risk-select:focus {
    border-color: var(--secondary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.risk-score-panel {
    background: linear-gradient(135deg, var(--white), var(--bg-light));
    border: 2px solid var(--border-light);
    border-radius: var(--border-radius);
    padding: 2rem;
    text-align: center;
    position: sticky;
    top: 2rem;
}

.total-score {
    font-size: 3rem;
    font-weight: 800;
    color: var(--primary-blue);
    margin: 1rem 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.risk-category {
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    font-weight: 700;
    font-size: 1rem;
    margin-top: 1rem;
    display: inline-block;
    transition: var(--transition);
}

.risk-low {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    color: var(--success);
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.risk-medium {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
    color: var(--accent-yellow);
    border: 2px solid rgba(245, 158, 11, 0.3);
}

.risk-high {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
    color: var(--danger);
    border: 2px solid rgba(239, 68, 68, 0.3);
}

.action-section {
    background: var(--bg-light);
    padding: 2rem;
    border-top: 2px solid var(--border-light);
    text-align: center;
}

.btn-modern {
    padding: 1rem 2rem;
    border-radius: var(--border-radius);
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0.5rem;
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-primary-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
}

.btn-success-modern {
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-success-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
}

.btn-secondary-modern {
    background: var(--white);
    color: var(--text-dark);
    border: 2px solid var(--border-light);
    box-shadow: var(--shadow-sm);
}

.btn-secondary-modern:hover {
    background: var(--bg-light);
    border-color: var(--secondary-blue);
    color: var(--secondary-blue);
    transform: translateY(-2px);
}

.additional-fields {
    display: none;
    margin-top: 1rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border: 2px dashed var(--secondary-blue);
    border-radius: 8px;
}

.additional-fields.show {
    display: block;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .form-container {
        margin: 1rem;
        border-radius: var(--border-radius);
    }
    
    .form-header {
        padding: 1.5rem;
    }
    
    .section-content {
        padding: 1.5rem;
    }
    
    .checkbox-group {
        grid-template-columns: 1fr;
    }
    
    .vital-grid,
    .anthropometry-grid {
        grid-template-columns: 1fr;
    }
    
    .patient-info-card {
        text-align: center;
    }
    
    .patient-avatar-large {
        margin: 0 auto 1rem;
    }
    
    .risk-score-panel {
        position: static;
        margin-top: 2rem;
    }
    
    .btn-modern {
        width: 100%;
        justify-content: center;
        margin: 0.5rem 0;
    }
}
");

// Register JavaScript
$this->registerJs("
// IMT CALCULATION
function hitungIMT() {
    var berat = parseFloat(document.getElementById('dataform-antro_berat').value);
    var tinggi = parseFloat(document.getElementById('dataform-antro_tinggi').value);
    
    if (berat && tinggi && tinggi > 0) {
        var tinggiMeter = tinggi / 100;
        var imt = berat / (tinggiMeter * tinggiMeter);
        var imtBulat = Math.round(imt * 100) / 100;
        
        document.getElementById('dataform-antro_imt').value = imtBulat;
        document.getElementById('imtValue').innerText = imtBulat;
        
        var kategori = '';
        var statusGizi = '';
        
        if (imtBulat < 18.5) {
            kategori = 'Kurang Berat Badan';
            statusGizi = 'kurang';
        } else if (imtBulat <= 25.0) {
            kategori = 'Normal';
            statusGizi = 'ideal';
        } else if (imtBulat <= 27.0) {
            kategori = 'Gemuk';
            statusGizi = 'obesitas';
        } else {
            kategori = 'Obesitas';
            statusGizi = 'obesitas';
        }
        
        document.getElementById('imtCategory').innerText = kategori;
        document.getElementById('imtResult').style.display = 'block';
        
        var radioGizi = document.querySelectorAll('input[name=\"DataForm[status_gizi]\"]');
        radioGizi.forEach(function(radio) {
            radio.checked = (radio.value === statusGizi);
        });
        
        console.log('IMT:', imtBulat, 'Kategori:', kategori, 'Status Gizi:', statusGizi);
    } else {
        document.getElementById('dataform-antro_imt').value = '';
        document.getElementById('imtResult').style.display = 'none';
    }
}

// RESIKO JATUH CALCULATION
function hitungResikoJatuh() {
    var total = 0;
    
    for (var i = 1; i <= 6; i++) {
        var pilihan = document.querySelector('select[name=\"risk' + i + '\"]');
        if (pilihan) {
            var skor = parseInt(pilihan.value) || 0;
            total += skor;
            
            var scoreElement = document.getElementById('score' + i);
            if (scoreElement) {
                scoreElement.textContent = skor;
            }
        }
    }
    
    document.getElementById('totalScore').innerText = total;
    
    var kategori = '';
    var className = '';
    
    if (total <= 24) {
        kategori = 'Tidak berisiko (0-24)';
        className = 'risk-low';
    } else if (total <= 44) {
        kategori = 'Resiko rendah (25-44)';
        className = 'risk-medium';
    } else {
        kategori = 'Resiko tinggi (≥45)';
        className = 'risk-high';
    }
    
    var categoryElement = document.getElementById('riskCategory');
    categoryElement.innerText = kategori;
    categoryElement.className = 'risk-category ' + className;
    
    console.log('Total Resiko:', total, 'Kategori:', kategori);
}

// TOGGLE ADDITIONAL FIELDS
function toggleOperasi() {
    var operasiYa = document.querySelector('input[name=\"DataForm[riwayat_operasi]\"][value=\"ya\"]');
    var operasiFields = document.getElementById('operasiFields');
    if (operasiYa && operasiYa.checked) {
        operasiFields.classList.add('show');
    } else {
        operasiFields.classList.remove('show');
    }
}

function toggleDirawat() {
    var dirawatYa = document.querySelector('input[name=\"DataForm[riwayat_pernah_dirawat]\"][value=\"ya\"]');
    var dirawatFields = document.getElementById('dirawatFields');
    if (dirawatYa && dirawatYa.checked) {
        dirawatFields.classList.add('show');
    } else {
        dirawatFields.classList.remove('show');
    }
}

// Toggle section visibility
function toggleSection(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('.fa-chevron-down, .fa-chevron-up');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        if (icon) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        }
    } else {
        content.classList.add('collapsed');
        if (icon) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
}

// Update checkbox visual state
function updateCheckboxState(input) {
    const container = input.closest('.checkbox-item');
    const allContainers = container.parentElement.querySelectorAll('.checkbox-item');
    
    allContainers.forEach(c => c.classList.remove('checked'));
    
    if (input.checked) {
        container.classList.add('checked');
    }
}

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    var now = new Date();
    var tanggalSekarang = now.toISOString().split('T')[0];
    var jamSekarang = now.toTimeString().slice(0, 5);
    
    var tanggalField = document.getElementById('dataform-tanggal_pengkajian');
    var jamField = document.getElementById('dataform-jam_pengkajian');
    
    if (tanggalField && !tanggalField.value) {
        tanggalField.value = tanggalSekarang;
    }
    if (jamField && !jamField.value) {
        jamField.value = jamSekarang;
    }
    
    var beratField = document.getElementById('dataform-antro_berat');
    var tinggiField = document.getElementById('dataform-antro_tinggi');
    
    if (beratField) {
        beratField.addEventListener('input', hitungIMT);
        beratField.addEventListener('keyup', hitungIMT);
    }
    if (tinggiField) {
        tinggiField.addEventListener('input', hitungIMT);
        tinggiField.addEventListener('keyup', hitungIMT);
    }
    
    var riskSelects = document.querySelectorAll('select[name^=\"risk\"]');
    riskSelects.forEach(function(select) {
        select.addEventListener('change', hitungResikoJatuh);
    });
    
    var operasiInputs = document.querySelectorAll('input[name=\"DataForm[riwayat_operasi]\"]');
    operasiInputs.forEach(function(input) {
        input.addEventListener('change', toggleOperasi);
    });
    
    var dirawatInputs = document.querySelectorAll('input[name=\"DataForm[riwayat_pernah_dirawat]\"]');
    dirawatInputs.forEach(function(input) {
        input.addEventListener('change', toggleDirawat);
    });
    
    document.querySelectorAll('input[type=\"radio\"], input[type=\"checkbox\"]').forEach(input => {
        input.addEventListener('change', function() {
            updateCheckboxState(this);
        });
        
        if (input.checked) {
            updateCheckboxState(input);
        }
    });
    
    hitungResikoJatuh();
    hitungIMT();
    
    console.log('=== MEDICAL FORM READY ===');
    console.log('IMT calculation: ENABLED');
    console.log('Risk calculation: ENABLED');
});

// Save form function
function saveForm() {
    const form = document.getElementById('medical-form');
    if (form) {
        form.submit();
    }
}

// Print form function
function printForm() {
    window.print();
}
", \yii\web\View::POS_HEAD);
?>
<!-- Title -->
<div class="text-center mb-4">
    <h3><strong>PENGKAJIAN</strong></h3>
</div>

<!-- Patient Info Section -->
<div class="patient-info-card">
    <div class="row align-items-center">
        <div class="col-auto">
            <div class="patient-avatar-large">
                <?= strtoupper(substr($registrasi->nama_pasien, 0, 2)) ?>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2"><strong>Nama Lengkap:</strong> <?= Html::encode($registrasi->nama_pasien) ?></div>
                    <div class="mb-2"><strong>Tanggal Lahir:</strong> <?= $registrasi->tanggal_lahir ? date('d/m/Y', strtotime($registrasi->tanggal_lahir)) : '-' ?></div>
                    <div><strong>No. RM:</strong> <?= Html::encode($registrasi->no_rekam_medis) ?></div>
                </div>
                <div class="col-md-6">
                    <div style="border: 2px solid var(--secondary-blue); padding: 15px; border-radius: 8px; text-align: center; background: var(--white);">
                        <div><strong>Petugas</strong></div>
                        <div><strong>Tanggal / pukul:</strong> <?= date('d/m/Y H:i') ?></div>
                        <div><strong>Form ID:</strong> <?= $isEdit ? 'FM' . str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) : 'Baru' ?></div>
                        <div><strong>Status:</strong> <?= $isEdit ? 'Edit' : 'Input' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-container">
    <?php $form = ActiveForm::begin([
        'id' => 'medical-form',
        'options' => ['class' => 'needs-validation', 'novalidate' => true],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label-modern'],
            'inputOptions' => ['class' => 'form-control-modern'],
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

    <!-- Basic Information -->
    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                Informasi Dasar Pengkajian
            </h3>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-calendar me-2"></i>
                            Tanggal Pengkajian
                        </label>
                        <?= $form->field($model, 'tanggal_pengkajian', ['template' => '{input}'])->input('date', [
                            'value' => $model->tanggal_pengkajian ?: date('Y-m-d'),
                            'required' => true,
                            'class' => 'form-control-modern'
                        ]) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-clock me-2"></i>
                            Jam Pengkajian
                        </label>
                        <?= $form->field($model, 'jam_pengkajian', ['template' => '{input}'])->input('time', [
                            'value' => $model->jam_pengkajian ?: date('H:i'),
                            'required' => true,
                            'class' => 'form-control-modern'
                        ]) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-hospital me-2"></i>
                            Poliklinik
                        </label>
                        <?= $form->field($model, 'poliklinik', ['template' => '{input}'])->textInput([
                            'value' => $model->poliklinik ?: 'KLINIK OBGYN',
                            'required' => true,
                            'class' => 'form-control-modern'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Initial Assessment Section -->
    <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                Pengkajian Saat Datang
                <i class="fas fa-chevron-down ms-auto"></i>
            </h3>
        </div>
        <div class="section-content collapsed">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-walking me-2"></i>
                            1. Cara Masuk
                        </label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'jalan_tanpa_bantuan', [
                                    'value' => 'jalan_tanpa_bantuan',
                                    'id' => 'cara1'
                                ]) ?>
                                <label for="cara1">Jalan tanpa bantuan</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'kursi_tanpa_bantuan', [
                                    'value' => 'kursi_tanpa_bantuan',
                                    'id' => 'cara2'
                                ]) ?>
                                <label for="cara2">Kursi tanpa bantuan</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'tempat_tidur_dorong', [
                                    'value' => 'tempat_tidur_dorong',
                                    'id' => 'cara3'
                                ]) ?>
                                <label for="cara3">Tempat tidur dorong</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'lain_lain', [
                                    'value' => 'lain_lain',
                                    'id' => 'cara4'
                                ]) ?>
                                <label for="cara4">Lain-lain</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-comments me-2"></i>
                            2. Anamnesis
                        </label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[anamnesis]', $model->anamnesis == 'autoanamnesis', [
                                    'value' => 'autoanamnesis',
                                    'id' => 'anam1'
                                ]) ?>
                                <label for="anam1">Autoanamnesis</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[anamnesis]', $model->anamnesis == 'aloanamnesis', [
                                    'value' => 'aloanamnesis',
                                    'id' => 'anam2'
                                ]) ?>
                                <label for="anam2">Aloanamnesis</label>
                            </div>
                        </div>
                        <div class="additional-fields" id="anamnesisDetails">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label-modern">Diperoleh dari:</label>
                                    <?= Html::textInput('anamnesis_diperoleh', '', ['class' => 'form-control-modern', 'placeholder' => 'Nama sumber']) ?>
                                </div>
                                <div class="col-6">
                                    <label class="form-label-modern">Hubungan:</label>
                                    <?= Html::textInput('anamnesis_hubungan', '', ['class' => 'form-control-modern', 'placeholder' => 'Hubungan dengan pasien']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group-modern">
                <label class="form-label-modern">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Alergi / Riwayat Alergi
                </label>
                <?= $form->field($model, 'alergi', ['template' => '{input}'])->textInput([
                    'class' => 'form-control-modern',
                    'placeholder' => 'Contoh: Tidak ada alergi yang diketahui',
                    'value' => $model->alergi ?: 'Tidak ada alergi yang diketahui'
                ]) ?>
            </div>

            <div class="form-group-modern">
                <label class="form-label-modern">
                    <i class="fas fa-stethoscope me-2"></i>
                    3. Keluhan Utama Saat Ini
                </label>
                <?= $form->field($model, 'keluhan_utama', ['template' => '{input}'])->textarea([
                    'class' => 'form-control-modern',
                    'rows' => 4,
                    'placeholder' => 'Masukkan keluhan utama pasien...',
                    'value' => $model->keluhan_utama ?: 'Nyeri perut bagian bawah, flek darah sejak 2 hari yang lalu, mual ringan'
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Physical Examination Section -->
    <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                4. Pemeriksaan Fisik
                <i class="fas fa-chevron-down ms-auto"></i>
            </h3>
        </div>
        <div class="section-content collapsed">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">a. Keadaan Umum</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'tidak_tampak_sakit', [
                                    'value' => 'tidak_tampak_sakit',
                                    'id' => 'keadaan1',
                                    'checked' => !$model->keadaan_umum || $model->keadaan_umum == 'tidak_tampak_sakit'
                                ]) ?>
                                <label for="keadaan1">Tidak tampak sakit</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'sakit_ringan', [
                                    'value' => 'sakit_ringan',
                                    'id' => 'keadaan2'
                                ]) ?>
                                <label for="keadaan2">Sakit ringan</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'sedang', [
                                    'value' => 'sedang',
                                    'id' => 'keadaan3'
                                ]) ?>
                                <label for="keadaan3">Sedang</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'berat', [
                                    'value' => 'berat',
                                    'id' => 'keadaan4'
                                ]) ?>
                                <label for="keadaan4">Berat</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">b. Warna Kulit</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'normal', [
                                    'value' => 'normal',
                                    'id' => 'kulit1',
                                    'checked' => !$model->warna_kulit || $model->warna_kulit == 'normal'
                                ]) ?>
                                <label for="kulit1">Normal</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'sianosis', [
                                    'value' => 'sianosis',
                                    'id' => 'kulit2'
                                ]) ?>
                                <label for="kulit2">Sianosis</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'pucat', [
                                    'value' => 'pucat',
                                    'id' => 'kulit3'
                                ]) ?>
                                <label for="kulit3">Pucat</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'kemerahan', [
                                    'value' => 'kemerahan',
                                    'id' => 'kulit4'
                                ]) ?>
                                <label for="kulit4">Kemerahan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Kesadaran</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'compos_mentis', [
                                    'value' => 'compos_mentis',
                                    'id' => 'sadar1',
                                    'checked' => !$model->kesadaran || $model->kesadaran == 'compos_mentis'
                                ]) ?>
                                <label for="sadar1">Compos mentis</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'apatis', [
                                    'value' => 'apatis',
                                    'id' => 'sadar2'
                                ]) ?>
                                <label for="sadar2">Apatis</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'somnolent', [
                                    'value' => 'somnolent',
                                    'id' => 'sadar3'
                                ]) ?>
                                <label for="sadar3">Somnolent</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'sopor', [
                                    'value' => 'sopor',
                                    'id' => 'sadar4'
                                ]) ?>
                                <label for="sadar4">Sopor</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda Vital -->
            <div class="form-group-modern">
                <label class="form-label-modern">
                    <i class="fas fa-heartbeat me-2"></i>
                    Tanda Vital
                </label>
                <div class="vital-grid">
                    <div>
                        <label class="form-label-modern">Tekanan Darah (TD)</label>
                        <?= $form->field($model, 'tanda_vital_td', ['template' => '{input}'])->textInput([
                            'class' => 'form-control-modern',
                            'placeholder' => '130/80 mmHg',
                            'value' => $model->tanda_vital_td ?: '130/80 mmHg'
                        ]) ?>
                    </div>
                    <div>
                        <label class="form-label-modern">Pernapasan (P)</label>
                        <?= $form->field($model, 'tanda_vital_p', ['template' => '{input}'])->textInput([
                            'class' => 'form-control-modern',
                            'placeholder' => '20 x/menit',
                            'value' => $model->tanda_vital_p ?: '20 x/menit'
                        ]) ?>
                    </div>
                    <div>
                        <label class="form-label-modern">Nadi (N)</label>
                        <?= $form->field($model, 'tanda_vital_n', ['template' => '{input}'])->textInput([
                            'class' => 'form-control-modern',
                            'placeholder' => '80 x/menit',
                            'value' => $model->tanda_vital_n ?: '80 x/menit'
                        ]) ?>
                    </div>
                    <div>
                        <label class="form-label-modern">Suhu (S)</label>
                        <?= $form->field($model, 'tanda_vital_s', ['template' => '{input}'])->textInput([
                            'class' => 'form-control-modern',
                            'placeholder' => '36.5°C',
                            'value' => $model->tanda_vital_s ?: '36.5°C'
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Anthropometry -->
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-weight me-2"></i>
                            Antropometri
                        </label>
                        <div class="anthropometry-grid">
                            <div>
                                <label class="form-label-modern">Berat Badan (Kg)</label>
                                <?= $form->field($model, 'antro_berat', ['template' => '{input}'])->textInput([
                                    'class' => 'form-control-modern',
                                    'type' => 'number',
                                    'step' => '0.1',
                                    'placeholder' => '60',
                                    'value' => $model->antro_berat ?: '62'
                                ]) ?>
                            </div>
                            <div>
                                <label class="form-label-modern">Tinggi Badan (Cm)</label>
                                <?= $form->field($model, 'antro_tinggi', ['template' => '{input}'])->textInput([
                                    'class' => 'form-control-modern',
                                    'type' => 'number',
                                    'step' => '0.1',
                                    'placeholder' => '160',
                                    'value' => $model->antro_tinggi ?: '160'
                                ]) ?>
                            </div>
                            <div>
                                <label class="form-label-modern">Panjang Badan (Cm)</label>
                                <?= $form->field($model, 'antro_panjang', ['template' => '{input}'])->textInput([
                                    'class' => 'form-control-modern',
                                    'type' => 'number',
                                    'step' => '0.1',
                                    'placeholder' => '80'
                                ]) ?>
                            </div>
                            <div>
                                <label class="form-label-modern">Linkar Kepala (Cm)</label>
                                <?= $form->field($model, 'antro_lingkar', ['template' => '{input}'])->textInput([
                                    'class' => 'form-control-modern',
                                    'type' => 'number',
                                    'step' => '0.1',
                                    'placeholder' => '80'
                                ]) ?>
                            </div>
                            <div>
                                <label class="form-label-modern">IMT</label>
                                <?= $form->field($model, 'antro_imt', ['template' => '{input}'])->textInput([
                                    'class' => 'form-control-modern',
                                    'readonly' => true
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bmi-calculator" id="imtResult" style="display: none;">
                        <h6 style="color: var(--success); margin-bottom: 1rem;">
                            <i class="fas fa-calculator me-2"></i>
                            Hasil BMI
                        </h6>
                        <div class="bmi-result" id="imtValue">24.2</div>
                        <div id="imtCategory" style="color: var(--text-light); font-weight: 600;">Normal</div>
                        <small class="text-muted d-block mt-2">
                            BMI dihitung otomatis
                        </small>
                    </div>
                </div>
            </div>

            <!-- Status Gizi -->
            <div class="form-group-modern">
                <label class="form-label-modern">
                    <i class="fas fa-apple-alt me-2"></i>
                    c. Status Gizi
                </label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'ideal', [
                            'value' => 'ideal',
                            'id' => 'gizi1',
                            'checked' => !$model->status_gizi || $model->status_gizi == 'ideal'
                        ]) ?>
                        <label for="gizi1">Ideal</label>
                    </div>
                    <div class="checkbox-item">
                        <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'kurang', [
                            'value' => 'kurang',
                            'id' => 'gizi2'
                        ]) ?>
                        <label for="gizi2">Kurang</label>
                    </div>
                    <div class="checkbox-item">
                        <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'obesitas', [
                            'value' => 'obesitas',
                            'id' => 'gizi3'
                        ]) ?>
                        <label for="gizi3">Obesitas / Overweight</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical History Section -->
    <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-history"></i>
                </div>
                Riwayat Penyakit dan Operasi
                <i class="fas fa-chevron-down ms-auto"></i>
            </h3>
        </div>
        <div class="section-content collapsed">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">5. Riwayat Penyakit Sekarang</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'dm', [
                                    'value' => 'dm',
                                    'id' => 'sekarang1'
                                ]) ?>
                                <label for="sekarang1">DM</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'hipertensi', [
                                    'value' => 'hipertensi',
                                    'id' => 'sekarang2'
                                ]) ?>
                                <label for="sekarang2">Hipertensi</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'jantung', [
                                    'value' => 'jantung',
                                    'id' => 'sekarang3'
                                ]) ?>
                                <label for="sekarang3">Jantung</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'tidak_ada', [
                                    'value' => 'tidak_ada',
                                    'id' => 'sekarang4',
                                    'checked' => !$model->riwayat_penyakit_sekarang || $model->riwayat_penyakit_sekarang == 'tidak_ada'
                                ]) ?>
                                <label for="sekarang4">Tidak Ada</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">6. Riwayat Penyakit Sebelumnya</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', $model->riwayat_penyakit_sebelumnya == 'tidak', [
                                    'value' => 'tidak',
                                    'id' => 'sebelum1',
                                    'checked' => !$model->riwayat_penyakit_sebelumnya || $model->riwayat_penyakit_sebelumnya == 'tidak'
                                ]) ?>
                                <label for="sebelum1">Tidak</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', $model->riwayat_penyakit_sebelumnya == 'ya', [
                                    'value' => 'ya',
                                    'id' => 'sebelum2'
                                ]) ?>
                                <label for="sebelum2">Ya</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-modern">
                        <label class="form-label-modern">7. Riwayat Penyakit Keluarga</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', $model->riwayat_penyakit_keluarga == 'tidak', [
                                    'value' => 'tidak',
                                    'id' => 'keluarga1',
                                    'checked' => !$model->riwayat_penyakit_keluarga || $model->riwayat_penyakit_keluarga == 'tidak'
                                ]) ?>
                                <label for="keluarga1">Tidak</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', $model->riwayat_penyakit_keluarga == 'ya', [
                                    'value' => 'ya',
                                    'id' => 'keluarga2'
                                ]) ?>
                                <label for="keluarga2">Ya</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label class="form-label-modern">9. Riwayat Operasi</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'tidak', [
                                    'value' => 'tidak',
                                    'id' => 'operasi1',
                                    'checked' => !$model->riwayat_operasi || $model->riwayat_operasi == 'tidak'
                                ]) ?>
                                <label for="operasi1">Tidak</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'ya', [
                                    'value' => 'ya',
                                    'id' => 'operasi2'
                                ]) ?>
                                <label for="operasi2">Ya</label>
                            </div>
                        </div>
                        <div class="additional-fields" id="operasiFields">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label-modern">Operasi apa?</label>
                                    <?= Html::textInput('operasi_apa', 'APP', ['class' => 'form-control-modern', 'placeholder' => 'Contoh: Appendektomi']) ?>
                                </div>
                                <div class="col-6">
                                    <label class="form-label-modern">Kapan?</label>
                                    <?= Html::textInput('operasi_kapan', '2017', ['class' => 'form-control-modern', 'placeholder' => 'Contoh: 2020']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label class="form-label-modern">10. Riwayat Dirawat di RS</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'tidak', [
                                    'value' => 'tidak',
                                    'id' => 'dirawat1',
                                    'checked' => !$model->riwayat_pernah_dirawat || $model->riwayat_pernah_dirawat == 'tidak'
                                ]) ?>
                                <label for="dirawat1">Tidak</label>
                            </div>
                            <div class="checkbox-item">
                                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'ya', [
                                    'value' => 'ya',
                                    'id' => 'dirawat2'
                                ]) ?>
                                <label for="dirawat2">Ya</label>
                            </div>
                        </div>
                        <div class="additional-fields" id="dirawatFields">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label-modern">Penyakit apa?</label>
                                    <?= Html::textInput('penyakit_apa', 'post app', ['class' => 'form-control-modern', 'placeholder' => 'Contoh: Pneumonia']) ?>
                                </div>
                                <div class="col-6">
                                    <label class="form-label-modern">Kapan?</label>
                                    <?= Html::textInput('dirawat_kapan', '2017', ['class' => 'form-control-modern', 'placeholder' => 'Contoh: 2019']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fall Risk Assessment Section -->
    <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                15. Pengkajian Risiko Jatuh
                <i class="fas fa-chevron-down ms-auto"></i>
            </h3>
        </div>
        <div class="section-content collapsed">
            <div class="row">
                <div class="col-lg-8">
                    <div class="risk-table">
                        <table>
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="50%">Faktor Risiko</th>
                                    <th width="30%">Skala Penilaian</th>
                                    <th width="15%">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Riwayat jatuh yang baru atau dalam 3 bulan terakhir</td>
                                    <td>
                                        <select class="risk-select" name="risk1" onchange="hitungResikoJatuh()">
                                            <option value="0">Tidak (0)</option>
                                            <option value="25">Ya (25)</option>
                                        </select>
                                    </td>
                                    <td class="text-center" id="score1">0</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Diagnosa medis sekunder &gt; 1</td>
                                    <td>
                                        <select class="risk-select" name="risk2" onchange="hitungResikoJatuh()">
                                            <option value="0">Tidak (0)</option>
                                            <option value="15">Ya (15)</option>
                                        </select>
                                    </td>
                                    <td class="text-center" id="score2">0</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Alat bantu jalan</td>
                                    <td>
                                        <select class="risk-select" name="risk3" onchange="hitungResikoJatuh()">
                                            <option value="0">Mandiri/Bedrest/Dibantu (0)</option>
                                            <option value="15">Penopang/Tongkat/Walker (15)</option>
                                            <option value="15">Mencengkeram furniture (15)</option>
                                        </select>
                                    </td>
                                    <td class="text-center" id="score3">0</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Ada akses IV atau terapi heparin lock</td>
                                    <td>
                                        <select class="risk-select" name="risk4" onchange="hitungResikoJatuh()">
                                            <option value="0">Tidak (0)</option>
                                            <option value="20">Ya (20)</option>
                                        </select>
                                    </td>
                                    <td class="text-center" id="score4">0</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Cara berjalan/berpindah</td>
                                    <td>
                                        <select class="risk-select" name="risk5" onchange="hitungResikoJatuh()">
                                            <option value="0">Normal (0)</option>
                                            <option value="10">Lemah, langkah terseret (10)</option>
                                            <option value="20">Terganggu, perlu bantuan (20)</option>
                                        </select>
                                    </td>
                                    <td class="text-center" id="score5">0</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Status mental</td>
                                    <td>
                                        <select class="risk-select" name="risk6" onchange="hitungResikoJatuh()">
                                            <option value="0">Orientasi baik terhadap kemampuan diri (0)</option>
                                            <option value="15">Lupa keterbatasan diri (15)</option>
                                        </select>
                                    </td>
                                    <td class="text-center" id="score6">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="risk-score-panel">
                        <h5 style="color: var(--primary-blue); margin-bottom: 1rem;">
                            <i class="fas fa-chart-line me-2"></i>
                            Total Skor Risiko
                        </h5>
                        <div class="total-score" id="totalScore">0</div>
                        <div class="risk-category risk-low" id="riskCategory">
                            Tidak Berisiko (0-24)
                        </div>

                        <div class="mt-4">
                            <div style="background: rgba(16, 185, 129, 0.1); padding: 1rem; border-radius: 8px; margin-bottom: 0.5rem; border: 2px solid rgba(16, 185, 129, 0.2);">
                                <strong style="color: var(--success);">Tidak berisiko: 0-24</strong><br>
                                <small>Perawatan standar</small>
                            </div>
                            <div style="background: rgba(245, 158, 11, 0.1); padding: 1rem; border-radius: 8px; margin-bottom: 0.5rem; border: 2px solid rgba(245, 158, 11, 0.2);">
                                <strong style="color: var(--accent-yellow);">Risiko rendah: 25-44</strong><br>
                                <small>Intervensi jatuh standar</small>
                            </div>
                            <div style="background: rgba(239, 68, 68, 0.1); padding: 1rem; border-radius: 8px; border: 2px solid rgba(239, 68, 68, 0.2);">
                                <strong style="color: var(--danger);">Risiko tinggi: ≥45</strong><br>
                                <small>Intervensi jatuh risiko tinggi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden fields untuk menyimpan data -->
    <?= Html::hiddenInput('DataForm[total_resiko_jatuh]', '', ['id' => 'hiddenTotalScore']) ?>
    <?= Html::hiddenInput('DataForm[kategori_resiko_jatuh]', '', ['id' => 'hiddenRiskCategory']) ?>

    <?php ActiveForm::end(); ?>

    <!-- Action Buttons -->
    <div class="action-section">
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button type="button" class="btn-modern btn-success-modern" onclick="saveForm()">
                <i class="fas fa-save"></i>
                <?= $isEdit ? 'Update Data' : 'Simpan Data' ?>
            </button>
            <?= Html::a(
                '<i class="fas fa-arrow-left"></i> Kembali',
                $isEdit ? ['view-form', 'id' => $model->id_form_data] : ['view', 'id' => $registrasi->id_registrasi],
                ['class' => 'btn-modern btn-secondary-modern']
            ) ?>
        </div>
    </div>
</div>

<script>
    // Additional JavaScript functions
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize anamnesis toggle
        document.querySelectorAll('input[name="DataForm[anamnesis]"]').forEach(input => {
            input.addEventListener('change', function() {
                const anamnesisDetails = document.getElementById('anamnesisDetails');
                if (this.value === 'aloanamnesis' && this.checked) {
                    anamnesisDetails.classList.add('show');
                } else {
                    anamnesisDetails.classList.remove('show');
                }
            });
        });

        // Initialize with current values
        const checkedAnamnesis = document.querySelector('input[name="DataForm[anamnesis]"]:checked');
        if (checkedAnamnesis && checkedAnamnesis.value === 'aloanamnesis') {
            document.getElementById('anamnesisDetails').classList.add('show');
        }

        // Initialize operasi and dirawat toggles
        const operasiYa = document.querySelector('input[name="DataForm[riwayat_operasi]"][value="ya"]');
        const dirawatYa = document.querySelector('input[name="DataForm[riwayat_pernah_dirawat]"][value="ya"]');

        if (operasiYa && operasiYa.checked) {
            document.getElementById('operasiFields').classList.add('show');
        }

        if (dirawatYa && dirawatYa.checked) {
            document.getElementById('dirawatFields').classList.add('show');
        }

        // Auto-save functionality (optional)
        setInterval(function() {
            // Simple auto-save indication
            console.log('Auto-save check...');
        }, 30000);

        // Form validation before submit
        const form = document.getElementById('medical-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Add any validation logic here
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = 'var(--danger)';
                    } else {
                        field.style.borderColor = 'var(--border-light)';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Harap lengkapi semua field yang wajib diisi');
                    return false;
                }

                // Update hidden fields with risk assessment data
                document.getElementById('hiddenTotalScore').value = document.getElementById('totalScore').textContent;
                document.getElementById('hiddenRiskCategory').value = document.getElementById('riskCategory').textContent;
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + S: Save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveForm();
            }

            // Ctrl + P: Print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printForm();
            }
        });

        // Show success message for edit mode
        <?php if ($isEdit): ?>
            console.log('Form edit mode enabled');
        <?php endif; ?>
    });

    // Enhanced save function
    function saveForm() {
        const form = document.getElementById('medical-form');
        if (form) {
            // Add loading state
            const submitButton = document.querySelector('.btn-success-modern');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitButton.disabled = true;

            // Submit the form
            form.submit();
        }
    }

    // Enhanced print function
    function printForm() {
        // Expand all sections before printing
        document.querySelectorAll('.section-content.collapsed').forEach(content => {
            content.classList.remove('collapsed');
        });

        // Add print-specific styles
        const printStyles = document.createElement('style');
        printStyles.innerHTML = `
        @media print {
            body * { visibility: hidden; }
            .form-container, .form-container * { visibility: visible; }
            .form-container { 
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .action-section, .btn-modern { display: none !important; }
            .section-header { background: #f0f0f0 !important; }
            .checkbox-item { border: 1px solid #ccc !important; }
            .risk-table { page-break-inside: avoid; }
        }
    `;
        document.head.appendChild(printStyles);

        window.print();

        // Remove print styles after printing
        setTimeout(() => {
            document.head.removeChild(printStyles);
        }, 1000);
    }

    // Test functions for debugging
    window.testIMT = function(berat, tinggi) {
        document.getElementById('dataform-antro_berat').value = berat || 70;
        document.getElementById('dataform-antro_tinggi').value = tinggi || 170;
        hitungIMT();
        console.log('Test IMT completed');
    };

    window.testRisk = function() {
        // Set some test values
        document.querySelector('select[name="risk1"]').value = '25';
        document.querySelector('select[name="risk2"]').value = '15';
        document.querySelector('select[name="risk4"]').value = '20';
        hitungResikoJatuh();
        console.log('Test Risk Assessment completed');
    };
</script>