<?php

use yii\db\Migration;

/**
 * Class m250529_174142_add_province_background_color
 */
class m250529_174142_add_province_background_color extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('provinsi', 'background_color', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250529_174142_add_province_background_color cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250529_174142_add_province_background_color cannot be reverted.\n";

        return false;
    }
    */
}
