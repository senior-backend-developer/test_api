<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m240117_101124_create_links_table extends Migration
{
    protected $table = '{{%links}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'url' => $this->string()->null(),
            'user_id' => $this->bigInteger()->unsigned()->notNull(),
            'creation_datetime' => $this->string(),
        ]);
        $this->addForeignKey('fk_links_user_id', $this->table, 'user_id', '{{%users}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_links_user_id', $this->table);
        $this->dropTable('{{%links}}');
    }
}
