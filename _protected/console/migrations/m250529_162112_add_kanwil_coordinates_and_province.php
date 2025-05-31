<?php

use yii\db\Migration;

/**
 * Class m250529_162112_add_kanwil_coordinates_and_province
 */
class m250529_162112_add_kanwil_coordinates_and_province extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('office', 'coordinate', $this->text());
        $this->addColumn('provinsi', 'office_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250529_162112_add_kanwil_coordinates_and_province cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250529_162112_add_kanwil_coordinates_and_province cannot be reverted.\n";

        return false;
    }
    */
}
