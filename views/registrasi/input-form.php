<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */
/* @var $registrasi app\models\Registrasi */

$this->title = 'Form Pengkajian Keperawatan Poliklinik Kebidanan';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $registrasi->nama_pasien, 'url' => ['view', 'id' => $registrasi->id_registrasi]];
$this->params['breadcrumbs'][] = 'Form Pengkajian';
?>

<div class="data-form-input">
    <div class="header-form">
        <div class="row">
            <div class="col-md-8">
                <h2><i class="fas fa-clipboard-list"></i> <?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-md-4">
                <div class="logo" style="text-align: right;">
                    <strong>PT BIGS INTEGRASI TEKNOLOGI</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Render form menggunakan partial -->
    <?= $this->render('_form', [
        'model' => $model,
        'registrasi' => $registrasi,
        'isEdit' => false
    ]) ?>
</div>

<?php
// CSS untuk header
$this->registerCss("
.header-form {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}
");
?><?= $form->field($model, 'keluhan_utama')->textarea(['rows' => 3, 'placeholder' => 'Masukkan keluhan utama pasien']) ?>
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
                <?= Html::radio('DataForm[keadaan_umum]', false, ['label' => 'Tidak tampak sakit', 'value' => 'tidak_tampak_sakit']) ?>
                <?= Html::radio('DataForm[keadaan_umum]', false, ['label' => 'Sakit ringan', 'value' => 'sakit_ringan']) ?>
                <?= Html::radio('DataForm[keadaan_umum]', false, ['label' => 'Sedang', 'value' => 'sedang']) ?>
                <?= Html::radio('DataForm[keadaan_umum]', false, ['label' => 'Berat', 'value' => 'berat']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>b. Warna kulit:</strong></label>
            <div>
                <?= Html::radio('DataForm[warna_kulit]', false, ['label' => 'Normal', 'value' => 'normal']) ?>
                <?= Html::radio('DataForm[warna_kulit]', false, ['label' => 'Sianosis', 'value' => 'sianosis']) ?>
                <?= Html::radio('DataForm[warna_kulit]', false, ['label' => 'Pucat', 'value' => 'pucat']) ?>
                <?= Html::radio('DataForm[warna_kulit]', false, ['label' => 'Kemerahan', 'value' => 'kemerahan']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>Kesadaran:</strong></label>
            <div>
                <?= Html::radio('DataForm[kesadaran]', false, ['label' => 'Compos mentis', 'value' => 'compos_mentis']) ?>
                <?= Html::radio('DataForm[kesadaran]', false, ['label' => 'Apatis', 'value' => 'apatis']) ?>
                <?= Html::radio('DataForm[kesadaran]', false, ['label' => 'Somnolent', 'value' => 'somnolent']) ?>
                <?= Html::radio('DataForm[kesadaran]', false, ['label' => 'Sopor', 'value' => 'sopor']) ?>
                <?= Html::radio('DataForm[kesadaran]', false, ['label' => 'Soporokoma', 'value' => 'soporokoma']) ?>
                <?= Html::radio('DataForm[kesadaan]', false, ['label' => 'Koma', 'value' => 'koma']) ?>
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
                    <?= Html::textInput('DataForm[tanda_vital_td]', '130/92 mmHg', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label>P:</label>
                    <?= Html::textInput('DataForm[tanda_vital_p]', 'x/menit', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label>N:</label>
                    <?= Html::textInput('DataForm[tanda_vital_n]', '124 x/menit', ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label>S:</label>
                    <?= Html::textInput('DataForm[tanda_vital_s]', '36 oC', ['class' => 'form-control']) ?>
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
                    <div>1. Alat bantu: <?= Html::textInput('DataForm[fungsi_alat_bantu]', '', ['class' => 'form-control']) ?></div>
                    <div>2. Prothesa: <?= Html::textInput('DataForm[fungsi_prothesa]', '', ['class' => 'form-control']) ?></div>
                    <div>3. Cacat tubuh: <?= Html::textInput('DataForm[fungsi_cacat_tubuh]', '', ['class' => 'form-control']) ?></div>
                    <div>4. ADL: <?= Html::textInput('DataForm[fungsi_adl]', '', ['class' => 'form-control']) ?></div>
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
                <?= Html::radio('DataForm[status_gizi]', false, ['label' => 'Ideal', 'value' => 'ideal']) ?>
                <?= Html::radio('DataForm[status_gizi]', false, ['label' => 'Kurang', 'value' => 'kurang']) ?>
                <?= Html::radio('DataForm[status_gizi]', false, ['label' => 'Obesitas / overweight', 'value' => 'obesitas']) ?>
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
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', false, ['label' => 'DM', 'value' => 'dm']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', false, ['label' => 'Hipertensi', 'value' => 'hipertensi']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', false, ['label' => 'Jantung', 'value' => 'jantung']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sekarang]', false, ['label' => 'Lain-lain', 'value' => 'lain_lain']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>6. Riwayat penyakit sebelumnya:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', false, ['label' => 'Tidak', 'value' => 'tidak']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_sebelumnya]', false, ['label' => 'Ya', 'value' => 'ya']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label><strong>7. Riwayat penyakit keluarga:</strong></label>
            <div>
                <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', false, ['label' => 'Tidak', 'value' => 'tidak']) ?>
                <?= Html::radio('DataForm[riwayat_penyakit_keluarga]', false, ['label' => 'Ya', 'value' => 'ya']) ?>
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
                <?= Html::radio('DataForm[riwayat_operasi]', false, ['label' => 'Tidak', 'value' => 'Tidak']) ?>
                <?= Html::radio('DataForm[riwayat_operasi]', false, ['label' => 'Ya', 'value' => 'Ya']) ?>
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
                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', false, ['label' => 'Tidak', 'value' => 'Tidak']) ?>
                <?= Html::radio('DataForm[riwayat_pernah_dirawat]', false, ['label' => 'Ya', 'value' => 'Ya']) ?>
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
    <?= Html::submitButton('Simpan Data Form', ['class' => 'btn btn-primary btn-lg']) ?>
    <?= Html::a('Batal', ['view', 'id' => $registrasi->id_registrasi], ['class' => 'btn btn-secondary btn-lg']) ?>
</div>

<?php ActiveForm::end(); ?>