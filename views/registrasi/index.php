<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Data Registrasi Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="registrasi-index">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="color: #1e3a8a; font-weight: 700;">
                <i class="fas fa-users me-2" style="color: #f59e0b;"></i>
                Data Registrasi Pasien
            </h1>
            <p class="text-muted mb-0">Kelola data registrasi dan form pengkajian medis</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card-modern">
        <div style="background: linear-gradient(135deg, #3b82f6, #1e3a8a); color: white; padding: 1.5rem;">
            <h5 class="mb-0">
                <i class="fas fa-table"></i>
                Data Registrasi
            </h5>
        </div>
        <div style="padding: 1.5rem;">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped table-bordered'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'no_registrasi',
                        'label' => 'No. Registrasi',
                    ],
                    [
                        'attribute' => 'nama_pasien',
                        'label' => 'Nama Pasien',
                        'value' => function ($model) {
                            return Html::tag(
                                'div',
                                Html::tag('div', Html::encode($model->nama_pasien), ['class' => 'fw-semibold']) .
                                    Html::tag('small', Html::encode($model->no_registrasi), ['class' => 'text-muted'])
                            );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'no_rekam_medis',
                        'label' => 'No. RM',
                        'value' => function ($model) {
                            return Html::tag('span', Html::encode($model->no_rekam_medis), [
                                'class' => 'badge',
                                'style' => 'background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 58, 138, 0.1)); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); padding: 0.5rem 1rem; border-radius: 20px;'
                            ]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'tanggal_lahir',
                        'label' => 'Tanggal Lahir',
                        'value' => function ($model) {
                            if ($model->tanggal_lahir) {
                                $tgl = date('d/m/Y', strtotime($model->tanggal_lahir));
                                $umur = date_diff(date_create($model->tanggal_lahir), date_create('now'))->y;
                                return Html::tag('div', $tgl) .
                                    Html::tag('small', "({$umur} tahun)", ['class' => 'text-muted']);
                            }
                            return '-';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'create_time_at',
                        'label' => 'Tanggal Daftar',
                        'value' => function ($model) {
                            if ($model->create_time_at) {
                                $tgl = date('d/m/Y', strtotime($model->create_time_at));
                                $jam = date('H:i', strtotime($model->create_time_at));
                                return Html::tag('div', $tgl) .
                                    Html::tag('small', $jam, ['class' => 'text-muted']);
                            }
                            return '-';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Aksi',
                        'template' => '{view} {edit} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'title' => 'Lihat Detail',
                                    'class' => 'btn btn-sm me-1',
                                    'style' => 'background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; border: none; border-radius: 6px; padding: 0.5rem 0.75rem;'
                                ]);
                            },
                            'edit' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id_registrasi], [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-sm me-1',
                                    'style' => 'background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; border-radius: 6px; padding: 0.5rem 0.75rem;'
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id_registrasi], [
                                    'title' => 'Hapus',
                                    'class' => 'btn btn-sm',
                                    'style' => 'background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 6px; padding: 0.5rem 0.75rem;',
                                    'data' => [
                                        'confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
                                        'method' => 'post',
                                        'params' => [
                                            Yii::$app->request->csrfParam => Yii::$app->request->csrfToken,
                                        ],
                                    ],
                                ]);
                            },
                        ],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <?= Html::a('<i class="fas fa-plus"></i> Tambah Registrasi', ['create'], ['class' => 'btn-modern btn-success-modern', 'style' => 'margin-top: 10px;']) ?>
</div>

<style>
    .table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #1f2937;
        border-bottom: 2px solid #e5e7eb;
    }

    .table td {
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .table tr:hover {
        background-color: #f8fafc;
    }
</style>

<script>
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'n') {
            e.preventDefault();
            window.location.href = '<?= \yii\helpers\Url::to(["/registrasi/create"]) ?>';
        }
    });
</script>