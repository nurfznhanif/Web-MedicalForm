<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrasi */

$this->title = 'Tambah Registrasi Pasien';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="registrasi-create">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-user-plus"></i> <?= Html::encode($this->title) ?>
            </h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'row g-3'],
            ]); ?>

            <div class="col-md-6">
                <?= $form->field($model, 'nama_pasien')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Masukkan nama lengkap pasien'
                ])->label('Nama Pasien <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'nik')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Masukkan NIK (16 digit)'
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'tanggal_lahir')->input('date') ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'no_rekam_medis')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Kosongkan untuk generate otomatis',
                    'readonly' => true
                ])->hint('Nomor rekam medis akan digenerate otomatis') ?>
            </div>

            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi:</strong>
                    <ul class="mb-0">
                        <li>Nomor registrasi akan digenerate otomatis dengan format: REG + Tanggal + Nomor urut</li>
                        <li>Nomor rekam medis akan digenerate otomatis dengan format: RM + Tahun + Nomor urut</li>
                        <li>Field yang bertanda <span class="text-danger">*</span> wajib diisi</li>
                    </ul>
                </div>
            </div>

            <div class="col-12">
                <hr>
                <div class="d-flex gap-2">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Simpan', [
                        'class' => 'btn btn-success'
                    ]) ?>
                    <?= Html::a('<i class="fas fa-times"></i> Batal', ['index'], [
                        'class' => 'btn btn-secondary'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
// JavaScript untuk validasi NIK
$this->registerJs("
$('#registrasi-nik').on('input', function() {
    var nik = $(this).val();
    var nikPattern = /^[0-9]{16}$/;
    
    if (nik.length > 0) {
        if (!nikPattern.test(nik)) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class=\"invalid-feedback\">NIK harus 16 digit angka</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    } else {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    }
});

// Auto uppercase nama
$('#registrasi-nama_pasien').on('input', function() {
    $(this).val($(this).val().toUpperCase());
});
");

// CSS untuk styling
$this->registerCss("
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.alert-info {
    border-left: 4px solid #17a2b8;
}
.text-danger {
    color: #dc3545 !important;
}
");
?>