<?php

use yii\db\Migration;

/**
 * Class m221008_194217_alter_table_member_add_id_provinsi
 */
class m221008_194217_alter_table_member_add_id_provinsi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member', 'id_provinsi', $this->integer(11));
        $this->addForeignKey(
            'fk-member-id_provinsi',
            'member', 'id_provinsi',
            'provinsi', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221008_194217_alter_table_member_add_id_provinsi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221008_194217_alter_table_member_add_id_provinsi cannot be reverted.\n";

        return false;
    }
    */
}
