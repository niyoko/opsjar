<?php

use yii\db\Migration;

/**
 * Class m220830_140409_rename_column_stakeholders
 */
class m220830_140409_rename_column_stakeholders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('capaian_kinerja', 'stakekholders_value', 'stakeholders_value');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220830_140409_rename_column_stakeholders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220830_140409_rename_column_stakeholders cannot be reverted.\n";

        return false;
    }
    */
}
