<?php

use yii\db\Migration;

/**
 * Class m220817_062431_alter_table_provinsi_add_column_update_ddokumen_date
 */
class m220817_062431_alter_table_provinsi_add_column_update_ddokumen_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('provinsi', 'dokumen_update_date', $this->date());
        $this->addColumn('provinsi', 'dokumen_kerawanan', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220817_062431_alter_table_provinsi_add_column_update_ddokumen_date cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220817_062431_alter_table_provinsi_add_column_update_ddokumen_date cannot be reverted.\n";

        return false;
    }
    */
}
