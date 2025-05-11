<?php

use yii\db\Migration;

/**
 * Class m220810_033412_update_path_provinsi
 */
class m220810_033412_update_path_provinsi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('provinsi', ['path' => '01'], ['id' => 6 ]);
        $this->update('provinsi', ['path' => '02'], ['id' => 7 ]);
        $this->update('provinsi', ['path' => '03'], ['id' => 8 ]);
        $this->update('provinsi', ['path' => '04'], ['id' => 9 ]);
        $this->update('provinsi', ['path' => '05'], ['id' => 10 ]);
        $this->update('provinsi', ['path' => '06'], ['id' => 11 ]);
        $this->update('provinsi', ['path' => '07'], ['id' => 26 ]);
        $this->update('provinsi', ['path' => '08'], ['id' => 12 ]);
        $this->update('provinsi', ['path' => '09'], ['id' => 29 ]);
        $this->update('provinsi', ['path' => '10'], ['id' => 31 ]);
        $this->update('provinsi', ['path' => '11'], ['id' => 1 ]);
        $this->update('provinsi', ['path' => '12'], ['id' => 2 ]);
        $this->update('provinsi', ['path' => '13'], ['id' => 3 ]);
        $this->update('provinsi', ['path' => '14'], ['id' => 28 ]);
        $this->update('provinsi', ['path' => '15'], ['id' => 5 ]);
        $this->update('provinsi', ['path' => '16'], ['id' => 4 ]);
        $this->update('provinsi', ['path' => '17'], ['id' => 22 ]);
        $this->update('provinsi', ['path' => '18'], ['id' => 23 ]);
        $this->update('provinsi', ['path' => '19'], ['id' => 24 ]);
        $this->update('provinsi', ['path' => '20'], ['id' => 13 ]);
        $this->update('provinsi', ['path' => '21'], ['id' => 14 ]);
        $this->update('provinsi', ['path' => '22'], ['id' => 15 ]);
        $this->update('provinsi', ['path' => '23'], ['id' => 16 ]);
        $this->update('provinsi', ['path' => '24'], ['id' => 34 ]);
        $this->update('provinsi', ['path' => '25'], ['id' => 17 ]);
        $this->update('provinsi', ['path' => '26'], ['id' => 18 ]);
        $this->update('provinsi', ['path' => '27'], ['id' => 19 ]);
        $this->update('provinsi', ['path' => '28'], ['id' => 20 ]);
        $this->update('provinsi', ['path' => '29'], ['id' => 30 ]);
        $this->update('provinsi', ['path' => '30'], ['id' => 33 ]);
        $this->update('provinsi', ['path' => '31'], ['id' => 21 ]);
        $this->update('provinsi', ['path' => '32'], ['id' => 27 ]);
        $this->update('provinsi', ['path' => '33'], ['id' => 25 ]);
        $this->update('provinsi', ['path' => '34'], ['id' => 32 ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220810_033412_update_path_provinsi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220810_033412_update_path_provinsi cannot be reverted.\n";

        return false;
    }
    */
}
