<?php

use yii\db\Migration;

/**
 * Class m220815_154548_add_column_type
 */
class m220815_154548_add_column_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('anggaran', 'type' , $this->smallInteger(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220815_154548_add_column_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220815_154548_add_column_type cannot be reverted.\n";

        return false;
    }
    */
}
