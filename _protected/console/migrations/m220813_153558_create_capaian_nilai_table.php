<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%capaian_nilai}}`.
 */
class m220813_153558_create_capaian_nilai_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('capaian_nilai', [
            'id' => $this->primaryKey(11),
            'stakeholders_value' => $this->decimal(10,3),
            'stakeholders_percentage' => $this->decimal(5,3),
            'internal_business_process_value' => $this->decimal(10,3),
            'internal_business_process_percentage' => $this->decimal(5,3),
            'learning_growth_value' => $this->decimal(10,3),
            'learning_growth_percentage' => $this->decimal(5,3),
            'tahun' => $this->integer(4),
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by'=>$this->string(255),
            'status'=>$this->smallInteger(2)->defaultValue(1)->comment('-1=deleted,1=active,0=inactive'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%capaian_nilai}}');
    }
}
