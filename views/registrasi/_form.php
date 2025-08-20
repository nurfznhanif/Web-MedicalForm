<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */
/* @var $registrasi app\models\Registrasi */
/* @var $isEdit boolean */

$isEdit = $isEdit ?? false;

// Register CSS dan JS
$this->registerCss("
.form-section {
    background: #f8f9fa;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #dee2e6;
    border-radius: 5px;
}
.form-section h4 {
    color: #495057;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
    margin-bottom: 15px;
}
.checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}
.checkbox-group .form-check {
    min-width: 120px;
}
.vital-signs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}
.antropometri-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}
.resiko-table {
    width: 100%;
    border-collapse: collapse;
}
.resiko-table th, .resiko-table td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: left;
}
.resiko-table th {
    background-color: #e9ecef;
}
.patient-info {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
}
");

$this->registerJs("
// Hitung IMT otomatis
function hitungIMT() {
    var berat = parseFloat($('#dataform-antro_berat').val());
    var tinggi = parseFloat($('#dataform-antro_tinggi').val());
    
    if (berat > 0 && tinggi > 0) {
        $.post('" . \yii\helpers\Url::to(['hitung-imt']) . "', {
            berat: berat,
            tinggi: tinggi
        }, function(data) {
            if (data.success) {
                $('#dataform-antro_imt').val(data.imt);
                $('#imt-kategori').text('Kategori: ' + data.kategori);
            }
        });
    }
}

// Event listeners
$('#dataform-antro_berat, #dataform-antro_tinggi').on('input', hitungIMT);

// Toggle additional fields untuk riwayat operasi dan dirawat
function toggleAdditionalFields() {
    if ($('input[name=\"DataForm[riwayat_operasi]\"][value=\"ya\"]').is(':checked')) {
        $('#operasiFields').show();
    } else {
        $('#operasiFields').hide();
    }
    
    if ($('input[name=\"DataForm[riwayat_pernah_dirawat]\"][value=\"ya\"]').is(':checked')) {
        $('#dirawatFields').show();
    } else {
        $('#dirawatFields').hide();
    }
}

$('input[name=\"DataForm[riwayat_operasi]\"], input[name=\"DataForm[riwayat_pernah_dirawat]\"]').change(toggleAdditionalFields);

// Hitung total resiko jatuh
function hitungResikoJatuh() {
    var total = 0;
    $('.risk-input').each(function() {
        var nilai = parseInt($(this).val()) || 0;
        total += nilai;
        
        // Update individual result input
        var riskNum = $(this).attr('name').replace('risk', '');
        $('input[name=\"result_' + riskNum + '\"]').val(nilai);
    });
    
    $('#total-resiko').text(total);
    $('#total_score').val(total);
    
    var kategori = '';
    var badgeClass = '';
    if (total <= 24) {
        kategori = 'Tidak berisiko (0-24)';
        badgeClass = 'bg-success';
    } else if (total <= 44) {
        kategori = 'Resiko rendah (25-44)';
        badgeClass = 'bg-warning';
    } else {
        kategori = 'Resiko tinggi (≥45)';
        badgeClass = 'bg-danger';
    }
    $('#kategori-resiko').removeClass().addClass('badge ' + badgeClass).text(kategori);
}

$('.risk-input').on('change', hitungResikoJatuh);

// Initialize
$(document).ready(function() {
    toggleAdditionalFields();
    hitungResikoJatuh();
    
    // Auto-set current date and time for new forms
    if (!'" . $isEdit . "') {
        if (!$('#dataform-tanggal_pengkajian').val()) {
            $('#dataform-tanggal_pengkajian').val('" . date('Y-m-d') . "');
        }
        if (!$('#dataform-jam_pengkajian').val()) {
            $('#dataform-jam_pengkajian').val('" . date('H:i') . "');
        }
    }
});
");
?>

<div class="patient-info">
    <div class="row">
        <div class="col-md-6">
            <strong>Nama Lengkap:</strong> <?= Html::encode($registrasi->nama_pasien) ?><br>
            <strong>Tanggal Lahir:</strong> <?= $registrasi->tanggal_lahir ? date('d/m/Y', strtotime($registrasi->tanggal_lahir)) : '-' ?><br>
            <strong>No. RM:</strong> <?= Html::encode($registrasi->no_rekam_medis) ?>
        </div>
        <div class="col-md-6 text-end">
            <div class="border p-2" style="display: inline-block;">
                <strong>Petugas:</strong><br>
                <strong>Tanggal/Pukul:</strong> <?= date('d/m/Y H:i') ?><br>
                <strong>Form ID:</strong> <?= $isEdit ? 'FM' . str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) : 'Baru' ?><br>
                <strong>Status:</strong> <?= $isEdit ? 'Edit' : 'Input' ?>
            </div>
        </div>
    </div>
