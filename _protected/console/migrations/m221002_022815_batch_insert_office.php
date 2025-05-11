<?php

use yii\db\Migration;

/**
 * Class m221002_022815_batch_insert_office
 */
class m221002_022815_batch_insert_office extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('office', ['name','shortname', 'id_provinsi', 'created_at'], [
            //aceh
            ['Kantor Wilayah DJBC Aceh', 'Kanwil Aceh', 6, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Sabang', 'KPPBC Sabang', 6, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Banda Aceh', 'KPPBC Banda Aceh', 6, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Meulaboh', 'KPPBC Meulaboh', 6, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Lhokseumawe', 'KPPBC Lhokseumawe', 6, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Langsa', 'KPPBC Langsa', 6, date('Y-m-d H:i:s')],

            //sumut
            ['Kantor Wilayah DJBC Sumatera Utara', 'Kanwil Sumatera Utara', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Belawan', 'KPPBC Belawan', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Medan', 'KPPBC Medan', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Pematangsiantar', 'KPPBC Pematangsiantar', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Sibolga', 'KPPBC Sibolga', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Teluk Nibung', 'KPPBC Teluk Nibung', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Kuala Tanjung', 'KPPBC Kuala Tanjung', 7, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Kualanamu', 'KPPBC Kualanamu', 7, date('Y-m-d H:i:s')],


            //riau
            ['Kantor Wilayah DJBC Riau', 'Kanwil Riau', 9, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Pekanbaru', 'KPPBC Pekanbaru', 9, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Dumai', 'KPPBC Dumai', 9, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Tembilahan', 'KPPBC Tembilahan', 9, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Bengkalis', 'KPPBC Bengkalis', 9, date('Y-m-d H:i:s')],

            //kepulauan riau
            ['Kantor Wilayah DJBC Khusus Kepulauan Riau', 'Kanwil Kepulauan Riau', 31, date('Y-m-d H:i:s')],
            ['KPU Bea dan Cukai Tipe B Batam', 'KPU Batam', 31, date('Y-m-d H:i:s')],
            ['PSO Bea dan Cukai Tipe B Batam', 'PSO Batam', 31, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Tanjung Balai Karimun', 'KPPBC Tanjung Balai Karimun', 31, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Tanjungpinang', 'KPPBC Tanjungpinang', 31, date('Y-m-d H:i:s')],
            ['PSO Bea dan Cukai Tipe A Tanjung Balai Karimun', 'PSO Tanjung Balai Karimun', 31, date('Y-m-d H:i:s')],

            //Sumatera selatan
            ['Kantor Wilayah DJBC Sumatera Bagian Timur', 'Kanwil Sumatera Bagian Timur', 11, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Palembang', 'KPPBC Palembang', 11, date('Y-m-d H:i:s')],
            

            //Jambi
            ['KPPBC Tipe Madya Pabean B Jambi', 'KPPBC Jambi', 10, date('Y-m-d H:i:s')],


            //Bangka Belitung
            ['KPPBC Tipe Madya Pabean C Pangkalpinang', 'KPPBC Pangkalpinang', 29, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Tanjungpandan', 'KPPBC Tanjungpandan', 29, date('Y-m-d H:i:s')],


            //Lampung
            ['Kantor Wilayah DJBC Sumatera Bagian Barat', 'Kanwil Sumatera Bagian Barat', 12, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Bandar Lampung', 'KPPBC Bandar Lampung', 12, date('Y-m-d H:i:s')],

            //Bengkulu
            ['KPPBC Tipe Madya Pabean C Bengkulu', 'KPPBC Bengkulu', 26, date('Y-m-d H:i:s')],


            //Banten
            ['Kantor Wilayah DJBC Banten', 'Kanwil Banten', 28, date('Y-m-d H:i:s')],
            ['KPU Bea dan Cukai Tipe C Soekarno-Hatta', 'KPU Soekarno-Hatta', 28, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Merak', 'KPPBC Merak', 28, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Tangerang', 'KPPBC Tangerang', 28, date('Y-m-d H:i:s')],
            

            //Jakarta
            ['Kantor Wilayah DJBC Jakarta', 'Kanwil Jakarta', 1, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Jakarta', 'KPPBC Jakarta', 1, date('Y-m-d H:i:s')],
            ['KPU Bea dan Cukai Tipe A Tanjung Priok', 'KPU  Tanjung Priok', 1, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Marunda', 'KPPBC Marunda', 1, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Kantor Pos Pasar Baru', 'KPPBC Kantor Pos Pasar Baru', 1, date('Y-m-d H:i:s')],
            ['PSO Bea dan Cukai Tipe B Tanjung Priok', 'PSO Tanjung Priok', 1, date('Y-m-d H:i:s')],


            //Jawa Barat
            ['Kantor Wilayah DJBC Jawa Barat', 'Kanwil Jawa Barat', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Bekasi', 'KPPBC Bekasi', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Bogor', 'KPPBC Bogor', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Purwakarta', 'KPPBC Purwakarta', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Bandung', 'KPPBC Bandung', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Cirebon', 'KPPBC Cirebon', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Tasikmalaya', 'KPPBC Tasikmalaya', 2, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Cikarang', 'KPPBC Cikarang', 2, date('Y-m-d H:i:s')],


            //jawa tengah
            ['Kantor Wilayah DJBC Jawa Tengah dan DIY', 'Kanwil  Jawa Tengah dan DIY', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Tanjung Emas', 'KPPBC  Tanjung Emas', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Cukai Kudus', 'KPPBC  Kudus', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Surakarta', 'KPPBC  Surakarta', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Cilacap', 'KPPBC  Cilacap', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Purwokerto', 'KPPBC  Purwokerto', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Tegal', 'KPPBC  Tegal', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Semarang', 'KPPBC  Semarang', 3, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Magelang', 'KPPBC  Magelang', 3, date('Y-m-d H:i:s')],

            //Diy
            ['KPPBC Tipe Madya Pabean B Yogyakarta', 'KPPBC  Yogyakarta', 4, date('Y-m-d H:i:s')],


            //Jawa Timur
            ['Kantor Wilayah DJBC Jawa Timur I', 'Kanwil Jawa Timur I', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Tanjung Perak', 'KPPBC Tanjung Perak', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Pasuruan', 'KPPBC Pasuruan', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Juanda', 'KPPBC Juanda', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Gresik', 'KPPBC Gresik', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Madura', 'KPPBC Madura', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Bojonegoro', 'KPPBC Bojonegoro', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Sidoarjo', 'KPPBC Sidoarjo', 5, date('Y-m-d H:i:s')],
            ['Kantor Wilayah DJBC Jawa Timur II', 'Kanwil Jawa Timur II', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Cukai Malang', 'KPPBC Malang', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Cukai Kediri', 'KPPBC Kediri', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Blitar', 'KPPBC Blitar', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Madiun', 'KPPBC Madiun', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Jember', 'KPPBC Jember', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Banyuwangi', 'KPPBC Banyuwangi', 5, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Probolinggo', 'KPPBC Probolinggo', 5, date('Y-m-d H:i:s')],


            //Bali
            ['Kantor Wilayah DJBC Bali, NTB dan NTT', 'KPPBC Probolinggo', 22, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean Ngurah Rai', 'KPPBC Ngurah Rai', 22, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean A Denpasar', 'KPPBC Denpasar', 22, date('Y-m-d H:i:s')],


            //NTB
            ['KPPBC Tipe Madya Pabean C Mataram', 'KPPBC Mataram', 23, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Sumbawa', 'KPPBC Sumbawa', 23, date('Y-m-d H:i:s')],



            //NTT
            ['KPPBC Tipe Madya Pabean C Kupang', 'KPPBC Kupang', 24, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Atambua', 'KPPBC Atambua', 24, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Labuan Bajo', 'KPPBC Labuan Bajo', 24, date('Y-m-d H:i:s')],


            //Kalimantan Barat
            ['Kantor Wilayah DJBC Kalimantan Bagian Barat', 'Kanwil Kalimantan Bagian Barat', 13, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Pontianak', 'KPPBC Pontianak', 13, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Entikong', 'KPPBC Entikong', 13, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Nanga Badau', 'KPPBC Nanga Badau', 13, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Sintete', 'KPPBC Sintete', 13, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Ketapang', 'KPPBC Ketapang', 13, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Jagoi Babang', 'KPPBC Jagoi Babang', 13, date('Y-m-d H:i:s')],


            //Kalimantan Selatan
            ['Kantor Wilayah DJBC Kalimantan Bagian Selatan', 'Kanwil Kalimantan Bagian Selatan', 15, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Banjarmasin', 'KPPBC Banjarmasin', 15, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Kotabaru', 'KPPBC Kotabaru', 15, date('Y-m-d H:i:s')],


            //kalimtan tengah
            ['KPPBC Tipe Madya Pabean C Sampit', 'KPPBC Sampit', 14, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Pangkalan Bun', 'KPPBC Pangkalan Bun', 14, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Palangkaraya', 'KPPBC Palangkaraya', 14, date('Y-m-d H:i:s')],


            //Kalimantan Timur
            ['Kantor Wilayah DJBC Kalimantan Bagian Timur', 'Kanwil  Kalimantan Bagian Timur', 16, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Balikpapan', 'KPPBC Balikpapan', 16, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Samarinda', 'KPPBC Samarinda', 16, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Bontang', 'KPPBC Bontang', 16, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Sangatta', 'KPPBC Sangatta', 16, date('Y-m-d H:i:s')],


            //kalimantan utara
            ['KPPBC Tipe Madya Pabean B Tarakan', 'KPPBC Tarakan', 34, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Nunukan', 'KPPBC Nunukan', 34, date('Y-m-d H:i:s')],


            //sulawesi selatan
            ['Kantor Wilayah DJBC Sulawesi Bagian Selatan', 'Kanwil Sulawesi Bagian Selatan', 19, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean B Makassar', 'KPPBC Makassar', 19, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Parepare', 'KPPBC Parepare', 19, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Malili', 'KPPBC Malili', 19, date('Y-m-d H:i:s')],
            

            //sulawesi tenggara
            ['KPPBC Tipe Madya Pabean C Kendari', 'KPPBC Kendari', 20, date('Y-m-d H:i:s')],

            //sulawesi utara
            ['Kantor Wilayah DJBC Sulawesi Bagian Utara', 'Kanwil Sulawesi Bagian Utara', 17, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Bitung', 'KPPBC Bitung', 17, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Manado', 'KPPBC Manado', 17, date('Y-m-d H:i:s')],


            //sulawesi tengah
            ['KPPBC Tipe Madya Pabean C Pantoloan', 'KPPBC Pantoloan', 18, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Morowali', 'KPPBC Morowali', 18, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Luwuk', 'KPPBC Luwuk', 18, date('Y-m-d H:i:s')],
            ['PSO Bea dan Cukai Tipe B Pantoloan', 'PSO Pantoloan', 18, date('Y-m-d H:i:s')],


            //gorontalo
            ['KPPBC Tipe Madya Pabean C Gorontalo', 'KPPBC Gorontalo', 30, date('Y-m-d H:i:s')],
            
            
            //Maluku
            ['Kantor Wilayah DJBC Maluku', 'Kanwil Maluku', 21, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Ambon', 'KPPBC Ambon', 21, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Tual', 'KPPBC Tual', 21, date('Y-m-d H:i:s')],

            //maluku utara
            ['KPPBC Tipe Madya Pabean C Ternate', 'KPPBC Ternate', 27, date('Y-m-d H:i:s')],




            //papua barat
            ['Kantor Wilayah DJBC Khusus Papua', 'Kanwil Papua', 32, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Sorong', 'KPPBC Sorong', 32, date('Y-m-d H:i:s')],
            ['PSO Bea dan Cukai Tipe B Sorong', 'PSO Sorong', 32, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Manokwari', 'KPPBC Manokwari', 32, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Fakfak', 'KPPBC Fakfak', 32, date('Y-m-d H:i:s')],



            //papua
            ['KPPBC Tipe Madya Pabean C Jayapura', 'KPPBC Jayapura', 25, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Timika', 'KPPBC Timika', 25, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Biak', 'KPPBC Biak', 25, date('Y-m-d H:i:s')],
            ['KPPBC Tipe Madya Pabean C Merauke', 'KPPBC Merauke', 25, date('Y-m-d H:i:s')],




        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221002_022815_batch_insert_office cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221002_022815_batch_insert_office cannot be reverted.\n";

        return false;
    }
    */
}
