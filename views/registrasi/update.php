<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrasi */

$this->title = 'Edit Registrasi: ' . $model->nama_pasien;
$this->params['breadcrumbs'][] = ['label' => 'Data Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_pasien, 'url' => ['view', 'id' => $model->id_registrasi]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<div class="registrasi-update">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i> <?= Html::encode($this->title) ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'options' => ['class' => 'needs-validation', 'novalidate' => true],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'nama_pasien')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Masukkan nama lengkap pasien',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'nik')->textInput([
                                'type' => 'number',
                                'placeholder' => 'Masukkan NIK (16 digit)',
                                'required' => true,
                                'maxlength' => 16
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'tanggal_lahir')->textInput([
                                'type' => 'date',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. Registrasi</label>
                                <input type="text" class="form-control" value="<?= Html::encode($model->no_registrasi) ?>" readonly>
                                <small class="form-text text-muted">Nomor registrasi tidak dapat diubah</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. Rekam Medis</label>
                                <input type="text" class="form-control" value="<?= Html::encode($model->no_rekam_medis) ?>" readonly>
                                <small class="form-text text-muted">Nomor rekam medis tidak dapat diubah</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Dibuat</label>
                                <input type="text" class="form-control" value="<?= Yii::$app->formatter->asDatetime($model->create_time_at) ?>" readonly>
                                <small class="form-text text-muted">Tanggal pembuatan data</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="d-flex gap-2">
                            <?= Html::submitButton('<i class="fas fa-save"></i> Update', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                            <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['index'], [
                                'class' => 'btn btn-secondary'
                            ]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // NIK validation
    document.querySelector('input[name="Registrasi[nik]"]').addEventListener('input', function(e) {
        let value = e.target.value;
        if (value.length > 16) {
            e.target.value = value.slice(0, 16);
        }
    });
</script>