<?php
// file: migrations/mXXXXXX_XXXXXX_create_users_table.php

use yii\db\Migration;

/**
 * Class m240201_000001_create_users_table
 */
class m240201_000001_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'full_name' => $this->string(100)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Insert default user
        $this->insert('users', [
            'username' => 'admin',
            'password' => 'admin123',
            'full_name' => 'Administrator',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
