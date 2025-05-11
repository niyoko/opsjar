<?php

use yii\db\Migration;

/**
 * Class m220829_175209_alter_table_report_add_column_nomor_surat
 */
class m220829_175209_alter_table_report_add_column_nomor_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report', 'nomor_surat', $this->string(50));
        $this->addColumn('report', 'laporan', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220829_175209_alter_table_report_add_column_nomor_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220829_175209_alter_table_report_add_column_nomor_surat cannot be reverted.\n";

        return false;
    }
    */
}
