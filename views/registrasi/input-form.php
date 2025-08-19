<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */
/* @var $registrasi app\models\Registrasi */
/* @var $isEdit boolean */

$isEdit = $isEdit ?? false;

$this->title = $isEdit ? 'Edit Form Pengkajian' : 'Form Pengkajian Keperawatan Poliklinik Kebidanan';

// Register CSS
$this->registerCss("
.form-section {
    background: #f8f9fa;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
}
.section-title {
    color: #495057;
    font-weight: bold;
    border-bottom: 2px solid #007bff;
    padding-bottom: 8px;
    margin-bottom: 15px;
}
.checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 10px;
}
.checkbox-group .form-check {
    margin-right: 15px;
    margin-bottom: 5px;
}
.patient-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}
.logo-section {
    text-align: right;
    color: #FF6B35;
    font-weight: bold;
    font-size: 18px;
}
.vital-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}
.antropometri-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}
.additional-fields {
    display: none;
    margin-top: 10px;
    padding: 10px;
    background: #f0f0f0;
    border-radius: 5px;
}
.imt-result {
    background: #e3f2fd;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}
.total-score {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
}
.risk-category {
    padding: 5px 10px;
    border-radius: 15px;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}
.risk-low { background-color: #d4edda; color: #155724; }
.risk-medium { background-color: #fff3cd; color: #856404; }
.risk-high { background-color: #f8d7da; color: #721c24; }

.form-check-input {
    margin-top: 0.25rem;
    margin-right: 0.5rem;
}
.form-check-label {
    margin-bottom: 0;
    cursor: pointer;
}
.ms-3 { margin-left: 1rem !important; }
.ms-2 { margin-left: 0.5rem !important; }
.me-2 { margin-right: 0.5rem !important; }
");

// Register JavaScript - SIMPLE & DIRECT
$this->registerJs("
// IMT CALCULATION - LANGSUNG JALAN
function hitungIMT() {
    var berat = parseFloat(document.getElementById('dataform-antro_berat').value);
    var tinggi = parseFloat(document.getElementById('dataform-antro_tinggi').value);
    
    if (berat && tinggi && tinggi > 0) {
        // RUMUS IMT = BERAT / (TINGGI_METER * TINGGI_METER)
        var tinggiMeter = tinggi / 100;
        var imt = berat / (tinggiMeter * tinggiMeter);
        var imtBulat = Math.round(imt * 100) / 100;
        
        // SET HASIL IMT
        document.getElementById('dataform-antro_imt').value = imtBulat;
        document.getElementById('imtValue').innerText = imtBulat;
        
        // KATEGORI IMT
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
        
        // AUTO SELECT STATUS GIZI
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

// RESIKO JATUH CALCULATION - LANGSUNG JALAN  
function hitungResikoJatuh() {
    var total = 0;
    
    // HITUNG TOTAL DARI SEMUA PILIHAN
    for (var i = 1; i <= 6; i++) {
        var pilihan = document.querySelector('input[name=\"risk' + i + '\"]:checked');
        if (pilihan) {
            var skor = parseInt(pilihan.getAttribute('data-score')) || 0;
            total += skor;
        }
    }
    
    // UPDATE TOTAL SCORE
    document.getElementById('totalScore').innerText = total;
    
    // KATEGORI RESIKO
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
        operasiFields.style.display = 'block';
    } else {
        operasiFields.style.display = 'none';
    }
}

function toggleDirawat() {
    var dirawatYa = document.querySelector('input[name=\"DataForm[riwayat_pernah_dirawat]\"][value=\"ya\"]');
    var dirawatFields = document.getElementById('dirawatFields');
    if (dirawatYa && dirawatYa.checked) {
        dirawatFields.style.display = 'block';
    } else {
        dirawatFields.style.display = 'none';
    }
}

// BIND EVENTS SAAT HALAMAN LOAD
document.addEventListener('DOMContentLoaded', function() {
    // SET TANGGAL DAN JAM SAAT INI
    var now = new Date();
    var tanggalSekarang = now.toISOString().split('T')[0];
    var jamSekarang = now.toTimeString().slice(0, 5);
    
    document.getElementById('dataform-tanggal_pengkajian').value = tanggalSekarang;
    document.getElementById('dataform-jam_pengkajian').value = jamSekarang;
    
    // BIND IMT CALCULATION
    document.getElementById('dataform-antro_berat').addEventListener('input', hitungIMT);
    document.getElementById('dataform-antro_berat').addEventListener('keyup', hitungIMT);
    document.getElementById('dataform-antro_tinggi').addEventListener('input', hitungIMT);
    document.getElementById('dataform-antro_tinggi').addEventListener('keyup', hitungIMT);
    
    // BIND RESIKO JATUH CALCULATION
    var riskOptions = document.querySelectorAll('.risk-option');
    riskOptions.forEach(function(option) {
        option.addEventListener('change', hitungResikoJatuh);
    });
    
    // BIND ADDITIONAL FIELDS
    var operasiInputs = document.querySelectorAll('input[name=\"DataForm[riwayat_operasi]\"]');
    operasiInputs.forEach(function(input) {
        input.addEventListener('change', toggleOperasi);
    });
    
    var dirawatInputs = document.querySelectorAll('input[name=\"DataForm[riwayat_pernah_dirawat]\"]');
    dirawatInputs.forEach(function(input) {
        input.addEventListener('change', toggleDirawat);
    });
    
    // INITIAL CALCULATION
    hitungResikoJatuh();
    
    console.log('=== MEDICAL FORM READY ===');
    console.log('IMT calculation: ENABLED');
    console.log('Risk calculation: ENABLED');
});

// GLOBAL TEST FUNCTIONS
window.testIMT = function(berat, tinggi) {
    document.getElementById('dataform-antro_berat').value = berat || 70;
    document.getElementById('dataform-antro_tinggi').value = tinggi || 170;
    hitungIMT();
    console.log('Test IMT completed');
};
", \yii\web\View::POS_HEAD);
?>
?>

<!-- Header -->
<div class="patient-header">
    <div class="row">
        <div class="col-md-8">
            <h4 style="margin: 0;">LAMPIRAN 1</h4>
        </div>
        <div class="col-md-4">
            <div class="logo-section">
                PT BIGS<br>
                INTEGRASI<br>
                TEKNOLOGI
            </div>
        </div>
    </div>
</div>

<!-- Title -->
<div class="text-center mb-4">
    <h3><strong>PENGKAJIAN KEPERAWATAN<br>POLIKLINIK KEBIDANAN</strong></h3>
</div>

<!-- Patient Info Section -->
<div class="row mb-4">
    <div class="col-md-6">
        <div style="border: 1px solid #000; padding: 15px;">
            <div class="mb-2"><strong>Nama Lengkap:</strong> <?= Html::encode($registrasi->nama_pasien) ?></div>
            <div class="mb-2"><strong>Tanggal Lahir:</strong> <?= $registrasi->tanggal_lahir ? date('d/m/Y', strtotime($registrasi->tanggal_lahir)) : '-' ?></div>
            <div><strong>No. RM:</strong> <?= Html::encode($registrasi->no_rekam_medis) ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div style="border: 1px solid #000; padding: 15px; text-align: center;">
            <div><strong>Petugas</strong></div>
            <div><strong>Tanggal / pukul:</strong> <?= date('d/m/Y H:i') ?></div>
            <div><strong>Nama lengkap</strong></div>
            <div><strong>Tanda tangan</strong></div>
        </div>
    </div>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'medical-form',
    'options' => ['class' => 'needs-validation', 'novalidate' => true],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'form-label'],
        'inputOptions' => ['class' => 'form-control'],
        'errorOptions' => ['class' => 'invalid-feedback'],
    ],
]); ?>

<!-- Basic Information -->
<div class="row mb-3">
    <div class="col-md-4">
        <?= $form->field($model, 'tanggal_pengkajian')->input('date', [
            'value' => $model->tanggal_pengkajian ?: date('Y-m-d'),
            'required' => true
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'jam_pengkajian')->input('time', [
            'value' => $model->jam_pengkajian ?: date('H:i'),
            'required' => true
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'poliklinik')->textInput([
            'value' => $model->poliklinik ?: 'KLINIK OBGYN',
            'required' => true
        ]) ?>
    </div>
</div>

<!-- Pengkajian saat datang -->
<div class="form-section">
    <h5 class="section-title">Pengkajian saat datang (diisi oleh perawat)</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label"><strong>1. Cara masuk:</strong></label>
            <div class="checkbox-group">
                <div class="form-check">
                    <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'jalan_tanpa_bantuan', [
                        'value' => 'jalan_tanpa_bantuan',
                        'class' => 'form-check-input',
                        'id' => 'cara_masuk_1'
                    ]) ?>
                    <label class="form-check-label" for="cara_masuk_1">Jalan tanpa bantuan</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'kursi_tanpa_bantuan', [
                        'value' => 'kursi_tanpa_bantuan',
                        'class' => 'form-check-input',
                        'id' => 'cara_masuk_2'
                    ]) ?>
                    <label class="form-check-label" for="cara_masuk_2">Kursi tanpa bantuan</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'tempat_tidur_dorong', [
                        'value' => 'tempat_tidur_dorong',
                        'class' => 'form-check-input',
                        'id' => 'cara_masuk_3'
                    ]) ?>
                    <label class="form-check-label" for="cara_masuk_3">Tempat tidur dorong</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'lain_lain', [
                        'value' => 'lain_lain',
                        'class' => 'form-check-input',
                        'id' => 'cara_masuk_4'
                    ]) ?>
                    <label class="form-check-label" for="cara_masuk_4">Lain-lain</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label"><strong>2. Anamnesis:</strong></label>
            <div class="checkbox-group">
                <div class="form-check">
                    <?= Html::radio('DataForm[anamnesis]', $model->anamnesis == 'autoanamnesis', [
                        'value' => 'autoanamnesis',
                        'class' => 'form-check-input',
                        'id' => 'anamnesis_1'
                    ]) ?>
                    <label class="form-check-label" for="anamnesis_1">Autoanamnesis</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[anamnesis]', $model->anamnesis == 'aloanamnesis', [
                        'value' => 'aloanamnesis',
                        'class' => 'form-check-input',
                        'id' => 'anamnesis_2'
                    ]) ?>
                    <label class="form-check-label" for="anamnesis_2">Aloanamnesis</label>
                </div>
            </div>
            <div class="mt-2">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Diperoleh:</label>
                        <?= Html::textInput('diperoleh', '', ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hubungan:</label>
                        <?= Html::textInput('hubungan', '', ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'alergi')->textInput(['placeholder' => 'seiring nyeri bagian vagina, flek sudah 2 hr yll']) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'keluhan_utama')->textarea(['rows' => 3, 'placeholder' => 'seiring nyeri bagian vagina, flek sudah 2 hr yll']) ?>
    </div>
