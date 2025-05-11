<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bimtek}}`.
 */
class m220811_082633_create_bimtek_table extends Migration
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
        
        $this->createTable('bimtek', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(255),
            'surat_tugas' => $this->text(),
            'date_start' => $this->date(),
            'date_end' => $this->date(),
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
        $this->dropTable('{{%bimtek}}');
    }
}
