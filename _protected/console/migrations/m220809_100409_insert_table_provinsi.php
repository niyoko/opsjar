<?php

use yii\db\Migration;

/**
 * Class m220809_100409_insert_table_provinsi
 */
class m220809_100409_insert_table_provinsi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('provinsi', ['name', 'created_at', 'created_by'], [
            ['DKI Jakarta', date("Y-m-d H:i:s"), 'system'],
            ['Jawa Barat', date("Y-m-d H:i:s"), 'system'],
            ['Jawa Tengah', date("Y-m-d H:i:s"), 'system'],
            ['Yogyakarta', date("Y-m-d H:i:s"), 'system'],
            ['Jawa Timur', date("Y-m-d H:i:s"), 'system'],
            ['Aceh', date("Y-m-d H:i:s"), 'system'],
            ['Sumatera Utara', date("Y-m-d H:i:s"), 'system'],
            ['Sumatera Barat', date("Y-m-d H:i:s"), 'system'],
            ['Riau', date("Y-m-d H:i:s"), 'system'],
            ['Jambi', date("Y-m-d H:i:s"), 'system'],
            ['Sumatera Selatan', date("Y-m-d H:i:s"), 'system'],
            ['Lampung', date("Y-m-d H:i:s"), 'system'],
            ['Kalimantan Barat', date("Y-m-d H:i:s"), 'system'],
            ['Kalimantan Tengah', date("Y-m-d H:i:s"), 'system'],
            ['Kalimantan Selatan', date("Y-m-d H:i:s"), 'system'],
            ['Kalimantan Timur', date("Y-m-d H:i:s"), 'system'],
            ['Sulawesi Utara', date("Y-m-d H:i:s"), 'system'],
            ['Sulawesi Tengah', date("Y-m-d H:i:s"), 'system'],
            ['Sulawesi Selatan', date("Y-m-d H:i:s"), 'system'],
            ['Sulawesi Tenggara', date("Y-m-d H:i:s"), 'system'],
            ['Maluku', date("Y-m-d H:i:s"), 'system'],
            ['Bali', date("Y-m-d H:i:s"), 'system'],
            ['Nusa Tenggara Barat', date("Y-m-d H:i:s"), 'system'],
            ['Nusa Tenggara Timur', date("Y-m-d H:i:s"), 'system'],
            ['Papua', date("Y-m-d H:i:s"), 'system'],
            ['Bengkulu', date("Y-m-d H:i:s"), 'system'],
            ['Maluku Utara', date("Y-m-d H:i:s"), 'system'],
            ['Banten', date("Y-m-d H:i:s"), 'system'],
            ['Kepulauan Bangka Belitung', date("Y-m-d H:i:s"), 'system'],
            ['Gorontalo', date("Y-m-d H:i:s"), 'system'],
            ['Kepulauan Riau', date("Y-m-d H:i:s"), 'system'],
            ['Papua Barat', date("Y-m-d H:i:s"), 'system'],
            ['Sulawesi Barat', date("Y-m-d H:i:s"), 'system'],
            ['Kalimantan Utara', date("Y-m-d H:i:s"), 'system'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220809_100409_insert_table_provinsi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220809_100409_insert_table_provinsi cannot be reverted.\n";

        return false;
    }
    */
}