</div>

<!-- Pemeriksaan Fisik -->
<div class="form-section">
    <h5 class="section-title">4. Pemeriksaan fisik:</h5>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label"><strong>a. Keadaan umum:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'tidak_tampak_sakit', [
                        'value' => 'tidak_tampak_sakit',
                        'class' => 'form-check-input',
                        'id' => 'keadaan_1'
                    ]) ?>
                    <label class="form-check-label" for="keadaan_1">Tidak tampak sakit</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'sakit_ringan', [
                        'value' => 'sakit_ringan',
                        'class' => 'form-check-input',
                        'id' => 'keadaan_2'
                    ]) ?>
                    <label class="form-check-label" for="keadaan_2">Sakit ringan</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'sedang', [
                        'value' => 'sedang',
                        'class' => 'form-check-input',
                        'id' => 'keadaan_3'
                    ]) ?>
                    <label class="form-check-label" for="keadaan_3">Sedang</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'berat', [
                        'value' => 'berat',
                        'class' => 'form-check-input',
                        'id' => 'keadaan_4'
                    ]) ?>
                    <label class="form-check-label" for="keadaan_4">Berat</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label"><strong>b. Warna kulit:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'normal', [
                        'value' => 'normal',
                        'class' => 'form-check-input',
                        'id' => 'kulit_1'
                    ]) ?>
                    <label class="form-check-label" for="kulit_1">Normal</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'sianosis', [
                        'value' => 'sianosis',
                        'class' => 'form-check-input',
                        'id' => 'kulit_2'
                    ]) ?>
                    <label class="form-check-label" for="kulit_2">Sianosis</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'pucat', [
                        'value' => 'pucat',
                        'class' => 'form-check-input',
                        'id' => 'kulit_3'
                    ]) ?>
                    <label class="form-check-label" for="kulit_3">Pucat</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'kemerahan', [
                        'value' => 'kemerahan',
                        'class' => 'form-check-input',
                        'id' => 'kulit_4'
                    ]) ?>
                    <label class="form-check-label" for="kulit_4">Kemerahan</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label"><strong>Kesadaran:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'compos_mentis', [
                        'value' => 'compos_mentis',
                        'class' => 'form-check-input',
                        'id' => 'sadar_1'
                    ]) ?>
                    <label class="form-check-label" for="sadar_1">Compos mentis</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'apatis', [
                        'value' => 'apatis',
                        'class' => 'form-check-input',
                        'id' => 'sadar_2'
                    ]) ?>
                    <label class="form-check-label" for="sadar_2">Apatis</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'somnolent', [
                        'value' => 'somnolent',
                        'class' => 'form-check-input',
                        'id' => 'sadar_3'
                    ]) ?>
                    <label class="form-check-label" for="sadar_3">Somnolent</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'sopor', [
                        'value' => 'sopor',
                        'class' => 'form-check-input',
                        'id' => 'sadar_4'
                    ]) ?>
                    <label class="form-check-label" for="sadar_4">Sopor</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'soporokoma', [
                        'value' => 'soporokoma',
                        'class' => 'form-check-input',
                        'id' => 'sadar_5'
                    ]) ?>
                    <label class="form-check-label" for="sadar_5">Soporokoma</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'koma', [
                        'value' => 'koma',
                        'class' => 'form-check-input',
                        'id' => 'sadar_6'
                    ]) ?>
                    <label class="form-check-label" for="sadar_6">Koma</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Tanda Vital -->
    <div class="mb-3">
        <label class="form-label"><strong>Tanda vital:</strong></label>
        <div class="vital-grid">
            <div>
                <label class="form-label">TD:</label>
                <?= $form->field($model, 'tanda_vital_td', ['template' => '{input}'])->textInput(['placeholder' => '130/92 mmHg']) ?>
            </div>
            <div>
                <label class="form-label">P:</label>
                <?= $form->field($model, 'tanda_vital_p', ['template' => '{input}'])->textInput(['placeholder' => 'x/menit']) ?>
            </div>
            <div>
                <label class="form-label">N:</label>
                <?= $form->field($model, 'tanda_vital_n', ['template' => '{input}'])->textInput(['placeholder' => '124 x/menit']) ?>
            </div>
            <div>
                <label class="form-label">S:</label>
                <?= $form->field($model, 'tanda_vital_s', ['template' => '{input}'])->textInput(['placeholder' => '36 oC']) ?>
            </div>
        </div>
    </div>

    <!-- Fungsional dan Antropometri -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label"><strong>Fungsional:</strong></label>
            <div class="mb-2">
                <label class="form-label">1. Alat bantu:</label>
                <?= $form->field($model, 'fungsi_alat_bantu', ['template' => '{input}'])->textInput() ?>
            </div>
            <div class="mb-2">
                <label class="form-label">2. Prothesa:</label>
                <?= $form->field($model, 'fungsi_prothesa', ['template' => '{input}'])->textInput() ?>
            </div>
            <div class="mb-2">
                <label class="form-label">3. Cacat tubuh:</label>
                <?= $form->field($model, 'fungsi_cacat_tubuh', ['template' => '{input}'])->textInput() ?>
            </div>
            <div class="mb-2">
                <label class="form-label">4. ADL:</label>
                <div class="ms-2">
                    <div class="form-check form-check-inline">
                        <?= Html::radio('DataForm[fungsi_adl]', $model->fungsi_adl == 'mandiri', [
                            'value' => 'mandiri',
                            'class' => 'form-check-input',
                            'id' => 'adl_1'
                        ]) ?>
                        <label class="form-check-label" for="adl_1">Mandiri</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <?= Html::radio('DataForm[fungsi_adl]', $model->fungsi_adl == 'dibantu', [
                            'value' => 'dibantu',
                            'class' => 'form-check-input',
                            'id' => 'adl_2'
                        ]) ?>
                        <label class="form-check-label" for="adl_2">Dibantu</label>
                    </div>
                </div>
            </div>
            <div>
                <label class="form-label">5. Riwayat jatuh:</label>
                <div class="ms-2">
                    <div class="form-check form-check-inline">
                        <?= Html::radio('DataForm[riwayat_jatuh_fungsional]', $model->riwayat_jatuh_fungsional == 'positif', [
                            'value' => 'positif',
                            'class' => 'form-check-input',
                            'id' => 'riwayat_jatuh_1'
                        ]) ?>
                        <label class="form-check-label" for="riwayat_jatuh_1">+ (Ada riwayat)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <?= Html::radio('DataForm[riwayat_jatuh_fungsional]', $model->riwayat_jatuh_fungsional == 'negatif', [
                            'value' => 'negatif',
                            'class' => 'form-check-input',
                            'id' => 'riwayat_jatuh_2'
                        ]) ?>
                        <label class="form-check-label" for="riwayat_jatuh_2">- (Tidak ada riwayat)</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label"><strong>Antropometri:</strong></label>
            <div class="antropometri-grid">
                <div>
                    <label class="form-label">Berat (Kg):</label>
                    <?= $form->field($model, 'antro_berat', ['template' => '{input}'])->textInput(['placeholder' => '62', 'step' => '0.1', 'type' => 'number']) ?>
                </div>
                <div>
                    <label class="form-label">Tinggi badan (Cm):</label>
                    <?= $form->field($model, 'antro_tinggi', ['template' => '{input}'])->textInput(['placeholder' => '160', 'step' => '0.1', 'type' => 'number']) ?>
                </div>
                <div>
                    <label class="form-label">Panjang badan (PB) (Cm):</label>
                    <?= $form->field($model, 'antro_lingkar', ['template' => '{input}'])->textInput(['placeholder' => 'Cm', 'step' => '0.1', 'type' => 'number']) ?>
                </div>
                <div>
                    <label class="form-label">Lingkar kepala (LK) (Cm):</label>
                    <?= Html::textInput('lingkar_kepala', '', ['class' => 'form-control', 'placeholder' => 'Cm', 'step' => '0.1', 'type' => 'number']) ?>
                </div>
                <div>
                    <label class="form-label">IMT:</label>
                    <?= $form->field($model, 'antro_imt', ['template' => '{input}'])->textInput(['readonly' => true]) ?>
                </div>
            </div>
            <div class="imt-result" id="imtResult" style="display: none;">
                <strong>Hasil IMT:</strong> <span id="imtValue"></span><br>
                <strong>Kategori:</strong> <span id="imtCategory"></span><br>
                <small class="text-muted">
                    Normal: 18.5-25.0 | Gemuk: >25.0-27.0 | Obesitas: >27.0
                </small>
            </div>
            <div class="mt-2">
                <small class="text-muted"><strong>Catatan:</strong> PB & LK Khusus Pediatri</small>
            </div>
        </div>
    </div>

    <!-- Status Gizi -->
    <div class="mb-3">
        <label class="form-label"><strong>c. Status gizi:</strong></label>
        <div class="checkbox-group">
            <div class="form-check">
                <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'ideal', [
                    'value' => 'ideal',
                    'class' => 'form-check-input',
                    'id' => 'gizi_1'
                ]) ?>
                <label class="form-check-label" for="gizi_1">Ideal</label>
            </div>
            <div class="form-check">
                <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'kurang', [
                    'value' => 'kurang',
                    'class' => 'form-check-input',
                    'id' => 'gizi_2'
                ]) ?>
                <label class="form-check-label" for="gizi_2">Kurang</label>
            </div>
            <div class="form-check">
                <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'obesitas', [
                    'value' => 'obesitas',
                    'class' => 'form-check-input',
                    'id' => 'gizi_3'
                ]) ?>
                <label class="form-check-label" for="gizi_3">Obesitas / overweight</label>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Penyakit -->
