<?php

use yii\db\Migration;

/**
 * Class m220815_145650_add_column_report_bimtek_tab
 */
class m220815_145650_add_column_report_bimtek_tab extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bimtek', 'report', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220815_145650_add_column_report_bimtek_tab cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220815_145650_add_column_report_bimtek_tab cannot be reverted.\n";

        return false;
    }
    */
}
