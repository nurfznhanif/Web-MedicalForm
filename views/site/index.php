<?php

use yii\helpers\Html;

$this->title = 'Dashboard';
?>

<div class="site-index">
    <!-- Welcome Card -->
    <div class="card-modern mb-4">
        <div style="background: linear-gradient(135deg, #3b82f6, #1e3a8a); color: white; padding: 1.5rem;">
            <h5 class="mb-0">
                <i class="fas fa-user-md"></i>
                Selamat Datang!
            </h5>
        </div>
        <div style="padding: 1.5rem;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-2">Anda berhasil login ke Medical Form System</h6>
                    <p class="text-muted mb-0">
                        <strong>User:</strong> <?= Html::encode(Yii::$app->user->identity->full_name ?? 'Dr. Admin') ?> |
                        <strong>Login:</strong> <?= date('d M Y, H:i') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Utama -->
    <div class="card-modern">
        <div style="background: linear-gradient(135deg, #3b82f6, #1e3a8a); color: white; padding: 1.5rem;">
            <h5 class="mb-0">
                <i class="fas fa-bolt"></i>
                Menu Utama
            </h5>
        </div>
        <div style="padding: 1.5rem;">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <?= Html::a('<i class="fas fa-list"></i> Data Registrasi', ['/registrasi/index'], ['class' => 'btn-modern btn-primary-modern w-100 justify-content-center']) ?>
                </div>
                <div class="col-md-6 mb-3">
                    <?= Html::a('<i class="fas fa-plus"></i> Tambah Registrasi', ['/registrasi/create'], ['class' => 'btn-modern btn-success-modern w-100 justify-content-center']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #f59e0b);
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .stats-icon.primary {
        background: linear-gradient(135deg, #3b82f6, #1e3a8a);
    }

    .stats-icon.success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .stats-icon.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .stats-icon.info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        display: block;
    }

    .stats-label {
        color: #6b7280;
        font-weight: 500;
    }
</style>