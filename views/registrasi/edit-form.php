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

    <!-- Render form yang sama dengan input-form -->
    <?= $this->render('_form', [
        'model' => $model,
        'registrasi' => $registrasi,
        'isEdit' => true
    ]) ?>
</div>