<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%capaian_iku}}`.
 */
class m220813_152415_create_capaian_iku_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('capaian_iku', [
            'id' => $this->primaryKey(11),
            'tahun' => $this->integer(4),
            'grey' => $this->decimal(5,2),
            'below' => $this->decimal(5,2),
            'meet' => $this->decimal(5,2),
            'exceed' => $this->decimal(5,2),
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by'=>$this->string(255),
            'status'=>$this->smallInteger(2)->defaultValue(1)->comment('-1=deleted,1=active,0=inactive'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%capaian_iku}}');
    }
}
