<?php

use yii\db\Migration;

/**
 * Class m220813_164906_alter_table_capaian_nilai_add_column_nko
 */
class m220813_164906_alter_table_capaian_nilai_add_column_nko extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('capaian_nilai', 'nko', $this->decimal(5,2));
        $this->renameTable('capaian_nilai', 'capaian_kinerja');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220813_164906_alter_table_capaian_nilai_add_column_nko cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220813_164906_alter_table_capaian_nilai_add_column_nko cannot be reverted.\n";

        return false;
    }
    */
}
