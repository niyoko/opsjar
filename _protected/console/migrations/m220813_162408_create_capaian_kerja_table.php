<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%capaian_kerja}}`.
 */
class m220813_162408_create_capaian_kerja_table extends Migration
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
        
        $this->createTable('capaian_tren_kinerja', [
            'id' => $this->primaryKey(11),
            'tahun' => $this->integer(4),
            'month' => $this->string(2),
            'value' => $this->decimal(10,2),
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
        $this->dropTable('{{%capaian_kerja}}');
    }
}