<div class="form-section">
    <h5 class="section-title">Riwayat Penyakit</h5>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label"><strong>5. Riwayat penyakit sekarang:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'dm', [
                        'value' => 'dm',
                        'class' => 'form-check-input',
                        'id' => 'sekarang_1'
                    ]) ?>
                    <label class="form-check-label" for="sekarang_1">DM</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'hipertensi', [
                        'value' => 'hipertensi',
                        'class' => 'form-check-input',
                        'id' => 'sekarang_2'
                    ]) ?>
                    <label class="form-check-label" for="sekarang_2">Hipertensi</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'jantung', [
                        'value' => 'jantung',
                        'class' => 'form-check-input',
                        'id' => 'sekarang_3'
                    ]) ?>
                    <label class="form-check-label" for="sekarang_3">Jantung</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'lain_lain', [
                        'value' => 'lain_lain',
                        'class' => 'form-check-input',
                        'id' => 'sekarang_4'
                    ]) ?>
                    <label class="form-check-label" for="sekarang_4">Lain-lain</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label"><strong>6. Riwayat penyakit sebelumnya:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', $model->riwayat_penyakit_sebelumnya == 'tidak', [
                        'value' => 'tidak',
                        'class' => 'form-check-input',
                        'id' => 'sebelum_1'
                    ]) ?>
                    <label class="form-check-label" for="sebelum_1">Tidak</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', $model->riwayat_penyakit_sebelumnya == 'ya', [
                        'value' => 'ya',
                        'class' => 'form-check-input',
                        'id' => 'sebelum_2'
                    ]) ?>
                    <label class="form-check-label" for="sebelum_2">Ya</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label"><strong>7. Riwayat penyakit keluarga:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', $model->riwayat_penyakit_keluarga == 'tidak', [
                        'value' => 'tidak',
                        'class' => 'form-check-input',
                        'id' => 'keluarga_1'
                    ]) ?>
                    <label class="form-check-label" for="keluarga_1">Tidak</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', $model->riwayat_penyakit_keluarga == 'ya', [
                        'value' => 'ya',
                        'class' => 'form-check-input',
                        'id' => 'keluarga_2'
                    ]) ?>
                    <label class="form-check-label" for="keluarga_2">Ya</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>8. Riwayat penyakit keluarga:</strong></label>
        <?= Html::textInput('riwayat_penyakit_keluarga_detail', '', ['class' => 'form-control', 'placeholder' => 'Sebutkan riwayat penyakit keluarga']) ?>
    </div>
