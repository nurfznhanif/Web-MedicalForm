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

// Custom CSS for this page
$this->registerCss("
.patient-hero {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    border-radius: 20px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
}

.patient-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.patient-hero .patient-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-right: 1.5rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--secondary-blue), var(--accent-yellow));
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}

.action-buttons .btn {
    flex: 1;
    min-width: 200px;
    padding: 1rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.875rem;
}

.forms-section {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.empty-state {
    padding: 4rem 2rem;
    text-align: center;
    background: linear-gradient(135deg, var(--gray-50), #ffffff);
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, var(--gray-200), var(--gray-300));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: var(--gray-500);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.table-modern {
    border-radius: 0;
    box-shadow: none;
    background: transparent;
}

.table-modern thead th {
    background: var(--gray-50);
    border: none;
    font-weight: 600;
    color: var(--gray-700);
    padding: 1.5rem 1rem;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
}

.table-modern tbody tr {
    border-bottom: 1px solid var(--gray-100);
}

.table-modern tbody tr:hover {
    background: var(--light-yellow);
}

.table-modern td {
    padding: 1.5rem 1rem;
    border: none;
    vertical-align: middle;
}

.form-id-badge {
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.action-btn-group {
    display: flex;
    gap: 0.5rem;
}

.action-btn-group .btn {
    width: 40px;
    height: 40px;
    padding: 0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.detail-view-modern th {
    background: var(--gray-50);
    border: none;
    font-weight: 600;
    color: var(--gray-700);
    padding: 1rem 1.5rem;
    width: 40%;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
}

.detail-view-modern td {
    padding: 1rem 1.5rem;
    border: none;
    color: var(--gray-800);
    font-weight: 500;
}

.patient-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--light-yellow), var(--accent-yellow));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
    font-size: 1.25rem;
    flex-shrink: 0;
}

.info-content h6 {
    margin: 0;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: var(--gray-500);
    font-weight: 600;
    letter-spacing: 0.1em;
}

.info-content p {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
        min-width: auto;
    }
    
    .patient-hero {
        padding: 1.5rem;
    }
    
    .patient-hero .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .patient-hero .patient-avatar {
        margin: 0 auto 1rem;
    }
    
    .action-btn-group {
        justify-content: center;
        flex-wrap: wrap;
    }
}
");
?>

