<?php

use yii\db\Migration;

/**
 * Class m220811_082117_add_foreign_key_report
 */
class m220811_082117_add_foreign_key_report extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-report-id_provinsi',
            'report', 'id_provinsi',
            'provinsi', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220811_082117_add_foreign_key_report cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220811_082117_add_foreign_key_report cannot be reverted.\n";

        return false;
    }
    */
}
