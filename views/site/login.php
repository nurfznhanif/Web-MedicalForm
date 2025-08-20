<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Medical Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 50px;
        }

        .login-box {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .demo-accounts {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .demo-accounts h4 {
            margin: 0 0 10px 0;
            color: #495057;
        }

        .demo-account {
            margin: 5px 0;
            font-size: 14px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2 class="login-title">Medical Form System</h2>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'login-form'],
            'fieldConfig' => [
                'template' => "<div class='form-group'>{label}{input}{error}</div>",
                'labelOptions' => [],
                'inputOptions' => ['class' => ''],
                'errorOptions' => ['class' => 'error'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Masukkan username']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Masukkan password']) ?>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="demo-accounts">
            <h4>Demo Accounts:</h4>
            <div class="demo-account"><strong>admin</strong> / admin123</div>
        </div>
    </div>

</body>

</html>