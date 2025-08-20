<?php
// file: migrations/mXXXXXX_XXXXXX_insert_test_data.php

use yii\db\Migration;

/**
 * Class m240201_000004_insert_test_data
 */
class m240201_000004_insert_test_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Cek data users
        echo "USERS TABLE:\n";
        $users = Yii::$app->db->createCommand('SELECT * FROM users')->queryAll();
        print_r($users);

        // Cek data registrasi
        echo "\nREGISTRASI TABLE:\n";
        $registrasi = Yii::$app->db->createCommand('SELECT * FROM registrasi')->queryAll();
        print_r($registrasi);

        // Cek data form
        echo "\nDATA_FORM TABLE:\n";
        $dataForm = Yii::$app->db->createCommand('SELECT * FROM data_form')->queryAll();
        print_r($dataForm);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240201_000004_insert_test_data cannot be reverted.\n";
        return false;
    }
}
