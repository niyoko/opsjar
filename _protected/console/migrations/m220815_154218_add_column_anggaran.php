<?php

use yii\db\Migration;

/**
 * Class m220815_154218_add_column_anggaran
 */
class m220815_154218_add_column_anggaran extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   
        $this->addColumn('anggaran', 'tahun', $this->integer(4));
        $this->addColumn('anggaran', 'budget', $this->decimal(20,2));
        $this->addColumn('anggaran', 'realisasi', $this->decimal(20,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220815_154218_add_column_anggaran cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220815_154218_add_column_anggaran cannot be reverted.\n";

        return false;
    }
    */
}
