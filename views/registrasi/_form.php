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
    $('.operasi-additional').toggle($('input[name=\"DataForm[riwayat_operasi]\"][value=\"Ya\"]').is(':checked'));
    $('.dirawat-additional').toggle($('input[name=\"DataForm[riwayat_pernah_dirawat]\"][value=\"Ya\"]').is(':checked'));
}

$('input[name=\"DataForm[riwayat_operasi]\"], input[name=\"DataForm[riwayat_pernah_dirawat]\"]').change(toggleAdditionalFields);

// Hitung total resiko jatuh
function hitungResikoJatuh() {
    var total = 0;
    $('.resiko-input').each(function() {
        var nilai = parseInt($(this).val()) || 0;
        total += nilai;
    });
    $('#total-resiko').text(total);
    
    var kategori = '';
    if (total <= 24) {
        kategori = 'Tidak beresiko (0-24)';
        $('#kategori-resiko').removeClass().addClass('badge badge-success');
    } else if (total <= 44) {
        kategori = 'Resiko rendah (25-44)';
        $('#kategori-resiko').removeClass().addClass('badge badge-warning');
    } else {
        kategori = 'Resiko tinggi (>=45)';
        $('#kategori-resiko').removeClass().addClass('badge badge-danger');
    }
    $('#kategori-resiko').text(kategori);
}

$('.resiko-input').on('input', hitungResikoJatuh);

// Initialize
$(document).ready(function() {
    toggleAdditionalFields();
    hitungResikoJatuh();
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
        <div class="col-md-6 text-right">
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
            <?= $form->field($model, 'tanggal_pengkajian')->input('date', [
                'value' => $model->tanggal_pengkajian ?: date('Y-m-d')
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'jam_pengkajian')->input('time', [
                'value' => $model->jam_pengkajian ?: date('H:i')
            ]) ?>
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
                    <?= Html::textInput('DataForm[tanda_vital_td]', $model->tanda_vital_td ?: '130/92 mmHg', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label>P:</label>
                    <?= Html::textInput('DataForm[tanda_vital_p]', $model->tanda_vital_p ?: 'x/menit', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label>N:</label>
                    <?= Html::textInput('DataForm[tanda_vital_n]', $model->tanda_vital_n ?: '124 x/menit', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label>S:</label>
                    <?= Html::textInput('DataForm[tanda_vital_s]', $model->tanda_vital_s ?: '36 oC', ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Fungsional -->
    <div class="row mt-3">
        <div class="col-md-12">
            <label><strong>Fungsional:</strong></label>
            <div class="row">
                <div class="col-md-6">
                    <div>1. Alat bantu: <?= Html::textInput('DataForm[fungsi_alat_bantu]', $model->fungsi_alat_bantu, ['class' => 'form-control']) ?></div>
                    <div>2. Prothesa: <?= Html::textInput('DataForm[fungsi_prothesa]', $model->fungsi_prothesa, ['class' => 'form-control']) ?></div>
                    <div>3. Cacat tubuh: <?= Html::textInput('DataForm[fungsi_cacat_tubuh]', $model->fungsi_cacat_tubuh, ['class' => 'form-control']) ?></div>
                    <div>4. ADL: <?= Html::textInput('DataForm[fungsi_adl]', $model->fungsi_adl, ['class' => 'form-control']) ?></div>
                    <div>5. Riwayat jatuh: <?= Html::textInput('DataForm[mandiri]', 'Mandiri', ['class' => 'form-control']) ?></div>
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
                <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'Tidak', ['label' => 'Tidak', 'value' => 'Tidak']) ?>
                <?= Html::radio('DataForm[riwayat_operasi]', $model->riwayat_operasi == 'Ya', ['label' => 'Ya', 'value' => 'Ya']) ?>
            </div>
            <div class="operasi-additional" style="display: none;">
                <label>Operasi apa?</label>
                <?= Html::textInput('operasi_apa', 'APP', ['class' => 'form-control']) ?>
                <label>Kapan?</label>
                <?= Html::textInput('operasi_kapan', '2017', ['class' => 'form-control']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <label><strong>10. Riwayat pernah dirawat di RS:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'Tidak', ['label' => 'Tidak', 'value' => 'Tidak']) ?>
                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', $model->riwayat_pernah_dirawat == 'Ya', ['label' => 'Ya', 'value' => 'Ya']) ?>
            </div>
            <div class="dirawat-additional" style="display: none;">
                <label>Penyakit apa?</label>
                <?= Html::textInput('dirawat_penyakit', 'post app', ['class' => 'form-control']) ?>
                <label>Kapan?</label>
                <?= Html::textInput('dirawat_kapan', '2017', ['class' => 'form-control']) ?>
            </div>
        </div>
    </div>
</div>

<!-- Pengkajian Resiko Jatuh -->
<div class="form-section">
    <h4>15. Pengkajian resiko jatuh</h4>

    <table class="resiko-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Resiko</th>
                <th>Skala</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Riwayat jatuh yang baru atau dalam 3 bulan terakhir</td>
                <td>Tidak = 0<br>Ya = 25</td>
                <td><?= Html::textInput('resiko[0][hasil]', '25', ['class' => 'form-control resiko-input']) ?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Diagnosa medis sekunder > 1</td>
                <td>Tidak = 0<br>Ya = 15</td>
                <td><?= Html::textInput('resiko[1][hasil]', '15', ['class' => 'form-control resiko-input']) ?></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Alat bantu jalan: Mandiri, bedrest, dibantu perawat, kursi roda<br>Penopang, tongkat/walker<br>Mencengkeram furniture/sesuatu untuk topangan</td>
                <td>0<br>15<br>15</td>
                <td><?= Html::textInput('resiko[2][hasil]', '0', ['class' => 'form-control resiko-input']) ?></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Ad akses IV atau terapi heparin lock</td>
                <td>Tidak = 0<br>Ya = 20</td>
                <td><?= Html::textInput('resiko[3][hasil]', '20', ['class' => 'form-control resiko-input']) ?></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Cara berjalan/berpindah: Normal, lemah, langkah, diseret<br>Terganggu, perlu bantuan, keseimbangan buruk<br>Orientasi sesuai kemampuan diri<br>Lupa keterbatasan diri</td>
                <td>0<br>10<br>20<br>0<br>15</td>
                <td><?= Html::textInput('resiko[4][hasil]', '0', ['class' => 'form-control resiko-input']) ?></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Status mental:</td>
                <td></td>
                <td><?= Html::textInput('resiko[5][hasil]', '0', ['class' => 'form-control resiko-input']) ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Nilai total</strong></td>
                <td><strong><span id="total-resiko">60</span></strong></td>
            </tr>
            <tr>
                <td colspan="4">
                    <span id="kategori-resiko" class="badge badge-danger">Resiko tinggi (>=45)</span><br>
                    <small>Tidak beresiko: 0-24 | Perawatan yang baik Resiko rendah: 25-44<br>
                        Lakukan intervensi jatuh standar | Resiko tinggi: >=45<br>
                        Lakukan intervensi jatuh risiko tinggi</small>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="form-group">
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