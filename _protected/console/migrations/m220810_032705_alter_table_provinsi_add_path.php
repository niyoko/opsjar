<?php

use yii\db\Migration;

/**
 * Class m220810_032705_alter_table_provinsi_add_path
 */
class m220810_032705_alter_table_provinsi_add_path extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('provinsi','path', $this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220810_032705_alter_table_provinsi_add_path cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220810_032705_alter_table_provinsi_add_path cannot be reverted.\n";

        return false;
    }
    */
}
