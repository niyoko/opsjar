<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jenis_narkotika}}`.
 */
class m220811_081410_create_jenis_narkotika_table extends Migration
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
        
        $this->createTable('jenis_narkotika', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(100),
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by'=>$this->string(255),
            'status'=>$this->smallInteger(2)->defaultValue(1)->comment('-1=deleted,1=active,0=inactive'),
        ], $tableOptions);

        $this->batchInsert('jenis_narkotika', ['name'], [['Meth'], ['Cocaine'], ['Ganja'], ['MDMA'], ['Lainnya']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%jenis_narkotika}}');
    }
}
