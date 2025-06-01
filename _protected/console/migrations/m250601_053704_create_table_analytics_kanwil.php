<?php

use yii\db\Migration;

class m250601_053704_create_table_analytics_kanwil extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%analytics_kanwil}}', [
            'id' => $this->primaryKey(),
            'id_office' => $this->integer()->notNull(),
            'kasus' => $this->decimal(20,2)->notNull(),
            'berat' => $this->decimal(20,2)->notNull(),
            'tahun' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-analytics_kanwil-id_office',
            '{{%analytics_kanwil}}', 'id_office',
            '{{%office}}', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250601_053704_create_table_analytics_kanwil cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_053704_create_table_analytics_kanwil cannot be reverted.\n";

        return false;
    }
    */
}
