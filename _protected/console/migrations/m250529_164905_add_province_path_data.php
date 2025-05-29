<?php

use yii\db\Migration;

/**
 * Class m250529_164905_add_province_path_data
 */
class m250529_164905_add_province_path_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('provinsi', 'path_data', 'LONGTEXT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250529_164905_add_province_path_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250529_164905_add_province_path_data cannot be reverted.\n";

        return false;
    }
    */
}
