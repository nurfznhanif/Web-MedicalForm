<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */
/* @var $registrasi app\models\Registrasi */

$this->title = 'Edit Form Pengkajian Keperawatan';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $registrasi->nama_pasien, 'url' => ['view', 'id' => $registrasi->id_registrasi]];
$this->params['breadcrumbs'][] = ['label' => 'Form Pengkajian', 'url' => ['view-form', 'id' => $model->id_form_data]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<div class="data-form-edit">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> <?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-eye"></i> Lihat Form', ['view-form', 'id' => $model->id_form_data], [
                'class' => 'btn btn-info'
            ]) ?>
            <?= Html::a('<i class="fas fa-times"></i> Batal', ['view-form', 'id' => $model->id_form_data], [
                'class' => 'btn btn-secondary'
            ]) ?>
        </div>
    </div>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Perhatian:</strong> Anda sedang mengedit form pengkajian medis. Pastikan data yang diubah sudah benar.
    </div>

    <!-- Info Form -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Informasi Form</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID Form:</strong> FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?></p>
                    <p><strong>Pasien:</strong> <?= Html::encode($registrasi->nama_pasien) ?></p>
                    <p><strong>No. RM:</strong> <?= Html::encode($registrasi->no_rekam_medis) ?></p>
                </div>
                <div class="col-md-6">
                    <?php
                    $data = $model->getDisplayData();
                    ?>
                    <p><strong>Tanggal Pengkajian:</strong> <?= $data['tanggal_pengkajian'] ?? '-' ?></p>
                    <p><strong>Jam:</strong> <?= $data['jam_pengkajian'] ?? '-' ?></p>
                    <p><strong>Poliklinik:</strong> <?= $data['poliklinik'] ?? '-' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Load data existing ke form properties untuk edit -->
    <?php
    // Load data dari JSON ke model properties untuk form edit
    $data = $model->getDisplayData();

    // Set form properties dari data yang ada
    if (!empty($data)) {
        $model->tanggal_pengkajian = $data['tanggal_pengkajian'] ?? '';
        $model->jam_pengkajian = $data['jam_pengkajian'] ?? '';
        $model->poliklinik = $data['poliklinik'] ?? '';
        $model->cara_masuk = $data['cara_masuk'] ?? '';
        $model->anamnesis = $data['anamnesis'] ?? '';
        $model->alergi = $data['alergi'] ?? '';
        $model->keluhan_utama = $data['keluhan_utama'] ?? '';

        // Pemeriksaan fisik
        $fisik = $data['pemeriksaan_fisik'] ?? [];
        $model->keadaan_umum = $fisik['keadaan_umum'] ?? '';
        $model->warna_kulit = $fisik['warna_kulit'] ?? '';
        $model->kesadaran = $fisik['kesadaran'] ?? '';

        // Tanda vital
        $vital = $fisik['tanda_vital'] ?? [];
        $model->tanda_vital_td = $vital['td'] ?? '';
        $model->tanda_vital_p = $vital['p'] ?? '';
        $model->tanda_vital_n = $vital['n'] ?? '';
        $model->tanda_vital_s = $vital['s'] ?? '';

        // Fungsional
        $fungsional = $fisik['fungsional'] ?? [];
        $model->fungsi_alat_bantu = $fungsional['alat_bantu'] ?? '';
        $model->fungsi_prothesa = $fungsional['prothesa'] ?? '';
        $model->fungsi_cacat_tubuh = $fungsional['cacat_tubuh'] ?? '';
        $model->fungsi_adl = $fungsional['adl'] ?? '';
        $model->riwayat_jatuh_fungsional = $fungsional['riwayat_jatuh'] ?? '';

        // Antropometri
        $antro = $fisik['antropometri'] ?? [];
        $model->antro_berat = $antro['berat'] ?? '';
        $model->antro_tinggi = $antro['tinggi'] ?? '';
        $model->antro_lingkar = $antro['lingkar'] ?? '';
        $model->antro_imt = $antro['imt'] ?? '';

        $model->status_gizi = $data['status_gizi'] ?? '';

        // Riwayat penyakit
        $riwayat = $data['riwayat_penyakit'] ?? [];
        $model->riwayat_penyakit_sekarang = $riwayat['sekarang'] ?? '';
        $model->riwayat_penyakit_sebelumnya = $riwayat['sebelumnya'] ?? '';
        $model->riwayat_penyakit_keluarga = $riwayat['keluarga'] ?? '';

        // Riwayat operasi dan rawat inap
        $model->riwayat_operasi = $data['riwayat_operasi'] ?? '';
        $operasiDetail = $data['operasi_detail'] ?? [];
        $model->operasi_detail_apa = $operasiDetail['apa'] ?? '';
        $model->operasi_detail_kapan = $operasiDetail['kapan'] ?? '';

        $model->riwayat_pernah_dirawat = $data['riwayat_pernah_dirawat'] ?? '';
        $dirawatDetail = $data['dirawat_detail'] ?? [];
        $model->dirawat_detail_penyakit = $dirawatDetail['penyakit'] ?? '';
        $model->dirawat_detail_kapan = $dirawatDetail['kapan'] ?? '';
    }
    ?>

    <!-- Render form yang sama dengan input-form tetapi untuk edit -->
    <?= $this->render('input-form', [
        'model' => $model,
        'registrasi' => $registrasi,
        'isEdit' => true
    ]) ?>
</div>

<?php
// Additional JavaScript untuk edit mode
$this->registerJs("
// Pre-fill risk assessment untuk edit mode
$(document).ready(function() {
    var risikoJatuhData = " . json_encode($data['resiko_jatuh'] ?? []) . ";
    
    if (risikoJatuhData && risikoJatuhData.length > 0) {
        // Set risk assessment values dari data yang ada
        risikoJatuhData.forEach(function(item, index) {
            var riskNum = index + 1;
            var hasil = parseInt(item.hasil) || 0;
            
            // Find dan check radio button yang sesuai dengan nilai
            var riskRadios = document.querySelectorAll('input[name=\"risk' + riskNum + '\"]');
            riskRadios.forEach(function(radio) {
                if (parseInt(radio.getAttribute('data-score')) === hasil) {
                    radio.checked = true;
                }
            });
        });
        
        // Recalculate total setelah set values
        setTimeout(function() {
            hitungResikoJatuh();
        }, 100);
    }
    
    // Show/hide additional fields berdasarkan data existing
    if ('" . ($model->riwayat_operasi ?? '') . "' === 'ya') {
        document.getElementById('operasiFields').style.display = 'block';
    }
    
    if ('" . ($model->riwayat_pernah_dirawat ?? '') . "' === 'ya') {
        document.getElementById('dirawatFields').style.display = 'block';
    }
    
    // Set values untuk additional fields
    if (document.getElementById('operasi_apa')) {
        document.getElementById('operasi_apa').value = '" . ($model->operasi_detail_apa ?? '') . "';
    }
    if (document.getElementById('operasi_kapan')) {
        document.getElementById('operasi_kapan').value = '" . ($model->operasi_detail_kapan ?? '') . "';
    }
    if (document.getElementById('penyakit_apa')) {
        document.getElementById('penyakit_apa').value = '" . ($model->dirawat_detail_penyakit ?? '') . "';
    }
    if (document.getElementById('dirawat_kapan')) {
        document.getElementById('dirawat_kapan').value = '" . ($model->dirawat_detail_kapan ?? '') . "';
    }
});
");
?>