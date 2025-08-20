<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Medical Form System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #f59e0b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #3b82f6, #1e3a8a);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .brand-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: #f59e0b;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .brand-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .login-form {
            padding: 2.5rem 2rem;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 2rem;
        }

        .welcome-title {
            color: #1f2937;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #1f2937;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            color: #1f2937;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1.1rem;
        }

        .form-input:focus+.input-icon {
            color: #3b82f6;
        }

        .login-button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #3b82f6, #1e3a8a);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
        }

        .demo-section {
            background: linear-gradient(135deg, #dbeafe, rgba(59, 130, 246, 0.1));
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .demo-title {
            color: #1e3a8a;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .demo-account {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .demo-account:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid #3b82f6;
        }

        .demo-credentials {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .demo-username {
            font-weight: 600;
            color: #1f2937;
        }

        .demo-password {
            font-family: monospace;
            background: #f8fafc;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .login-footer {
            background: #f8fafc;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            color: #6b7280;
            font-size: 0.85rem;
        }

        .footer-version {
            color: #3b82f6;
            font-weight: 600;
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 1rem;
                border-radius: 12px;
            }

            .login-header {
                padding: 2rem 1.5rem;
            }

            .login-form {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="brand-icon">
                <i class="fas fa-notes-medical"></i>
            </div>
            <h1 class="brand-title">Medical Form System</h1>
            <p class="brand-subtitle">Sistem Manajemen Form Medis Terintegrasi</p>
        </div>

        <div class="login-form">
            <div class="welcome-text">
                <h2 class="welcome-title">Selamat Datang</h2>
                <p class="welcome-subtitle">Silakan login untuk mengakses sistem</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => '<div class="form-group">{label}<div class="input-wrapper">{input}<i class="fas fa-user input-icon"></i></div>{error}</div>',
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-input'],
                ],
            ]); ?>

            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrapper">
                    <?= Html::activeTextInput($model, 'username', ['class' => 'form-input', 'placeholder' => 'Masukkan username']) ?>
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <?= Html::activePasswordInput($model, 'password', ['class' => 'form-input', 'placeholder' => 'Masukkan password']) ?>
                    <i class="fas fa-lock input-icon"></i>
                </div>
            </div>

            <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Masuk', ['class' => 'login-button']) ?>

            <?php ActiveForm::end(); ?>

            <div class="demo-section">
                <div class="demo-title">
                    <i class="fas fa-key"></i>
                    Akun Demo
                </div>
                <div class="demo-account" onclick="fillDemo('admin', 'admin123')">
                    <div class="demo-credentials">
                        <span class="demo-username">
                            <i class="fas fa-user-shield"></i>
                            Admin
                        </span>
                        <span class="demo-password">admin123</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <div class="footer-text">
                &copy; 2024 Medical Form System. All rights reserved.
            </div>
            <div class="footer-version">
                Version 2.0 - Modern Edition
            </div>
        </div>
    </div>

    <script>
        function fillDemo(username, password) {
            document.querySelector('input[name="LoginForm[username]"]').value = username;
            document.querySelector('input[name="LoginForm[password]"]').value = password;
        }
    </script>
</body>

</html>