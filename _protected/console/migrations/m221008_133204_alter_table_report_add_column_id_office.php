<?php

use yii\db\Migration;

/**
 * Class m221008_133204_alter_table_report_add_column_id_office
 */
class m221008_133204_alter_table_report_add_column_id_office extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report', 'id_office', $this->integer(11));
        $this->addForeignKey(
            'fk-report-id_office',
            'report', 'id_office',
            'office', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221008_133204_alter_table_report_add_column_id_office cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221008_133204_alter_table_report_add_column_id_office cannot be reverted.\n";

        return false;
    }
    */
}
