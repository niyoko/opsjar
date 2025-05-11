<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tahun}}`.
 */
class m220811_022815_create_tahun_table extends Migration
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
        
        $this->createTable('tahun', [
            'id' => $this->primaryKey(11),
            'label' => $this->string(4),
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by'=>$this->string(255),
            'status'=>$this->smallInteger(2)->defaultValue(1)->comment('-1=deleted,1=active,0=inactive'),
        ], $tableOptions);

        $this->batchInsert('tahun', ['label', 'created_at', 'created_by'] ,[
            [2021, date("Y-m-d H:i:s"),'system'],
            [2022, date("Y-m-d H:i:s"),'system'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tahun}}');
    }
}
