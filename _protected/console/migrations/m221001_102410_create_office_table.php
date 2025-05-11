<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%office}}`.
 */
class m221001_102410_create_office_table extends Migration
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
       
       $this->createTable('office', [
        'id' => $this->primaryKey(11),
        'name' => $this->text(),
        'id_provinsi' => $this->integer(11),
        'created_at'=>$this->dateTime(),
        'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        'created_by'=>$this->string(255),
        'status'=>$this->smallInteger(2)->defaultValue(1)->comment('-1=deleted,1=active,0=inactive'),
       ], $tableOptions);

       $this->addForeignKey(
        'fk-office-id_provinsi',
        'office', 'id_provinsi',
        'provinsi', 'id',
        'cascade', 'cascade'
    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%office}}');
    }
}