<div class="registrasi-view fade-in">
    <!-- Patient Hero Section -->
    <div class="patient-hero slide-up">
        <div class="d-flex align-items-center position-relative">
            <div class="patient-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="flex-grow-1">
                <h1 class="mb-2 fw-bold"><?= Html::encode($this->title) ?></h1>
                <div class="patient-info-grid">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <h6>No. Rekam Medis</h6>
                            <p><?= Html::encode($model->no_rekam_medis) ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <h6>Tanggal Lahir</h6>
                            <p><?php
                                if ($model->tanggal_lahir) {
                                    $tgl_lahir = new DateTime($model->tanggal_lahir);
                                    $sekarang = new DateTime();
                                    $umur = $sekarang->diff($tgl_lahir);
                                    echo date('d/m/Y', strtotime($model->tanggal_lahir)) . ' (' . $umur->y . ' tahun)';
                                } else {
                                    echo '-';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-hashtag"></i>
                        </div>
                        <div class="info-content">
                            <h6>No. Registrasi</h6>
                            <p><?= Html::encode($model->no_registrasi) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card scale-in">
                <div class="card-header bg-primary">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Detail Registrasi
                    </h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table detail-view-modern'],
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
            <div class="card scale-in">
                <div class="card-header bg-info">
                    <h5 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Statistik & Info
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    $totalForms = DataForm::find()->where(['id_registrasi' => $model->id_registrasi, 'is_delete' => false])->count();
                    $lastForm = DataForm::find()->where(['id_registrasi' => $model->id_registrasi, 'is_delete' => false])
                        ->orderBy('create_time_at DESC')->one();
                    ?>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="stats-number"><?= $totalForms ?></div>
                                <div class="stats-label">Total Form</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="stats-number"><?= $lastForm ? date('d/m', strtotime($lastForm->create_time_at)) : '—' ?></div>
                                <div class="stats-label">Form Terakhir</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lightbulb text-warning me-3 fa-2x"></i>
                            <div>
                                <strong>Tips Penggunaan</strong>
                                <p class="mb-0 small">Klik tombol "Input Form Baru" untuk menambah pengkajian medis terbaru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Forms Section -->
    <div class="forms-section slide-up">
        <div class="card-header bg-success">
            <h5 class="card-title">
                <i class="fas fa-clipboard-list"></i>
                Riwayat Form Pengkajian Medis
            </h5>
        </div>
        <div class="card-body p-0">
            <?php if ($totalForms > 0): ?>
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataFormProvider,
                        'tableOptions' => ['class' => 'table table-modern mb-0'],
                        'layout' => '{items}{pager}',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id_form_data',
                                'label' => 'ID Form',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '<span class="form-id-badge">FM' . str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) . '</span>';
                                }
                            ],
                            [
                                'label' => 'Tanggal Pengkajian',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $date = $model->tanggal_pengkajian ? date('d/m/Y', strtotime($model->tanggal_pengkajian)) : '-';
                                    return '<div class="d-flex align-items-center">
                                                <i class="fas fa-calendar text-primary me-2"></i>
                                                <span>' . $date . '</span>
                                            </div>';
                                }
                            ],
                            [
                                'label' => 'Jam',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $time = $model->jam_pengkajian ?: '-';
                                    return '<div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-info me-2"></i>
                                                <span>' . $time . '</span>
                                            </div>';
                                }
                            ],
                            [
                                'label' => 'Poliklinik',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $poli = $model->poliklinik ?: '-';
                                    return '<div class="d-flex align-items-center">
                                                <i class="fas fa-hospital text-success me-2"></i>
                                                <span>' . Html::encode($poli) . '</span>
                                            </div>';
                                }
                            ],
                            [
                                'attribute' => 'create_time_at',
                                'label' => 'Dibuat',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $created = $model->create_time_at ? date('d/m/Y H:i', strtotime($model->create_time_at)) : '-';
                                    return '<small class="text-muted">' . $created . '</small>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Aksi',
                                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 200px;'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{view} {print} {edit} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-eye"></i>',
                                            ['view-form', 'id' => $model->id_form_data],
                                            [
                                                'title' => 'Lihat Form',
                                                'class' => 'btn btn-sm btn-info',
                                                'data-bs-toggle' => 'tooltip'
                                            ]
                                        );
                                    },
                                    'print' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-print"></i>',
                                            ['print-form', 'id' => $model->id_form_data],
                                            [
                                                'title' => 'Print Form',
                                                'class' => 'btn btn-sm btn-secondary',
                                                'target' => '_blank',
                                                'data-bs-toggle' => 'tooltip'
                                            ]
                                        );
                                    },
                                    'edit' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-edit"></i>',
                                            ['edit-form', 'id' => $model->id_form_data],
                                            [
                                                'title' => 'Edit Form',
                                                'class' => 'btn btn-sm btn-warning',
                                                'data-bs-toggle' => 'tooltip'
                                            ]
                                        );
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-trash"></i>', '#', [
                                            'title' => 'Hapus Form Permanen',
                                            'class' => 'btn btn-sm btn-danger',
                                            'data-bs-toggle' => 'tooltip',
                                            'onclick' => "
                                                if (confirm('Apakah Anda yakin ingin menghapus PERMANEN form ini?\\n\\nTindakan ini tidak dapat dibatalkan!')) {
                                                    var form = document.createElement('form');
                                                    form.method = 'POST';
                                                    form.action = '" . \yii\helpers\Url::to(['hard-delete-form', 'id' => $model->id_form_data]) . "';
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
                            ],
                        ],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                            'options' => ['class' => 'pagination justify-content-center mt-4'],
                            'linkOptions' => ['class' => 'page-link'],
                            'activePageCssClass' => 'active',
                            'disabledPageCssClass' => 'disabled',
                        ],
                    ]); ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="text-muted mb-3">Belum Ada Form Pengkajian</h4>
                    <p class="text-muted mb-4">Pasien ini belum memiliki riwayat form pengkajian medis. Mulai dengan menambahkan form pengkajian pertama.</p>
                    <?= Html::a(
                        '<i class="fas fa-plus-circle me-2"></i>Input Form Pertama',
                        ['input-form', 'id_registrasi' => $model->id_registrasi],
                        [
                            'class' => 'btn btn-success btn-lg'
                        ]
                    ) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
        <?= Html::a('<i class="fas fa-plus-circle me-2"></i>Input Form Baru', ['input-form', 'id_registrasi' => $model->id_registrasi], [
            'class' => 'btn btn-success'
        ]) ?>
    </div>

    <!-- Navigation -->
    <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
        <div>
            <?= Html::a('<i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar', ['index'], [
                'class' => 'btn btn-outline-secondary'
            ]) ?>
        </div>
    </div>
</div>

<?php
// JavaScript untuk tooltips dan animasi
$this->registerJs("
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Counter animation
function animateCounter(element, target) {
    let current = 0;
    const increment = target / 100;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 20);
}

// Animate statistics when page loads
document.addEventListener('DOMContentLoaded', function() {
    const statsNumbers = document.querySelectorAll('.stats-number');
    statsNumbers.forEach(element => {
        const target = parseInt(element.textContent);
        if (!isNaN(target)) {
            element.textContent = '0';
            setTimeout(() => animateCounter(element, target), 500);
        }
    });
});

// Confirm dialog enhancement
window.confirmDelete = function(message, action) {
    if (confirm(message)) {
        // Add loading state
        const btn = event.target.closest('a');
        if (btn) {
            btn.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i>';
            btn.classList.add('disabled');
        }
        return action();
    }
    return false;
};
");
?>