</div>

<?php $form = ActiveForm::begin(['id' => 'form-pengkajian']); ?>

<!-- Informasi Dasar -->
<div class="form-section">
    <h4>Informasi Pengkajian</h4>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'tanggal_pengkajian')->input('date') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'jam_pengkajian')->input('time') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'poliklinik')->textInput([
                'placeholder' => 'KLINIK OBGYN',
                'value' => $model->poliklinik ?: 'KLINIK OBGYN'
            ]) ?>
        </div>
    </div>
</div>

<!-- Pengkajian saat datang -->
<div class="form-section">
    <h4>1. Pengkajian saat datang (diisi oleh perawat)</h4>

    <div class="row">
        <div class="col-md-6">
            <label><strong>Cara masuk:</strong></label>
            <div class="checkbox-group">
                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'jalan_tanpa_bantuan', ['label' => 'Jalan tanpa bantuan', 'value' => 'jalan_tanpa_bantuan']) ?>
                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'kursi_tanpa_bantuan', ['label' => 'Kursi tanpa bantuan', 'value' => 'kursi_tanpa_bantuan']) ?>
                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'tempat_tidur_dorong', ['label' => 'Tempat tidur dorong', 'value' => 'tempat_tidur_dorong']) ?>
                <?= Html::radio('DataForm[cara_masuk]', $model->cara_masuk == 'lain_lain', ['label' => 'Lain-lain', 'value' => 'lain_lain']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <label><strong>2. Anamnesis:</strong></label>
            <div class="checkbox-group">
                <?= Html::radio('DataForm[anamnesis]', $model->anamnesis == 'autoanamnesis', ['label' => 'Autoanamnesis', 'value' => 'autoanamnesis']) ?>
                <?= Html::radio('DataForm[anamnesis]', $model->anamnesis == 'aloanamnesis', ['label' => 'Aloanamnesis', 'value' => 'aloanamnesis']) ?>
            </div>
            <div class="mt-2">
                <div class="row">
                    <div class="col-6">
                        <label>Diperoleh:</label>
                        <?= Html::textInput('anamnesis_diperoleh', $model->anamnesis_diperoleh, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-6">
                        <label>Hubungan:</label>
                        <?= Html::textInput('anamnesis_hubungan', $model->anamnesis_hubungan, ['class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <?= $form->field($model, 'alergi')->textInput(['placeholder' => 'seiring nyeri bagian vagina, flek sudah 2 hr yll']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'keluhan_utama')->textarea(['rows' => 3, 'placeholder' => 'Masukkan keluhan utama pasien']) ?>
        </div>
    </div>
</div>

<!-- Pemeriksaan Fisik -->
<div class="form-section">
    <h4>4. Pemeriksaan fisik:</h4>

    <div class="row">
        <div class="col-md-4">
            <label><strong>a. Keadaan umum:</strong></label>
            <div>
                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'tidak_tampak_sakit', ['label' => 'Tidak tampak sakit', 'value' => 'tidak_tampak_sakit']) ?>
                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'sakit_ringan', ['label' => 'Sakit ringan', 'value' => 'sakit_ringan']) ?>
                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'sedang', ['label' => 'Sedang', 'value' => 'sedang']) ?>
                <?= Html::radio('DataForm[keadaan_umum]', $model->keadaan_umum == 'berat', ['label' => 'Berat', 'value' => 'berat']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>b. Warna kulit:</strong></label>
            <div>
                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'normal', ['label' => 'Normal', 'value' => 'normal']) ?>
                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'sianosis', ['label' => 'Sianosis', 'value' => 'sianosis']) ?>
                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'pucat', ['label' => 'Pucat', 'value' => 'pucat']) ?>
                <?= Html::radio('DataForm[warna_kulit]', $model->warna_kulit == 'kemerahan', ['label' => 'Kemerahan', 'value' => 'kemerahan']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>Kesadaran:</strong></label>
            <div>
                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'compos_mentis', ['label' => 'Compos mentis', 'value' => 'compos_mentis']) ?>
                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'apatis', ['label' => 'Apatis', 'value' => 'apatis']) ?>
                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'somnolent', ['label' => 'Somnolent', 'value' => 'somnolent']) ?>
                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'sopor', ['label' => 'Sopor', 'value' => 'sopor']) ?>
                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'soporokoma', ['label' => 'Soporokoma', 'value' => 'soporokoma']) ?>
                <?= Html::radio('DataForm[kesadaran]', $model->kesadaran == 'koma', ['label' => 'Koma', 'value' => 'koma']) ?>
            </div>
        </div>
    </div>

    <!-- Tanda Vital -->
    <div class="row mt-3">
        <div class="col-md-12">
            <label><strong>Tanda vital:</strong></label>
            <div class="vital-signs">
                <div>
                    <label>TD:</label>
                    <?= $form->field($model, 'tanda_vital_td', ['template' => '{input}'])->textInput(['placeholder' => '130/92 mmHg']) ?>
                </div>
                <div>
                    <label>P:</label>
                    <?= $form->field($model, 'tanda_vital_p', ['template' => '{input}'])->textInput(['placeholder' => 'x/menit']) ?>
                </div>
                <div>
                    <label>N:</label>
                    <?= $form->field($model, 'tanda_vital_n', ['template' => '{input}'])->textInput(['placeholder' => '124 x/menit']) ?>
                </div>
                <div>
                    <label>S:</label>
                    <?= $form->field($model, 'tanda_vital_s', ['template' => '{input}'])->textInput(['placeholder' => '36 oC']) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Fungsional dan Antropometri -->
    <div class="row mt-3">
        <div class="col-md-6">
            <label><strong>Fungsional:</strong></label>
            <div>
                <div class="mb-2">1. Alat bantu: <?= $form->field($model, 'fungsi_alat_bantu', ['template' => '{input}'])->textInput() ?></div>
                <div class="mb-2">2. Prothesa: <?= $form->field($model, 'fungsi_prothesa', ['template' => '{input}'])->textInput() ?></div>
                <div class="mb-2">3. Cacat tubuh: <?= $form->field($model, 'fungsi_cacat_tubuh', ['template' => '{input}'])->textInput() ?></div>
                <div class="mb-2">4. ADL: <?= $form->field($model, 'fungsi_adl', ['template' => '{input}'])->textInput() ?></div>
                <div class="mb-2">5. Riwayat jatuh: <?= $form->field($model, 'riwayat_jatuh_fungsional', ['template' => '{input}'])->textInput(['placeholder' => 'Mandiri']) ?></div>
            </div>
        </div>
        <div class="col-md-6">
            <label><strong>Antropometri:</strong></label>
            <div class="antropometri-grid">
                <div>
                    <label>Berat (Kg):</label>
                    <?= $form->field($model, 'antro_berat', ['template' => '{input}'])->textInput(['placeholder' => '62', 'id' => 'dataform-antro_berat']) ?>
                </div>
                <div>
                    <label>Tinggi (Cm):</label>
                    <?= $form->field($model, 'antro_tinggi', ['template' => '{input}'])->textInput(['placeholder' => '50', 'id' => 'dataform-antro_tinggi']) ?>
                </div>
                <div>
                    <label>Panjang badan (PB) (Cm):</label>
                    <?= $form->field($model, 'antro_lingkar', ['template' => '{input}'])->textInput(['placeholder' => 'Cm']) ?>
                </div>
                <div>
                    <label>Lingkar kepala (LK) (Cm):</label>
                    <?= Html::textInput('lingkar_kepala', '', ['class' => 'form-control', 'placeholder' => 'Cm']) ?>
                </div>
                <div>
                    <label>IMT:</label>
                    <?= $form->field($model, 'antro_imt', ['template' => '{input}'])->textInput(['readonly' => true, 'id' => 'dataform-antro_imt']) ?>
                    <small id="imt-kategori" class="text-muted"></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Gizi -->
    <div class="row mt-3">
        <div class="col-md-12">
            <label><strong>c. Status gizi:</strong></label>
            <div class="checkbox-group">
                <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'ideal', ['label' => 'Ideal', 'value' => 'ideal']) ?>
                <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'kurang', ['label' => 'Kurang', 'value' => 'kurang']) ?>
                <?= Html::radio('DataForm[status_gizi]', $model->status_gizi == 'obesitas', ['label' => 'Obesitas / overweight', 'value' => 'obesitas']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Penyakit -->
<div class="form-section">
    <h4>5-8. Riwayat Penyakit</h4>

    <div class="row">
        <div class="col-md-4">
            <label><strong>5. Riwayat penyakit sekarang:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'dm', ['label' => 'DM', 'value' => 'dm']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'hipertensi', ['label' => 'Hipertensi', 'value' => 'hipertensi']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'jantung', ['label' => 'Jantung', 'value' => 'jantung']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', $model->riwayat_penyakit_sekarang == 'lain_lain', ['label' => 'Lain-lain', 'value' => 'lain_lain']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>6. Riwayat penyakit sebelumnya:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', $model->riwayat_penyakit_sebelumnya == 'tidak', ['label' => 'Tidak', 'value' => 'tidak']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', $model->riwayat_penyakit_sebelumnya == 'ya', ['label' => 'Ya', 'value' => 'ya']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>7. Riwayat penyakit keluarga:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', $model->riwayat_penyakit_keluarga == 'tidak', ['label' => 'Tidak', 'value' => 'tidak']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', $model->riwayat_penyakit_keluarga == 'ya', ['label' => 'Ya', 'value' => 'ya']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Operasi dan Rawat Inap -->
<div class="form-section">
    <h4>9-10. Riwayat Operasi dan Rawat Inap</h4>

    <div class="row">
        <div class="col-md-6">
            <label><strong>9. Riwayat operasi:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'tidak', ['label' => 'Tidak', 'value' => 'tidak']) ?>
                <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'ya', ['label' => 'Ya', 'value' => 'ya']) ?>
            </div>
            <div id="operasiFields" style="display: none;" class="mt-2">
                <label>Operasi apa?</label>
                <?= Html::textInput('operasi_apa', $model->operasi_detail_apa, ['class' => 'form-control', 'placeholder' => 'APP']) ?>
                <label>Kapan?</label>
                <?= Html::textInput('operasi_kapan', $model->operasi_detail_kapan, ['class' => 'form-control', 'placeholder' => '2017']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <label><strong>10. Riwayat pernah dirawat di RS:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'tidak', ['label' => 'Tidak', 'value' => 'tidak']) ?>
                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'ya', ['label' => 'Ya', 'value' => 'ya']) ?>
            </div>
            <div id="dirawatFields" style="display: none;" class="mt-2">
                <label>Penyakit apa?</label>
                <?= Html::textInput('penyakit_apa', $model->dirawat_detail_penyakit, ['class' => 'form-control', 'placeholder' => 'post app']) ?>
                <label>Kapan?</label>
                <?= Html::textInput('dirawat_kapan', $model->dirawat_detail_kapan, ['class' => 'form-control', 'placeholder' => '2017']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Pengkajian Resiko Jatuh -->
<div class="form-section">
    <h4>15. Pengkajian resiko jatuh</h4>

    <div class="table-responsive">
        <table class="resiko-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="50%">Resiko</th>
                    <th width="25%">Skala</th>
                    <th width="20%">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Riwayat jatuh yang baru atau dalam 3 bulan terakhir</td>
                    <td>Tidak = 0<br>Ya = 25</td>
                    <td>
                        <select name="risk1" class="form-control risk-input" data-score>
                            <option value="0" <?= (isset($model->resiko_jatuh_items['risk1']) && $model->resiko_jatuh_items['risk1'] == 0) ? 'selected' : '' ?>>Tidak (0)</option>
                            <option value="25" <?= (isset($model->resiko_jatuh_items['risk1']) && $model->resiko_jatuh_items['risk1'] == 25) ? 'selected' : '' ?>>Ya (25)</option>
                        </select>
                        <?= Html::hiddenInput('result_1', '', ['class' => 'result-input']) ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Diagnosa medis sekunder > 1</td>
                    <td>Tidak = 0<br>Ya = 15</td>
                    <td>
                        <select name="risk2" class="form-control risk-input">
                            <option value="0" <?= (isset($model->resiko_jatuh_items['risk2']) && $model->resiko_jatuh_items['risk2'] == 0) ? 'selected' : '' ?>>Tidak (0)</option>
                            <option value="15" <?= (isset($model->resiko_jatuh_items['risk2']) && $model->resiko_jatuh_items['risk2'] == 15) ? 'selected' : '' ?>>Ya (15)</option>
                        </select>
                        <?= Html::hiddenInput('result_2', '', ['class' => 'result-input']) ?>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Alat bantu jalan</td>
                    <td>Mandiri/Bedrest/Dibantu = 0<br>Penopang/Tongkat = 15<br>Mencengkeram furniture = 15</td>
                    <td>
                        <select name="risk3" class="form-control risk-input">
                            <option value="0" <?= (isset($model->resiko_jatuh_items['risk3']) && $model->resiko_jatuh_items['risk3'] == 0) ? 'selected' : '' ?>>Mandiri/Bedrest/Dibantu (0)</option>
                            <option value="15" <?= (isset($model->resiko_jatuh_items['risk3']) && $model->resiko_jatuh_items['risk3'] == 15) ? 'selected' : '' ?>>Penopang/Tongkat (15)</option>
                        </select>
                        <?= Html::hiddenInput('result_3', '', ['class' => 'result-input']) ?>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Ad akses IV atau terapi heparin lock</td>
                    <td>Tidak = 0<br>Ya = 20</td>
                    <td>
                        <select name="risk4" class="form-control risk-input">
                            <option value="0" <?= (isset($model->resiko_jatuh_items['risk4']) && $model->resiko_jatuh_items['risk4'] == 0) ? 'selected' : '' ?>>Tidak (0)</option>
                            <option value="20" <?= (isset($model->resiko_jatuh_items['risk4']) && $model->resiko_jatuh_items['risk4'] == 20) ? 'selected' : '' ?>>Ya (20)</option>
                        </select>
                        <?= Html::hiddenInput('result_4', '', ['class' => 'result-input']) ?>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Cara berjalan/berpindah</td>
                    <td>Normal = 0<br>Lemah/Terganggu = 10<br>Orientasi sesuai = 20<br>Lupa keterbatasan = 15</td>
                    <td>
                        <select name="risk5" class="form-control risk-input">
                            <option value="0" <?= (isset($model->resiko_jatuh_items['risk5']) && $model->resiko_jatuh_items['risk5'] == 0) ? 'selected' : '' ?>>Normal (0)</option>
                            <option value="10" <?= (isset($model->resiko_jatuh_items['risk5']) && $model->resiko_jatuh_items['risk5'] == 10) ? 'selected' : '' ?>>Lemah/Terganggu (10)</option>
                            <option value="20" <?= (isset($model->resiko_jatuh_items['risk5']) && $model->resiko_jatuh_items['risk5'] == 20) ? 'selected' : '' ?>>Orientasi sesuai (20)</option>
                            <option value="15" <?= (isset($model->resiko_jatuh_items['risk5']) && $model->resiko_jatuh_items['risk5'] == 15) ? 'selected' : '' ?>>Lupa keterbatasan (15)</option>
                        </select>
                        <?= Html::hiddenInput('result_5', '', ['class' => 'result-input']) ?>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Status mental</td>
                    <td>Orientasi baik = 0<br>Lupa keterbatasan = 15</td>
                    <td>
                        <select name="risk6" class="form-control risk-input">
                            <option value="0" <?= (isset($model->resiko_jatuh_items['risk6']) && $model->resiko_jatuh_items['risk6'] == 0) ? 'selected' : '' ?>>Orientasi baik (0)</option>
                            <option value="15" <?= (isset($model->resiko_jatuh_items['risk6']) && $model->resiko_jatuh_items['risk6'] == 15) ? 'selected' : '' ?>>Lupa keterbatasan (15)</option>
                        </select>
                        <?= Html::hiddenInput('result_6', '', ['class' => 'result-input']) ?>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Nilai total</strong></td>
                    <td>
                        <strong><span id="total-resiko"><?= $model->getTotalResikoJatuh() ?: '0' ?></span></strong>
                        <?= Html::hiddenInput('total_score', $model->total_resiko_jatuh ?: 0, ['id' => 'total_score']) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span id="kategori-resiko" class="badge <?= $model->getTotalResikoJatuh() <= 24 ? 'bg-success' : ($model->getTotalResikoJatuh() <= 44 ? 'bg-warning' : 'bg-danger') ?>">
                            <?= $model->getKategoriResikoJatuh() ?: 'Tidak berisiko (0-24)' ?>
                        </span><br>
                        <small class="text-muted">
                            <strong>Tidak berisiko: 0-24</strong> | Perawatan standar<br>
                            <strong>Resiko rendah: 25-44</strong> | Lakukan intervensi jatuh standar<br>
                            <strong>Resiko tinggi: ≥45</strong> | Lakukan intervensi jatuh risiko tinggi
                        </small>
                        <?= Html::hiddenInput('DataForm[total_resiko_jatuh]', $model->total_resiko_jatuh ?: 0) ?>
                        <?= Html::hiddenInput('DataForm[kategori_resiko_jatuh]', $model->kategori_resiko_jatuh ?: 'Tidak berisiko (0-24)') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="form-group mt-4">
    <?= Html::submitButton($isEdit ? '<i class="fas fa-save"></i> Update Data Form' : '<i class="fas fa-save"></i> Simpan Data Form', [
        'class' => 'btn btn-primary btn-lg'
    ]) ?>
    <?= Html::a(
        '<i class="fas fa-times"></i> Batal',
        $isEdit ? ['view-form', 'id' => $model->id_form_data] : ['view', 'id' => $registrasi->id_registrasi],
        [
            'class' => 'btn btn-secondary btn-lg'
        ]
    ) ?>
</div>

<?php ActiveForm::end(); ?>