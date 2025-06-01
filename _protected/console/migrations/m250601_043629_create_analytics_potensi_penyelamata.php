<?php

use yii\db\Migration;

class m250601_043629_create_analytics_potensi_penyelamata extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('analytics_potensi_penyelamatan', [
            'id' => $this->primaryKey(),
            'tahun' => $this->integer(),
            'koefisiensi' => $this->decimal(10,2),
            'penghematan_rp' => $this->decimal(20,2),
            'jiwa' => $this->bigInteger(),
            'penghematan_triliun' => $this->decimal(20,2),
            'last_updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_updated_by' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250601_043629_create_analytics_potensi_penyelamata cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_043629_create_analytics_potensi_penyelamata cannot be reverted.\n";

        return false;
    }
    */
}
