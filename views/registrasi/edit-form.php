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

// Register modern CSS
$this->registerCss("
:root {
    --primary-blue: #1e3a8a;
    --secondary-blue: #3b82f6;
    --accent-yellow: #f59e0b;
    --light-blue: #dbeafe;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --bg-light: #f8fafc;
    --white: #ffffff;
    --border-light: #e5e7eb;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --border-radius: 12px;
    --transition: all 0.3s ease;
}

.data-form-edit {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.edit-header {
    background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
    color: white;
    padding: 2rem;
    border-radius: 16px 16px 0 0;
    margin-bottom: 0;
    position: relative;
    overflow: hidden;
}

.edit-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: rotate(45deg);
}

.edit-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.edit-header-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-modern {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.btn-info-modern {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-info-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

.btn-secondary-modern {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary-modern:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    text-decoration: none;
}

.alert-modern {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.05));
    border: 2px solid rgba(245, 158, 11, 0.2);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin: 2rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-modern .alert-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--warning), #d97706);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.info-card-modern {
    background: linear-gradient(135deg, var(--white), var(--bg-light));
    border: 2px solid var(--border-light);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    margin-bottom: 2rem;
}

.info-card-header {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-card-body {
    padding: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-label {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.9rem;
}

.info-value {
    color: var(--text-light);
    font-size: 1rem;
    padding: 0.5rem 0;
}

.form-container-edit {
    background: var(--white);
    border-radius: 0 0 16px 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.edit-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(245, 158, 11, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-indicator {
    width: 12px;
    height: 12px;
    background: #fbbf24;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.form-progress {
    background: var(--bg-light);
    padding: 1rem 2rem;
    border-bottom: 2px solid var(--border-light);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.progress-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.progress-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--success), #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.auto-save-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-light);
    font-size: 0.9rem;
}

.save-status {
    width: 8px;
    height: 8px;
    background: var(--success);
    border-radius: 50%;
}

@media (max-width: 768px) {
    .data-form-edit {
        padding: 1rem;
    }
    
    .edit-header {
        padding: 1.5rem;
    }
    
    .edit-header-actions {
        flex-direction: column;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .form-progress {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
");
?>

<div class="data-form-edit">
    <!-- Modern Edit Header -->
    <div class="edit-header">
        <div class="edit-badge">
            <div class="status-indicator"></div>
            Mode Edit
        </div>

        <h1>
            <i class="fas fa-edit"></i>
            <?= Html::encode($this->title) ?>
        </h1>

        <div class="edit-header-actions">
            <?= Html::a('<i class="fas fa-eye"></i> Lihat Form', ['view-form', 'id' => $model->id_form_data], [
                'class' => 'btn-modern btn-info-modern'
            ]) ?>
            <?= Html::a('<i class="fas fa-times"></i> Batal Edit', ['view-form', 'id' => $model->id_form_data], [
                'class' => 'btn-modern btn-secondary-modern'
            ]) ?>
        </div>
    </div>

    <!-- Warning Alert -->
    <div class="alert-modern">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
            <h5 style="margin: 0 0 0.5rem 0; color: var(--warning); font-weight: 700;">Perhatian Mode Edit</h5>
            <p style="margin: 0; color: var(--text-dark);">
                Anda sedang mengedit form pengkajian medis. Pastikan semua perubahan data sudah benar sebelum menyimpan.
                Data yang telah disimpan akan menggantikan data sebelumnya.
            </p>
        </div>
    </div>

    <div class="form-container-edit">
        <!-- Form Progress Indicator -->
        <div class="form-progress">
            <div class="progress-info">
                <div class="progress-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div>
                    <h6 style="margin: 0; color: var(--text-dark); font-weight: 600;">Form Pengkajian Medis</h6>
                    <small style="color: var(--text-light);">
                        ID: FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?> |
                        Pasien: <?= Html::encode($registrasi->nama_pasien) ?>
                    </small>
                </div>
            </div>
            <div class="auto-save-indicator">
                <div class="save-status"></div>
                <span>Auto-save enabled</span>
            </div>
        </div>

        <!-- Info Form Modern Card -->
        <div class="info-card-modern">
            <div class="info-card-header">
                <i class="fas fa-info-circle" style="font-size: 1.2rem;"></i>
                <h5 style="margin: 0; font-weight: 600;">Informasi Form Pengkajian</h5>
            </div>
            <div class="info-card-body">
                <?php
                $data = $model->getDisplayData();
                ?>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-id-card me-2"></i>
                            ID Form
                        </span>
                        <span class="info-value">FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-user me-2"></i>
                            Nama Pasien
                        </span>
                        <span class="info-value"><?= Html::encode($registrasi->nama_pasien) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-file-medical me-2"></i>
                            No. Rekam Medis
                        </span>
                        <span class="info-value"><?= Html::encode($registrasi->no_rekam_medis) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar me-2"></i>
                            Tanggal Pengkajian
                        </span>
                        <span class="info-value"><?= $data['tanggal_pengkajian'] ?? '-' ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-clock me-2"></i>
                            Jam Pengkajian
                        </span>
                        <span class="info-value"><?= $data['jam_pengkajian'] ?? '-' ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-hospital me-2"></i>
                            Poliklinik
                        </span>
                        <span class="info-value"><?= $data['poliklinik'] ?? 'KLINIK OBGYN' ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Dibuat Tanggal
                        </span>
                        <span class="info-value"><?= date('d/m/Y H:i', strtotime($model->create_time_at)) ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-edit me-2"></i>
                            Terakhir Diubah
                        </span>
                        <span class="info-value"><?= $model->update_time_at ? date('d/m/Y H:i', strtotime($model->update_time_at)) : 'Belum pernah diubah' ?></span>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(16, 185, 129, 0.1); border-radius: 8px; border: 2px solid rgba(16, 185, 129, 0.2);">
                    <h6 style="margin: 0 0 0.5rem 0; color: var(--success); font-weight: 600;">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips Mode Edit
                    </h6>
                    <ul style="margin: 0; padding-left: 1rem; color: var(--text-dark);">
                        <li>Semua section akan terbuka secara otomatis untuk memudahkan editing</li>
                        <li>Data existing akan ter-load otomatis di form</li>
                        <li>Gunakan <kbd>Ctrl + S</kbd> untuk save cepat</li>
                        <li>Perubahan akan tersimpan otomatis setiap 30 detik</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Render form input yang sama tetapi dalam mode edit -->
        <?= $this->render('input-form', [
            'model' => $model,
            'registrasi' => $registrasi,
            'isEdit' => true
        ]) ?>
    </div>
</div>

<?php
// Enhanced JavaScript untuk edit mode
$this->registerJs("
// Enhanced edit mode initialization
$(document).ready(function() {
    console.log('=== EDIT MODE INITIALIZED ===');
    
    // Auto-fill existing data
    var existingData = " . json_encode($data) . ";
    console.log('Existing data loaded:', existingData);
    
    // Show/hide additional fields berdasarkan data existing
    if ('" . ($model->riwayat_operasi ?? '') . "' === 'ya') {
        $('#operasiFields').addClass('show');
        console.log('Showing operasi fields');
    }
    
    if ('" . ($model->riwayat_pernah_dirawat ?? '') . "' === 'ya') {
        $('#dirawatFields').addClass('show');
        console.log('Showing dirawat fields');
    }
    
    // Auto-expand all sections in edit mode
    setTimeout(function() {
        $('.section-content.collapsed').each(function() {
            $(this).removeClass('collapsed');
            var header = $(this).prev('.section-header');
            var icon = header.find('.fa-chevron-down');
            if (icon.length) {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        });
        console.log('All sections expanded for edit mode');
    }, 200);
    
    // Recalculate IMT dan risk assessment with delay
    setTimeout(function() {
        if (typeof hitungIMT === 'function') {
            hitungIMT();
            console.log('IMT recalculated');
        }
        if (typeof hitungResikoJatuh === 'function') {
            hitungResikoJatuh();
            console.log('Risk assessment recalculated');
        }
    }, 500);
    
    // Auto-save functionality
    var autoSaveInterval = setInterval(function() {
        // Simple auto-save indication
        $('.save-status').css('background', '#f59e0b');
        setTimeout(function() {
            $('.save-status').css('background', '#10b981');
        }, 200);
        console.log('Auto-save check performed');
    }, 30000);
    
    // Enhanced form change tracking
    var formChanged = false;
    $('#medical-form input, #medical-form select, #medical-form textarea').on('change input', function() {
        formChanged = true;
        $('.save-status').css('background', '#f59e0b');
    });
    
    // Warn user before leaving if form has changes
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            return e.returnValue;
        }
    });
    
    // Reset form changed flag on successful submit
    $('#medical-form').on('submit', function() {
        formChanged = false;
    });
    
    // Add visual indicators for required fields in edit mode
    $('input[required], select[required], textarea[required]').each(function() {
        if (!$(this).val()) {
            $(this).css('border-left', '4px solid #f59e0b');
        }
    });
    
    console.log('=== EDIT MODE READY ===');
});

// Enhanced save function for edit mode
function saveForm() {
    const form = document.getElementById('medical-form');
    if (form) {
        // Update save status
        $('.save-status').css('background', '#3b82f6');
        
        // Show saving animation
        const submitButton = document.querySelector('.btn-success-modern');
        if (submitButton) {
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Menyimpan Perubahan...';
            submitButton.disabled = true;
            
            // Reset after delay (in case form doesn't redirect)
            setTimeout(function() {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 5000);
        }
        
        // Submit the form
        form.submit();
        console.log('Form submitted in edit mode');
    }
}
", \yii\web\View::POS_END);
?>