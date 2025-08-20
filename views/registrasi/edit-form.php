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

    <!-- Render form yang sama dengan input-form tetapi untuk edit -->
    <?= $this->render('_form', [
        'model' => $model,
        'registrasi' => $registrasi,
        'isEdit' => true
    ]) ?>
</div>

<?php
// Additional JavaScript untuk edit mode
$this->registerJs("
// Initialize edit mode dengan data existing
$(document).ready(function() {
    // Auto-fill values berdasarkan data existing
    var existingData = " . json_encode($data) . ";
    
    // Show/hide additional fields berdasarkan data existing
    if ('" . ($model->riwayat_operasi ?? '') . "' === 'ya') {
        $('#operasiFields').show();
    }
    
    if ('" . ($model->riwayat_pernah_dirawat ?? '') . "' === 'ya') {
        $('#dirawatFields').show();
    }
    
    // Recalculate IMT dan risk assessment
    setTimeout(function() {
        hitungIMT();
        hitungResikoJatuh();
    }, 100);
});
");
?>