</div>

<!-- Riwayat Operasi dan Rawat Inap -->
<div class="form-section">
    <h5 class="section-title">Riwayat Operasi dan Rawat Inap</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label"><strong>9. Riwayat operasi:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'tidak', [
                        'value' => 'tidak',
                        'class' => 'form-check-input',
                        'id' => 'operasi_1'
                    ]) ?>
                    <label class="form-check-label" for="operasi_1">Tidak</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'ya', [
                        'value' => 'ya',
                        'class' => 'form-check-input',
                        'id' => 'operasi_2'
                    ]) ?>
                    <label class="form-check-label" for="operasi_2">Ya</label>
                </div>
            </div>
            <div class="additional-fields" id="operasiFields">
                <div class="mb-2">
                    <label class="form-label">Operasi apa?</label>
                    <?= Html::textInput('operasi_apa', 'APP', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label class="form-label">Kapan?</label>
                    <?= Html::textInput('operasi_kapan', '2017', ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label"><strong>10. Riwayat pernah dirawat di RS:</strong></label>
            <div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'tidak', [
                        'value' => 'tidak',
                        'class' => 'form-check-input',
                        'id' => 'dirawat_1'
                    ]) ?>
                    <label class="form-check-label" for="dirawat_1">Tidak</label>
                </div>
                <div class="form-check">
                    <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'ya', [
                        'value' => 'ya',
                        'class' => 'form-check-input',
                        'id' => 'dirawat_2'
                    ]) ?>
                    <label class="form-check-label" for="dirawat_2">Ya</label>
                </div>
            </div>
            <div class="additional-fields" id="dirawatFields">
                <div class="mb-2">
                    <label class="form-label">Penyakit apa?</label>
                    <?= Html::textInput('penyakit_apa', 'post app', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label class="form-label">Kapan?</label>
                    <?= Html::textInput('dirawat_kapan', '2017', ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pengkajian Resiko Jatuh -->
<div class="form-section">
    <h5 class="section-title">15. Pengkajian resiko jatuh</h5>

    <div class="row">
        <div class="col-md-8">
            <!-- 1. Riwayat jatuh -->
            <div class="mb-4">
                <label class="form-label"><strong>1. Riwayat jatuh yang baru atau dalam 3 bulan terakhir</strong></label>
                <div class="ms-3">
                    <div class="form-check">
                        <?= Html::radio('risk1', false, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk1_0'
                        ]) ?>
                        <label class="form-check-label" for="risk1_0">Tidak (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk1', true, [
                            'value' => '25',
                            'data-score' => '25',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk1_25'
                        ]) ?>
                        <label class="form-check-label" for="risk1_25">Ya (25)</label>
                    </div>
                </div>
            </div>

            <!-- 2. Diagnosa medis -->
            <div class="mb-4">
                <label class="form-label"><strong>2. Diagnosa medis sekunder > 1</strong></label>
                <div class="ms-3">
                    <div class="form-check">
                        <?= Html::radio('risk2', false, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk2_0'
                        ]) ?>
                        <label class="form-check-label" for="risk2_0">Tidak (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk2', true, [
                            'value' => '15',
                            'data-score' => '15',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk2_15'
                        ]) ?>
                        <label class="form-check-label" for="risk2_15">Ya (15)</label>
                    </div>
                </div>
            </div>

            <!-- 3. Alat bantu jalan -->
            <div class="mb-4">
                <label class="form-label"><strong>3. Alat bantu jalan</strong></label>
                <div class="ms-3">
                    <div class="form-check">
                        <?= Html::radio('risk3', true, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk3_0'
                        ]) ?>
                        <label class="form-check-label" for="risk3_0">Mandiri, bedrest, dibantu perawat, kursi roda (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk3', false, [
                            'value' => '15',
                            'data-score' => '15',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk3_15a'
                        ]) ?>
                        <label class="form-check-label" for="risk3_15a">Penopang, tongkat/walker (15)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk3', false, [
                            'value' => '15',
                            'data-score' => '15',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk3_15b'
                        ]) ?>
                        <label class="form-check-label" for="risk3_15b">Mencengkeram furniture/sesuatu untuk topangan (15)</label>
                    </div>
                </div>
            </div>

            <!-- 4. Ad akses IV -->
            <div class="mb-4">
                <label class="form-label"><strong>4. Ad akses IV atau terapi heparin lock</strong></label>
                <div class="ms-3">
                    <div class="form-check">
                        <?= Html::radio('risk4', false, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk4_0'
                        ]) ?>
                        <label class="form-check-label" for="risk4_0">Tidak (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk4', true, [
                            'value' => '20',
                            'data-score' => '20',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk4_20'
                        ]) ?>
                        <label class="form-check-label" for="risk4_20">Ya (20)</label>
                    </div>
                </div>
            </div>

            <!-- 5. Cara berjalan/berpindah -->
            <div class="mb-4">
                <label class="form-label"><strong>5. Cara berjalan/berpindah</strong></label>
                <div class="ms-3">
                    <div class="form-check">
                        <?= Html::radio('risk5', true, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk5_0a'
                        ]) ?>
                        <label class="form-check-label" for="risk5_0a">Normal (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk5', false, [
                            'value' => '10',
                            'data-score' => '10',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk5_10'
                        ]) ?>
                        <label class="form-check-label" for="risk5_10">Lemah, langkah, diseret (10)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk5', false, [
                            'value' => '20',
                            'data-score' => '20',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk5_20'
                        ]) ?>
                        <label class="form-check-label" for="risk5_20">Terganggu, perlu bantuan, keseimbangan buruk (20)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk5', false, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk5_0b'
                        ]) ?>
                        <label class="form-check-label" for="risk5_0b">Orientasi sesuai kemampuan diri (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk5', false, [
                            'value' => '15',
                            'data-score' => '15',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk5_15'
                        ]) ?>
                        <label class="form-check-label" for="risk5_15">Lupa keterbatasan diri (15)</label>
                    </div>
                </div>
            </div>

            <!-- 6. Status mental -->
            <div class="mb-4">
                <label class="form-label"><strong>6. Status mental</strong></label>
                <div class="ms-3">
                    <div class="form-check">
                        <?= Html::radio('risk6', true, [
                            'value' => '0',
                            'data-score' => '0',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk6_0'
                        ]) ?>
                        <label class="form-check-label" for="risk6_0">Normal (0)</label>
                    </div>
                    <div class="form-check">
                        <?= Html::radio('risk6', false, [
                            'value' => '15',
                            'data-score' => '15',
                            'class' => 'form-check-input risk-option',
                            'id' => 'risk6_15'
                        ]) ?>
                        <label class="form-check-label" for="risk6_15">Lupa keterbatasan diri (15)</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Hasil -->
        <div class="col-md-4">
            <div style="border: 2px solid #000; padding: 15px; height: 100%;">
                <div class="text-center mb-3">
                    <h5>Total Skor</h5>
                    <div class="total-score" id="totalScore" style="font-size: 2rem; color: #007bff;">60</div>
                </div>

                <div class="mb-3 p-2" style="background-color: #e8f4fd; border: 1px solid #b3d9ff;">
                    <strong>Tidak berisiko : 0-24</strong>
                </div>
                <div class="mb-3 p-2" style="background-color: #fff3cd; border: 1px solid #ffeaa7;">
                    <strong>Perawatan yang baik<br>
                        Resiko rendah : 25-44</strong>
                </div>
                <div class="mb-3 p-2" style="background-color: #f8d7da; border: 1px solid #f5c6cb;">
                    <strong>Lakukan intervensi<br>
                        jatuh standar<br>
                        Resiko tinggi : >=45</strong>
                </div>
                <div class="p-2" style="background-color: #f8d7da; border: 1px solid #f5c6cb;">
                    <strong>Lakukan intervensi<br>
                        jatuh risiko tinggi</strong>
                </div>

                <div class="mt-3 text-center">
                    <div class="risk-category" id="riskCategory">Resiko tinggi (≥45)</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden fields untuk menyimpan data resiko jatuh -->
<?= Html::hiddenInput('DataForm[total_resiko_jatuh]', '', ['id' => 'hiddenTotalScore']) ?>
<?= Html::hiddenInput('DataForm[kategori_resiko_jatuh]', '', ['id' => 'hiddenRiskCategory']) ?>
<?= Html::hiddenInput('DataForm[resiko_jatuh_detail]', '', ['id' => 'hiddenRiskDetail']) ?>

<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <?= Html::submitButton($isEdit ? '<i class="fas fa-save"></i> Update Data' : '<i class="fas fa-save"></i> Simpan Data', [
            'class' => 'btn btn-primary btn-lg me-2'
        ]) ?>
        <?= Html::a('<i class="fas fa-print"></i> Print Form', ['print-form', 'id' => $model->id_form_data ?? 0], [
            'class' => 'btn btn-secondary btn-lg me-2',
            'target' => '_blank',
            'style' => $isEdit ? '' : 'display: none;'
        ]) ?>
        <?= Html::a(
            '<i class="fas fa-arrow-left"></i> Kembali',
            $isEdit ? ['view-form', 'id' => $model->id_form_data] : ['view', 'id' => $registrasi->id_registrasi],
            ['class' => 'btn btn-outline-secondary btn-lg']
        ) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>