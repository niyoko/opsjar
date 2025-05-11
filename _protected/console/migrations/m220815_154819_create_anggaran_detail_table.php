<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anggaran_detail}}`.
 */
class m220815_154819_create_anggaran_detail_table extends Migration
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
        
        $this->createTable('anggaran_detail', [
            'id' => $this->primaryKey(11),
            'tahun' => $this->integer(4),
            'type' => $this->smallInteger(1),
            'month' => $this->string(2),
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
        $this->dropTable('{{%anggaran_detail}}');
    }
}
