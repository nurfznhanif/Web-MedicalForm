<?php
// file: migrations/mXXXXXX_XXXXXX_create_data_form_table.php

use yii\db\Migration;

/**
 * Class m240201_000003_create_data_form_table
 */
class m240201_000003_create_data_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('data_form', [
            'id_form_data' => $this->primaryKey(),
            'id_form' => $this->integer(),
            'id_registrasi' => $this->integer(),
            'data' => $this->json(),
            'is_delete' => $this->boolean()->defaultValue(false),
            'create_by' => $this->integer(),
            'update_by' => $this->integer(),
            'create_time_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key
        $this->addForeignKey(
            'fk_data_form_registrasi',
            'data_form',
            'id_registrasi',
            'registrasi',
            'id_registrasi',
            'CASCADE',
            'CASCADE'
        );

        // Create indexes
        $this->createIndex('idx_data_form_id_registrasi', 'data_form', 'id_registrasi');
        $this->createIndex('idx_data_form_create_time', 'data_form', 'create_time_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_data_form_registrasi', 'data_form');
        $this->dropTable('data_form');
    }
}
