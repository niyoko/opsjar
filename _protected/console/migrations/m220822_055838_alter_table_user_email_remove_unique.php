<?php

use yii\db\Migration;

/**
 * Class m220822_055838_alter_table_user_email_remove_unique
 */
class m220822_055838_alter_table_user_email_remove_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex( 'email', 'user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220822_055838_alter_table_user_email_remove_unique cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220822_055838_alter_table_user_email_remove_unique cannot be reverted.\n";

        return false;
    }
    */
}
