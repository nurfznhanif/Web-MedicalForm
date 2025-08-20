<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Registrasi Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="registrasi-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fas fa-plus"></i> Tambah Registrasi', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'no_registrasi',
                'label' => 'No. Registrasi',
                'value' => function ($model) {
                    return $model->no_registrasi;
                }
            ],
            [
                'attribute' => 'no_rekam_medis',
                'label' => 'No. Rekam Medis',
                'value' => function ($model) {
                    return $model->no_rekam_medis;
                }
            ],
            [
                'attribute' => 'nama_pasien',
                'label' => 'Nama Pasien',
                'value' => function ($model) {
                    return $model->nama_pasien;
                }
            ],
            [
                'attribute' => 'tanggal_lahir',
                'label' => 'Tanggal Lahir',
                'value' => function ($model) {
                    return $model->tanggal_lahir ? date('d/m/Y', strtotime($model->tanggal_lahir)) : '-';
                }
            ],
            [
                'attribute' => 'nik',
                'label' => 'NIK',
                'value' => function ($model) {
                    return $model->nik ?: '-';
                }
            ],
            [
                'attribute' => 'create_time_at',
                'label' => 'Tanggal Daftar',
                'value' => function ($model) {
                    return $model->create_time_at ? date('d/m/Y H:i', strtotime($model->create_time_at)) : '-';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'template' => '{view} {input} {edit} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => 'Lihat Detail',
                            'class' => 'btn btn-sm btn-info me-1',
                        ]);
                    },
                    'input' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-plus-circle"></i>', ['input-form', 'id_registrasi' => $model->id_registrasi], [
                            'title' => 'Input Form Medis',
                            'class' => 'btn btn-sm btn-success me-1',
                        ]);
                    },
                    'edit' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id_registrasi], [
                            'title' => 'Edit',
                            'class' => 'btn btn-sm btn-warning me-1',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash"></i>', '#', [
                            'title' => 'Hapus',
                            'class' => 'btn btn-sm btn-danger',
                            'onclick' => "
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '" . \yii\helpers\Url::to(['delete', 'id' => $model->id_registrasi]) . "';
                var token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_csrf';
                token.value = '" . Yii::$app->request->getCsrfToken() . "';
                form.appendChild(token);
                document.body.appendChild(form);
                form.submit();
            }
            return false;
        ",
                        ]);
                    },
                ],
                'contentOptions' => ['style' => 'white-space: nowrap;'],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <!-- Informasi -->
    <div class="alert alert-info mt-4">
        <h5><i class="fas fa-info-circle"></i> Informasi:</h5>
        <ul class="mb-0">
            <li><strong>Input:</strong> Untuk menambah form pengkajian medis baru</li>
            <li><strong>Edit:</strong> Untuk mengubah data registrasi</li>
            <li><strong>Delete:</strong> Untuk menghapus data registrasi</li>
        </ul>
    </div>
</div>

<?php
// CSS untuk styling tambahan
$this->registerCss("
.btn-group-action {
    white-space: nowrap;
}
.btn-group-action .btn {
    margin-right: 5px;
}
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
.alert-info {
    border-left: 4px solid #17a2b8;
}
");
?>