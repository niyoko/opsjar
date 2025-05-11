<?php

use yii\db\Migration;

/**
 * Class m220809_090817_alter_table_user_add_role
 */
class m220809_090817_alter_table_user_add_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->smallInteger(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220809_090817_alter_table_user_add_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220809_090817_alter_table_user_add_role cannot be reverted.\n";

        return false;
    }
    */
}
