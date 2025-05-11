<?php

use yii\db\Migration;

/**
 * Class m220815_160915_add_column_budget_and_realisasi
 */
class m220815_160915_add_column_budget_and_realisasi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('anggaran_detail', 'budget', $this->decimal(20,2));
        $this->addColumn('anggaran_detail', 'realisasi', $this->decimal(20,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220815_160915_add_column_budget_and_realisasi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220815_160915_add_column_budget_and_realisasi cannot be reverted.\n";

        return false;
    }
    */
}
