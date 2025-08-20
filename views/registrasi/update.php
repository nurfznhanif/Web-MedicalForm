<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrasi */

$this->title = 'Edit Registrasi: ' . $model->nama_pasien;
$this->params['breadcrumbs'][] = ['label' => 'Data Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_pasien, 'url' => ['view', 'id' => $model->id_registrasi]];
$this->params['breadcrumbs'][] = 'Edit';

// SVG icons
$userIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" /></svg>';

$idIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M15 8l2 0" /><path d="M15 12l2 0" /><path d="M7 16l10 0" /></svg>';

$calendarIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>';

$medicalIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-medical-cross" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 3a1 1 0 0 1 1 1v4.535l3.928 -2.267a1 1 0 0 1 1.366 .366l1 1.732a1 1 0 0 1 -.366 1.366l-3.927 2.268l3.927 2.269a1 1 0 0 1 .366 1.366l-1 1.732a1 1 0 0 1 -1.366 .366l-3.928 -2.269v4.536a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-4.536l-3.928 2.268a1 1 0 0 1 -1.366 -.366l-1 -1.732a1 1 0 0 1 .366 -1.366l3.927 -2.268l-3.927 -2.268a1 1 0 0 1 -.366 -1.366l1 -1.732a1 1 0 0 1 1.366 -.366l3.928 2.267v-4.535a1 1 0 0 1 1 -1h2z" /></svg>';

$saveIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>';

$cancelIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>';

$timeIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>';

$lockIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 13v-4a4 4 0 1 1 8 0v4" /></svg>';
?>

<div class="registrasi-update">
    <div class="card modern-card">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title">
                <span class="header-icon"><?= $userIcon ?></span>
                <span>Edit Data Pasien: <?= Html::encode($model->nama_pasien) ?></span>
            </h3>
            <div class="system-brand">
                <span class="brand-icon"><?= $medicalIcon ?></span>
                <span>MEDICAL FORM SYSTEM</span>
            </div>
        </div>

        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'modern-form', 'novalidate' => true],
                'fieldConfig' => [
                    'options' => ['class' => 'form-field'],
                    'template' => "{label}\n<div class=\"input-wrapper\">{input}</div>\n{hint}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                    'hintOptions' => ['class' => 'form-hint']
                ],
            ]); ?>

            <div class="form-row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nama_pasien', [
                        'options' => ['class' => 'form-field with-icon'],
                        'template' => "{label}\n<div class=\"input-wrapper\">{$userIcon}{input}</div>\n{hint}\n{error}"
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Masukkan nama lengkap pasien',
                        'class' => 'form-control with-icon'
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'nik', [
                        'options' => ['class' => 'form-field with-icon'],
                        'template' => "{label}\n<div class=\"input-wrapper\">{$idIcon}{input}</div>\n{hint}\n{error}"
                    ])->textInput([
                        'type' => 'number',
                        'placeholder' => 'Masukkan NIK (16 digit)',
                        'maxlength' => 16,
                        'class' => 'form-control with-icon'
                    ]) ?>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <?= $form->field($model, 'tanggal_lahir', [
                        'options' => ['class' => 'form-field with-icon'],
                        'template' => "{label}\n<div class=\"input-wrapper\">{$calendarIcon}{input}</div>\n{hint}\n{error}"
                    ])->textInput([
                        'type' => 'date',
                        'class' => 'form-control with-icon'
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <div class="form-field with-icon">
                        <label class="form-label">No. Registrasi</label>
                        <div class="input-wrapper">
                            <?= $lockIcon ?>
                            <input type="text" class="form-control with-icon" value="<?= Html::encode($model->no_registrasi) ?>" readonly>
                        </div>
                        <div class="form-hint">Nomor registrasi tidak dapat diubah</div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-field with-icon">
                        <label class="form-label">No. Rekam Medis</label>
                        <div class="input-wrapper">
                            <?= $lockIcon ?>
                            <input type="text" class="form-control with-icon" value="<?= Html::encode($model->no_rekam_medis) ?>" readonly>
                        </div>
                        <div class="form-hint">Nomor rekam medis tidak dapat diubah</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-field with-icon">
                        <label class="form-label">Tanggal Dibuat</label>
                        <div class="input-wrapper">
                            <?= $timeIcon ?>
                            <input type="text" class="form-control with-icon" value="<?= Yii::$app->formatter->asDatetime($model->create_time_at) ?>" readonly>
                        </div>
                        <div class="form-hint">Tanggal pembuatan data</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?= Html::submitButton("{$saveIcon} Update Data", [
                    'class' => 'btn btn-success btn-lg btn-submit'
                ]) ?>
                <?= Html::a("{$cancelIcon} Kembali", ['index'], [
                    'class' => 'btn btn-outline-secondary btn-lg'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
// JavaScript untuk validasi dan interaksi
$this->registerJs("
$(document).ready(function() {
    // NIK validation
    $('#registrasi-nik').on('input', function() {
        var nik = $(this).val();
        var nikPattern = /^[0-9]{0,16}$/;
        
        if (nik.length > 0) {
            if (!nikPattern.test(nik)) {
                $(this).addClass('is-invalid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<div class=\"invalid-feedback\">NIK harus 16 digit angka</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
                if (nik.length === 16) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid');
                }
            }
        } else {
            $(this).removeClass('is-invalid is-valid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Auto uppercase nama
    $('#registrasi-nama_pasien').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    
    // Form submission animation
    $('.modern-form').on('submit', function(e) {
        $('.btn-submit').prop('disabled', true);
        $('.btn-submit').html('<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Memperbarui...');
    });
    
    // Input focus effects
    $('.form-control').focus(function() {
        $(this).parent().addClass('focused');
    }).blur(function() {
        $(this).parent().removeClass('focused');
    });
    
    // Initialize validation for existing values
    if ($('#registrasi-nik').val().length === 16) {
        $('#registrasi-nik').addClass('is-valid');
    }
});
");

// CSS untuk styling modern
$this->registerCss("
:root {
    --primary-dark: #1e3a8a;
    --primary: #3b82f6;
    --primary-light: #dbeafe;
    --accent: #f59e0b;
    --accent-light: #fef3c7;
    --gray-light: #f8fafc;
    --gray-border: #e2e8f0;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --radius: 8px;
    --transition: all 0.3s ease;
}

body {
    background-color: #f1f5f9;
    color: var(--text-primary);
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

.modern-card {
    box-shadow: var(--shadow-lg);
    border: none;
    border-radius: var(--radius);
    overflow: hidden;
    transition: var(--transition);
    margin: 2rem auto;
    max-width: 900px;
}

.modern-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.card-header.bg-gradient-primary {
    background: linear-gradient(120deg, var(--primary-dark), var(--primary)) !important;
    border-bottom: none;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.card-header .card-title {
    margin: 0;
    color: white;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.4rem;
}

.card-header .header-icon {
    display: inline-flex;
    color: white;
}

.system-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    font-weight: 500;
    font-size: 0.9rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 0.5rem 1rem;
    border-radius: 50px;
}

.brand-icon {
    display: inline-flex;
}

.card-body {
    padding: 2rem;
    background: white;
}

.modern-form {
    margin-top: 0.5rem;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -0.75rem;
}

.form-row > div {
    padding: 0 0.75rem;
    margin-bottom: 1.5rem;
    flex: 0 0 50%;
    max-width: 50%;
}

.form-field {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    display: block;
}

.input-wrapper {
    position: relative;
}

.form-control {
    border: 1px solid var(--gray-border);
    border-radius: var(--radius);
    padding: 0.75rem 1rem;
    transition: var(--transition);
    background: white;
    color: var(--text-primary);
    width: 100%;
    font-size: 1rem;
}

.form-control.with-icon {
    padding-left: 2.75rem;
}

.form-control:read-only {
    background-color: #f9fafb;
    color: var(--text-secondary);
}

.input-wrapper svg.icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    width: 1.25rem;
    height: 1.25rem;
    z-index: 2;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    outline: none;
}

.input-wrapper.focused svg.icon {
    color: var(--primary);
}

.form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e\");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-valid {
    border-color: #10b981;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e\");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.form-hint {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-top: 0.375rem;
}

.form-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gray-border);
}

.btn {
    border-radius: var(--radius);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-success {
    background: linear-gradient(to right, #0d9488, #10b981);
    box-shadow: 0 4px 6px rgba(5, 150, 105, 0.3);
}

.btn-success:hover {
    background: linear-gradient(to right, #0f766e, #059669);
    transform: translateY(-2px);
    box-shadow: 0 6px 8px rgba(5, 150, 105, 0.4);
}

.btn-outline-secondary {
    border: 1px solid var(--gray-border);
    color: var(--text-secondary);
    background: transparent;
}

.btn-outline-secondary:hover {
    background-color: var(--gray-light);
    color: var(--text-primary);
}

.text-danger {
    color: #dc3545 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header.bg-gradient-primary {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .form-row > div {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Animation for form elements */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.modern-form .form-field {
    animation: fadeIn 0.5s ease forwards;
}

.modern-form .form-field:nth-child(1) { animation-delay: 0.1s; }
.modern-form .form-field:nth-child(2) { animation-delay: 0.2s; }
.modern-form .form-field:nth-child(3) { animation-delay: 0.3s; }
.modern-form .form-field:nth-child(4) { animation-delay: 0.4s; }
.modern-form .form-field:nth-child(5) { animation-delay: 0.5s; }
.modern-form .form-field:nth-child(6) { animation-delay: 0.6s; }

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
");
?>