<?php

use yii\db\Migration;

/**
 * Class m220811_082308_alter_table_report_add_column_tahun_report
 */
class m220811_082308_alter_table_report_add_column_tahun_report extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report', 'tahun', $this->integer(4));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220811_082308_alter_table_report_add_column_tahun_report cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220811_082308_alter_table_report_add_column_tahun_report cannot be reverted.\n";

        return false;
    }
    */
}
