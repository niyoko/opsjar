<?php

use yii\db\Migration;

/**
 * Class m221002_022155_alter_table_office_add_column_shortname
 */
class m221002_022155_alter_table_office_add_column_shortname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('office', 'shortname', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221002_022155_alter_table_office_add_column_shortname cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221002_022155_alter_table_office_add_column_shortname cannot be reverted.\n";

        return false;
    }
    */
}
