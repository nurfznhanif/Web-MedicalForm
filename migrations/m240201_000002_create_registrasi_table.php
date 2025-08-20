<?php
// file: migrations/mXXXXXX_XXXXXX_create_registrasi_table.php

use yii\db\Migration;

/**
 * Class m240201_000002_create_registrasi_table
 */
class m240201_000002_create_registrasi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('registrasi', [
            'id_registrasi' => $this->primaryKey(),
            'no_registrasi' => $this->string(64)->unique(),
            'no_rekam_medis' => $this->string(64),
            'nama_pasien' => $this->string(255)->notNull(),
            'tanggal_lahir' => $this->date(),
            'nik' => $this->string(64),
            'create_by' => $this->integer(),
            'create_time_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_by' => $this->integer(),
            'update_time_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Insert sample data
        $this->batchInsert('registrasi', [
            'no_registrasi',
            'no_rekam_medis',
            'nama_pasien',
            'tanggal_lahir',
            'nik'
        ], [
            ['REG20241201001', 'RM24001', 'NURFAUZAN HANIF', '2003-07-19', '1234567890123456'],
            ['REG20241201002', 'RM24002', 'BUDI SANTOSO', '1985-08-22', '2345678901234567'],
            ['REG20241201003', 'RM24003', 'DEWI SARTIKA', '1992-12-10', '3456789012345678'],
        ]);

        // Create indexes
        $this->createIndex('idx_registrasi_no_registrasi', 'registrasi', 'no_registrasi');
        $this->createIndex('idx_registrasi_no_rekam_medis', 'registrasi', 'no_rekam_medis');
        $this->createIndex('idx_registrasi_nik', 'registrasi', 'nik');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('registrasi');
    }
}
