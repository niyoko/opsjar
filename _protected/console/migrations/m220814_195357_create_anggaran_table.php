<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anggaran}}`.
 */
class m220814_195357_create_anggaran_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%anggaran}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%anggaran}}');
    }
}
