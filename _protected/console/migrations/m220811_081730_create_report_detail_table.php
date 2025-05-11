<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report_detail}}`.
 */
class m220811_081730_create_report_detail_table extends Migration
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
        
        $this->createTable('report_detail', [
            'id' => $this->primaryKey(11),
            'id_report' => $this->integer(11),
            'id_jenis_narkotika' => $this->integer(11),
            'total' => $this->decimal(20,2),
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by'=>$this->string(255),
            'status'=>$this->smallInteger(2)->defaultValue(1)->comment('-1=deleted,1=active,0=inactive'),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-report_detail-report_id',
            'report_detail', 'id_report',
            'report', 'id',
            'cascade', 'cascade'
        );

        $this->addForeignKey(
            'fk-report_detail-id_jenis_narkotika',
            'report_detail', 'id_jenis_narkotika',
            'jenis_narkotika', 'id',
            'cascade', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_detail}}');
    }
}
