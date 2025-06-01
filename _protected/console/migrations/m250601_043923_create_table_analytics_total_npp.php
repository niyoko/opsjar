<?php

use yii\db\Migration;

class m250601_043923_create_table_analytics_total_npp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('analytics_total_npp', [
            'id' => $this->primaryKey(),
            'tahun' => $this->integer(),
            'kasus' => $this->integer(),
            'berat_gr' => $this->decimal(20,2),
            'berat_kg' => $this->decimal(20,2),
            'last_updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_updated_by' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250601_043923_create_table_analytics_total_npp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_043923_create_table_analytics_total_npp cannot be reverted.\n";

        return false;
    }
    */
}
