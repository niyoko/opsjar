<?php

use yii\db\Migration;

/**
 * Class m221002_053450_alter_table_anggota_add_column_id_office
 */
class m221002_053450_alter_table_anggota_add_column_id_office extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member', 'id_office', $this->integer(11));
        $this->addForeignKey(
            'fk-member-id_office',
            'member', 'id_office',
            'office', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221002_053450_alter_table_anggota_add_column_id_office cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221002_053450_alter_table_anggota_add_column_id_office cannot be reverted.\n";

        return false;
    }
    */
}
