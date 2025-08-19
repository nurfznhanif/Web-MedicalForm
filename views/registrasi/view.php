<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\DataForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrasi */

$this->title = $model->nama_pasien;
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Data provider untuk form medis
$dataFormProvider = new ActiveDataProvider([
    'query' => DataForm::find()->where(['id_registrasi' => $model->id_registrasi, 'is_delete' => false]),
    'pagination' => ['pageSize' => 10],
    'sort' => ['defaultOrder' => ['id_form_data' => SORT_DESC]]
]);
?>

<div class="registrasi-view">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user"></i> <?= Html::encode($this->title) ?></h1>
        <div class="btn-group">
            <?= Html::a('<i class="fas fa-plus-circle"></i> Input Form', ['input-form', 'id_registrasi' => $model->id_registrasi], [
                'class' => 'btn btn-success'
            ]) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $model->id_registrasi], [
                'class' => 'btn btn-warning'
            ]) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id_registrasi], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus data registrasi ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- Detail Registrasi -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Detail Registrasi</h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped detail-view'],
                        'attributes' => [
                            [
                                'attribute' => 'no_registrasi',
                                'label' => 'No. Registrasi',
                            ],
                            [
                                'attribute' => 'no_rekam_medis',
                                'label' => 'No. Rekam Medis',
                            ],
                            [
                                'attribute' => 'nama_pasien',
                                'label' => 'Nama Pasien',
                            ],
                            [
                                'attribute' => 'tanggal_lahir',
                                'label' => 'Tanggal Lahir',
                                'value' => function ($model) {
                                    if ($model->tanggal_lahir) {
                                        $tgl_lahir = new DateTime($model->tanggal_lahir);
                                        $sekarang = new DateTime();
                                        $umur = $sekarang->diff($tgl_lahir);
                                        return date('d/m/Y', strtotime($model->tanggal_lahir)) .
                                            ' (' . $umur->y . ' tahun)';
                                    }
                                    return '-';
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
                                'label' => 'Tanggal Registrasi',
                                'value' => function ($model) {
                                    return $model->create_time_at ?
                                        date('d/m/Y H:i:s', strtotime($model->create_time_at)) : '-';
                                }
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Statistik</h5>
                </div>
                <div class="card-body">
                    <?php
                    $totalForms = DataForm::find()->where(['id_registrasi' => $model->id_registrasi, 'is_delete' => false])->count();
                    $lastForm = DataForm::find()->where(['id_registrasi' => $model->id_registrasi, 'is_delete' => false])
                        ->orderBy('create_time_at DESC')->one();
                    ?>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h3 class="text-primary"><?= $totalForms ?></h3>
                                <small class="text-muted">Total Form</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h6 class="text-success">
                                    <?= $lastForm ? date('d/m/Y', strtotime($lastForm->create_time_at)) : '-' ?>
                                </h6>
                                <small class="text-muted">Form Terakhir</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-light">
                        <i class="fas fa-lightbulb text-warning"></i>
                        <strong>Tips:</strong> Klik tombol "Input Form" untuk menambah pengkajian medis baru
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Form Medis -->
    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0"><i class="fas fa-clipboard-list"></i> Riwayat Form Pengkajian Medis</h5>
        </div>
        <div class="card-body">
            <?php if ($totalForms > 0): ?>
                <?= GridView::widget([
                    'dataProvider' => $dataFormProvider,
                    'tableOptions' => ['class' => 'table table-striped table-bordered'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'id_form_data',
                            'label' => 'ID Form',
                            'value' => function ($model) {
                                return 'FM' . str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT);
                            }
                        ],
                        [
                            'label' => 'Tanggal Pengkajian',
                            'value' => function ($model) {
                                return $model->tanggal_pengkajian ?
                                    date('d/m/Y', strtotime($model->tanggal_pengkajian)) : '-';
                            }
                        ],
                        [
                            'label' => 'Jam Pengkajian',
                            'value' => function ($model) {
                                return $model->jam_pengkajian ?: '-';
                            }
                        ],
                        [
                            'label' => 'Poliklinik',
                            'value' => function ($model) {
                                return $model->poliklinik ?: '-';
                            }
                        ],
                        [
                            'attribute' => 'create_time_at',
                            'label' => 'Dibuat',
                            'value' => function ($model) {
                                return $model->create_time_at ?
                                    date('d/m/Y H:i', strtotime($model->create_time_at)) : '-';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Aksi',
                            'template' => '{view} {print} {edit} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fas fa-eye"></i>',
                                        ['view-form', 'id' => $model->id_form_data],
                                        [
                                            'title' => 'Lihat Form',
                                            'class' => 'btn btn-sm btn-info me-1',
                                        ]
                                    );
                                },
                                'print' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fas fa-print"></i>',
                                        ['print-form', 'id' => $model->id_form_data],
                                        [
                                            'title' => 'Print Form',
                                            'class' => 'btn btn-sm btn-secondary me-1',
                                            'target' => '_blank'
                                        ]
                                    );
                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fas fa-edit"></i>',
                                        ['edit-form', 'id' => $model->id_form_data],
                                        [
                                            'title' => 'Edit Form',
                                            'class' => 'btn btn-sm btn-warning me-1',
                                        ]
                                    );
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fas fa-trash"></i>',
                                        ['delete-form', 'id' => $model->id_form_data],
                                        [
                                            'title' => 'Hapus Form',
                                            'class' => 'btn btn-sm btn-danger',
                                            'data' => [
                                                'confirm' => 'Apakah Anda yakin ingin menghapus form ini?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                },
                            ],
                            'contentOptions' => ['style' => 'white-space: nowrap;'],
                        ],
                    ],
                ]); ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada form pengkajian</h5>
                    <p class="text-muted">Klik tombol "Input Form" untuk menambah pengkajian medis</p>
                    <?= Html::a(
                        '<i class="fas fa-plus-circle"></i> Input Form Pertama',
                        ['input-form', 'id_registrasi' => $model->id_registrasi],
                        [
                            'class' => 'btn btn-success btn-lg'
                        ]
                    ) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation -->
    <div class="mt-4">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], [
            'class' => 'btn btn-secondary'
        ]) ?>
    </div>
</div>

<?php
// CSS untuk styling
$this->registerCss("
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
.detail-view th {
    background-color: #f8f9fa;
    width: 40%;
    font-weight: 600;
}
.btn-group .btn {
    margin-left: 5px;
}
.alert-light {
    background-color: #fefefe;
    border-color: #fdfdfe;
}
");
?>