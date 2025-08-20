<?php

use yii\helpers\Html;

$this->title = 'Dashboard';
?>

<div class="site-index">
    <div style="padding: 20px; background: #f8f9fa; border-radius: 10px; margin-bottom: 20px;">
        <h1>Selamat Datang!</h1>
        <p>Anda berhasil login ke Medical Form System</p>
        <p><strong>User:</strong> <?= Html::encode(Yii::$app->user->identity->full_name) ?></p>

        <?= Html::beginForm(['/site/logout'], 'post', ['style' => 'display:inline']) ?>
        <?= Html::submitButton('Logout', [
            'class' => 'btn btn-danger',
            'style' => 'padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;'
        ]) ?>
        <?= Html::endForm() ?>
    </div>

    <div style="padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2>Menu Utama</h2>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <?= Html::a('Data Registrasi', ['/registrasi/index'], [
                'style' => 'display: inline-block; padding: 15px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'
            ]) ?>

            <?= Html::a('Tambah Registrasi', ['/registrasi/create'], [
                'style' => 'display: inline-block; padding: 15px 25px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'
            ]) ?>
        </div>
    </div>
</div>