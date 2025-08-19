<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */

$this->title = 'Detail Form Pengkajian Medis';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->registrasi->nama_pasien ?? 'Pasien', 'url' => ['view', 'id' => $model->id_registrasi]];
$this->params['breadcrumbs'][] = $this->title;

// Load data dari JSON
$data = $model->data;
if (is_string($data)) {
    $data = json_decode($data, true);
}
?>

<div class="data-form-view">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-clipboard-check"></i> <?= Html::encode($this->title) ?></h1>
        <div class="btn-group">
            <?= Html::a('<i class="fas fa-print"></i> Print', ['print-form', 'id' => $model->id_form_data], [
                'class' => 'btn btn-secondary',
                'target' => '_blank'
            ]) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Edit', ['edit-form', 'id' => $model->id_form_data], [
                'class' => 'btn btn-warning'
            ]) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete-form', 'id' => $model->id_form_data], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus form ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- Info Pasien -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-user"></i> Informasi Pasien</h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model->registrasi,
                        'options' => ['class' => 'table table-striped detail-view'],
                        'attributes' => [
                            'no_registrasi:text:No. Registrasi',
                            'no_rekam_medis:text:No. Rekam Medis',
                            'nama_pasien:text:Nama Pasien',
                            [
                                'attribute' => 'tanggal_lahir',
                                'label' => 'Tanggal Lahir',
                                'value' => function ($model) {
                                    return $model->tanggal_lahir ? date('d/m/Y', strtotime($model->tanggal_lahir)) : '-';
                                }
                            ],
                            'nik:text:NIK',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-calendar"></i> Info Form</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID Form:</strong> FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?></p>
                    <p><strong>Tanggal Pengkajian:</strong> <?= $data['tanggal_pengkajian'] ?? '-' ?></p>
                    <p><strong>Jam:</strong> <?= $data['jam_pengkajian'] ?? '-' ?></p>
                    <p><strong>Poliklinik:</strong> <?= $data['poliklinik'] ?? '-' ?></p>
                    <p><strong>Dibuat:</strong> <?= date('d/m/Y H:i', strtotime($model->create_time_at)) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Form -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0"><i class="fas fa-clipboard-list"></i> Data Pengkajian Medis</h5>
        </div>
        <div class="card-body">

            <!-- Pengkajian Awal -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="border-bottom pb-2 mb-3"><strong>Pengkajian saat datang</strong></h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Cara masuk:</strong> <?= ucwords(str_replace('_', ' ', $data['cara_masuk'] ?? '-')) ?></p>
                            <p><strong>Anamnesis:</strong> <?= ucwords($data['anamnesis'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Alergi:</strong> <?= $data['alergi'] ?? '-' ?></p>
                        </div>
                    </div>
                    <p><strong>Keluhan utama:</strong> <?= $data['keluhan_utama'] ?? '-' ?></p>
                </div>
            </div>

            <!-- Pemeriksaan Fisik -->
            <?php if (isset($data['pemeriksaan_fisik'])): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3"><strong>Pemeriksaan Fisik</strong></h6>

                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Keadaan umum:</strong> <?= ucwords(str_replace('_', ' ', $data['pemeriksaan_fisik']['keadaan_umum'] ?? '-')) ?></p>
                                <p><strong>Warna kulit:</strong> <?= ucwords($data['pemeriksaan_fisik']['warna_kulit'] ?? '-') ?></p>
                                <p><strong>Kesadaran:</strong> <?= ucwords(str_replace('_', ' ', $data['pemeriksaan_fisik']['kesadaran'] ?? '-')) ?></p>
                            </div>
                            <div class="col-md-4">
                                <strong>Tanda Vital:</strong>
                                <?php if (isset($data['pemeriksaan_fisik']['tanda_vital'])): ?>
                                    <ul class="list-unstyled ms-3">
                                        <li>TD: <?= $data['pemeriksaan_fisik']['tanda_vital']['td'] ?? '-' ?></li>
                                        <li>P: <?= $data['pemeriksaan_fisik']['tanda_vital']['p'] ?? '-' ?></li>
                                        <li>N: <?= $data['pemeriksaan_fisik']['tanda_vital']['n'] ?? '-' ?></li>
                                        <li>S: <?= $data['pemeriksaan_fisik']['tanda_vital']['s'] ?? '-' ?></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <strong>Antropometri:</strong>
                                <?php if (isset($data['pemeriksaan_fisik']['antropometri'])): ?>
                                    <ul class="list-unstyled ms-3">
                                        <li>Berat: <?= $data['pemeriksaan_fisik']['antropometri']['berat'] ?? '-' ?> Kg</li>
                                        <li>Tinggi: <?= $data['pemeriksaan_fisik']['antropometri']['tinggi'] ?? '-' ?> Cm</li>
                                        <li>IMT: <?= $data['pemeriksaan_fisik']['antropometri']['imt'] ?? '-' ?></li>
                                        <li>Lingkar: <?= $data['pemeriksaan_fisik']['antropometri']['lingkar'] ?? '-' ?> Cm</li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (isset($data['pemeriksaan_fisik']['fungsional'])): ?>
                            <div class="mt-3">
                                <strong>Fungsional:</strong>
                                <ul class="list-unstyled ms-3">
                                    <li>Alat bantu: <?= $data['pemeriksaan_fisik']['fungsional']['alat_bantu'] ?: '-' ?></li>
                                    <li>Prothesa: <?= $data['pemeriksaan_fisik']['fungsional']['prothesa'] ?: '-' ?></li>
                                    <li>Cacat tubuh: <?= $data['pemeriksaan_fisik']['fungsional']['cacat_tubuh'] ?: '-' ?></li>
                                    <li>ADL: <?= $data['pemeriksaan_fisik']['fungsional']['adl'] ?: '-' ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Status Gizi -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="border-bottom pb-2 mb-3"><strong>Status Gizi</strong></h6>
                    <p><?= ucwords($data['status_gizi'] ?? '-') ?></p>
                </div>
            </div>

            <!-- Riwayat Penyakit -->
            <?php if (isset($data['riwayat_penyakit'])): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3"><strong>Riwayat Penyakit</strong></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Sekarang:</strong> <?= ucwords($data['riwayat_penyakit']['sekarang'] ?? '-') ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Sebelumnya:</strong> <?= ucwords($data['riwayat_penyakit']['sebelumnya'] ?? '-') ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Keluarga:</strong> <?= ucwords($data['riwayat_penyakit']['keluarga'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Riwayat Operasi & Rawat Inap -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="border-bottom pb-2 mb-3"><strong>Riwayat Operasi & Rawat Inap</strong></h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Riwayat operasi:</strong> <?= $data['riwayat_operasi'] ?? '-' ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Riwayat dirawat:</strong> <?= $data['riwayat_pernah_dirawat'] ?? '-' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resiko Jatuh -->
            <?php if (isset($data['resiko_jatuh']) && is_array($data['resiko_jatuh'])): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3"><strong>Pengkajian Resiko Jatuh</strong></h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Resiko</th>
                                        <th>Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($data['resiko_jatuh'] as $index => $item):
                                        $hasil = (int)($item['hasil'] ?? 0);
                                        $total += $hasil;
                                    ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $item['resiko'] ?? '-' ?></td>
                                            <td class="text-center"><?= $hasil ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-secondary">
                                        <td colspan="2"><strong>Total Skor</strong></td>
                                        <td class="text-center"><strong><?= $total ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="alert <?= $total <= 24 ? 'alert-success' : ($total <= 44 ? 'alert-warning' : 'alert-danger') ?>">
                            <strong>Kategori Resiko:</strong>
                            <?php if ($total <= 24): ?>
                                Tidak beresiko (0-24)
                            <?php elseif ($total <= 44): ?>
                                Resiko rendah (25-44)
                            <?php else: ?>
                                Resiko tinggi (>=45)
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Navigation -->
    <div class="mt-4">
        <?= Html::a(
            '<i class="fas fa-arrow-left"></i> Kembali ke Detail Pasien',
            ['view', 'id' => $model->id_registrasi],
            [
                'class' => 'btn btn-secondary'
            ]
        ) ?>
        <?= Html::a('<i class="fas fa-list"></i> Daftar Registrasi', ['index'], [
            'class' => 'btn btn-outline-secondary'
        ]) ?>
    </div>
</div>

<?php
// CSS untuk styling
$this->registerCss("
.detail-view th {
    background-color: #f8f9fa;
    width: 30%;
    font-weight: 600;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
.btn-group .btn {
    margin-left: 5px;
}
.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}
");
?>