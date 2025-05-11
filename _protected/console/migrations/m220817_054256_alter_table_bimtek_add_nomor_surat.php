<?php

use yii\db\Migration;

/**
 * Class m220817_054256_alter_table_bimtek_add_nomor_surat
 */
class m220817_054256_alter_table_bimtek_add_nomor_surat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bimtek', 'nomor_surat', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220817_054256_alter_table_bimtek_add_nomor_surat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220817_054256_alter_table_bimtek_add_nomor_surat cannot be reverted.\n";

        return false;
    }
    */
}
