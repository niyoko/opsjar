<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%data}}`.
 */
class m220811_080906_create_data_table extends Migration
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
        
        $this->createTable('report', [
            'id' => $this->primaryKey(11),
            'id_provinsi' => $this->integer(11),
            'date'=> $this->date(),
            'udara' => $this->decimal(20,2),
            'laut' => $this->decimal(20,2), 
            'darat' => $this->decimal(20,2),
            'total' => $this->decimal(20,2),
            'surat_tugas' => $this->text(),
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
        $this->dropTable('{{%data}}');
    }
}
