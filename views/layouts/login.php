<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login - Medical Form System';
$this->params['breadcrumbs'][] = 'Login';

// Register CSS
$this->registerCss("
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.login-container {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.login-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 30px;
    text-align: center;
    position: relative;
}

.login-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 100\" fill=\"%23ffffff\" opacity=\"0.1\"><polygon points=\"1000,100 1000,0 0,100\"/></svg>');
    background-size: cover;
}

.login-header h1 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

.login-header p {
    margin: 10px 0 0 0;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.login-body {
    padding: 40px;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating > .form-control {
    height: calc(3.5rem + 2px);
    line-height: 1.25;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.form-floating > .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    transform: translateY(-2px);
}

.form-floating > label {
    color: #6c757d;
    font-weight: 500;
}

.btn-login {
    width: 100%;
    height: 50px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
}

.btn-login:active {
    transform: translateY(0);
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-login:hover::before {
    left: 100%;
}

.remember-me {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}

.form-check {
    display: flex;
    align-items: center;
}

.form-check-input {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    border: 2px solid #007bff;
    border-radius: 4px;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-check-label {
    color: #495057;
    font-weight: 500;
    cursor: pointer;
}

.demo-accounts {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-top: 30px;
    border: 1px solid #e9ecef;
}

.demo-accounts h6 {
    color: #495057;
    margin-bottom: 15px;
    font-weight: 600;
}

.demo-account {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 12px;
    background: white;
    border-radius: 8px;
    margin-bottom: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.demo-account:hover {
    border-color: #007bff;
    transform: translateX(5px);
}

.demo-account:last-child {
    margin-bottom: 0;
}

.demo-account strong {
    color: #007bff;
}

.demo-account small {
    color: #6c757d;
}

.system-info {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
}

.system-info h5 {
    color: #007bff;
    font-weight: 600;
    margin-bottom: 5px;
}

.system-info p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.loading {
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .login-container {
        margin: 20px;
        border-radius: 15px;
    }
    
    .login-header, .login-body {
        padding: 20px;
    }
    
    .login-header h1 {
        font-size: 1.5rem;
    }
}
");

// Register JS
$this->registerJs("
$(document).ready(function() {
    // Auto-fill demo account
    $('.demo-account').click(function() {
        var username = $(this).data('username');
        var password = $(this).data('password');
        
        $('#loginform-username').val(username);
        $('#loginform-password').val(password);
        
        // Add visual feedback
        $('.demo-account').removeClass('border-primary');
        $(this).addClass('border-primary');
    });
    
    // Form validation
    $('#login-form').on('beforeSubmit', function() {
        var btn = $('.btn-login');
        btn.addClass('loading');
        btn.prop('disabled', true);
        btn.text('Logging in...');
        
        return true;
    });
    
    // Auto focus first empty field
    if ($('#loginform-username').val() === '') {
        $('#loginform-username').focus();
    } else {
        $('#loginform-password').focus();
    }
});
");
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="login-container">
                <!-- Header -->
                <div class="login-header">
                    <h1><i class="fas fa-user-md"></i> Medical Form System</h1>
                    <p>PT BIGS Integrasi Teknologi</p>
                </div>

                <!-- Body -->
                <div class="login-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{input}\n{error}",
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback d-block'],
                        ],
                        'options' => ['autocomplete' => 'off']
                    ]); ?>

                    <!-- Username Field -->
                    <div class="form-floating">
                        <?= $form->field($model, 'username')->textInput([
                            'id' => 'loginform-username',
                            'placeholder' => 'Username',
                            'autofocus' => true,
                            'autocomplete' => 'username'
                        ]) ?>
                        <label for="loginform-username"><i class="fas fa-user"></i> Username</label>
                    </div>

                    <!-- Password Field -->
                    <div class="form-floating">
                        <?= $form->field($model, 'password')->passwordInput([
                            'id' => 'loginform-password',
                            'placeholder' => 'Password',
                            'autocomplete' => 'current-password'
                        ]) ?>
                        <label for="loginform-password"><i class="fas fa-lock"></i> Password</label>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="remember-me">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                            'labelOptions' => ['class' => 'form-check-label'],
                            'uncheck' => null,
                        ]) ?>
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid">
                        <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Login', [
                            'class' => 'btn btn-primary btn-login',
                            'name' => 'login-button'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <!-- Demo Accounts -->
                    <div class="demo-accounts">
                        <h6><i class="fas fa-users"></i> Demo Accounts:</h6>

                        <div class="demo-account" data-username="admin" data-password="admin123">
                            <div>
                                <strong>admin</strong><br>
                                <small>Administrator</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">admin123</small><br>
                                <span class="badge bg-danger">Admin</span>
                            </div>
                        </div>

                        <div class="demo-account" data-username="perawat" data-password="perawat123">
                            <div>
                                <strong>perawat</strong><br>
                                <small>Perawat Utama</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">perawat123</small><br>
                                <span class="badge bg-success">Perawat</span>
                            </div>
                        </div>

                        <div class="demo-account" data-username="dokter" data-password="dokter123">
                            <div>
                                <strong>dokter</strong><br>
                                <small>Dokter Utama</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">dokter123</small><br>
                                <span class="badge bg-info">Dokter</span>
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Klik pada akun demo untuk mengisi otomatis
                        </small>
                    </div>

                    <!-- System Info -->
                    <div class="system-info">
                        <h5><i class="fas fa-hospital"></i> Medical Form System</h5>
                        <p>Sistem Pengkajian Keperawatan Digital</p>
                        <p class="text-muted">Version 1.0 &copy; <?= date('Y') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>