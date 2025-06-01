<?php

use yii\db\Migration;

class m250601_053333_create_table_analytics_perlintasan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('analytics_moda', [
            'id' => $this->primaryKey(),
            'perlintasan' => $this->string()->notNull()->comment('darat, laut, udara, ekspedisi'),
            'tahun' => $this->integer()->notNull(),
            'kasus' => $this->integer()->notNull(),
            'berat' => $this->decimal(20,2)->notNull(),
            'last_updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_updated_by' => $this->integer(11),
        ]);



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250601_053333_create_table_analytics_perlintasan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_053333_create_table_analytics_perlintasan cannot be reverted.\n";

        return false;
    }
    */
}
