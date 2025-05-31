<?php

use yii\db\Migration;

/**
 * Class m250530_132153_add_office_parent
 */
class m250530_132153_add_office_parent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('office', 'parent_id', $this->integer());
        $this->alterColumn('provinsi', 'office_id', $this->string(200));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250530_132153_add_office_parent cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250530_132153_add_office_parent cannot be reverted.\n";

        return false;
    }
    */
}
