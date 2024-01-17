<?php

use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240117_082346_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'username' => $this->string(32),
            'email' => $this->string(32)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
