<?php

use yii\db\Migration;

class m250601_054042_create_table_analytics_jenis_npp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%analytics_jenis_npp}}', [
            'id' => $this->primaryKey(),
            'id_jenis_narkotika' => $this->integer()->notNull(),
            'tahun' => $this->integer()->notNull(),
            'kasus' => $this->integer()->notNull(),
            'berat' => $this->decimal(15,2)->notNull(),
            'last_updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_updated_by' => $this->integer(11),
        ]);

        $this->addForeignKey(
            'fk-analytics_jenis_npp-id_jenis_narkotika',
            '{{%analytics_jenis_npp}}', 'id_jenis_narkotika',
            '{{%jenis_narkotika}}', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250601_054042_create_table_analytics_jenis_npp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_054042_create_table_analytics_jenis_npp cannot be reverted.\n";

        return false;
    }
    */
}
