<?php

use yii\db\Migration;

class m250601_045023_seed_master_negara extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%negara}}', [
            'id' => $this->primaryKey(),
            'kode' => $this->string(3)->notNull()->unique(), // alpha-3
            'nama' => $this->string()->notNull(),
            'short_name' => $this->string(3)->notNull(),
            'url_bendera' => $this->string()->null(),
        ]);

        $negaraData = [
            ['AND', 'Andorra'],
            ['ARG', 'Argentina'],
            ['AUS', 'Australia'],
            ['AUT', 'Austria'],
            ['BEL', 'Belgium'],
            ['BEN', 'Benin'],
            ['BGD', 'Bangladesh'],
            ['BLR', 'Belarus'],
            ['BRA', 'Brazil'],
            ['CAN', 'Canada'],
            ['CHE', 'Switzerland'],
            ['CHL', 'Chile'],
            ['CHN', 'China'],
            ['CIV', 'Ivory Coast'],
            ['DEU', 'Germany'],
            ['DNK', 'Denmark'],
            ['DOM', 'Dominican Republic'],
            ['EGY', 'Egypt'],
            ['ESP', 'Spain'],
            ['ETH', 'Ethiopia'],
            ['FRA', 'France'],
            ['GBR', 'United Kingdom'],
            ['GHA', 'Ghana'],
            ['GMB', 'Gambia'],
            ['GRC', 'Greece'],
            ['HKG', 'Hong Kong'],
            ['IDN', 'Indonesia'],
            ['IND', 'India'],
            ['IRL', 'Ireland'],
            ['IRN', 'Iran'],
            ['ITA', 'Italy'],
            ['JPN', 'Japan'],
            ['KAZ', 'Kazakhstan'],
            ['KEN', 'Kenya'],
            ['KHM', 'Cambodia'],
            ['KOR', 'South Korea'],
            ['LKA', 'Sri Lanka'],
            ['LTU', 'Lithuania'],
            ['LVA', 'Latvia'],
            ['MEX', 'Mexico'],
            ['MLT', 'Malta'],
            ['MMR', 'Myanmar'],
            ['MOZ', 'Mozambique'],
            ['MYS', 'Malaysia'],
            ['NGA', 'Nigeria'],
            ['NLD', 'Netherlands'],
            ['NOR', 'Norway'],
            ['NPL', 'Nepal'],
            ['NZL', 'New Zealand'],
            ['PAK', 'Pakistan'],
            ['PER', 'Peru'],
            ['PHL', 'Philippines'],
            ['PNG', 'Papua New Guinea'],
            ['POL', 'Poland'],
            ['PRI', 'Puerto Rico'],
            ['PRT', 'Portugal'],
            ['ROU', 'Romania'],
            ['RUS', 'Russia'],
            ['SAU', 'Saudi Arabia'],
            ['SEN', 'Senegal'],
            ['SGP', 'Singapore'],
            ['SLE', 'Sierra Leone'],
            ['SRB', 'Serbia'],
            ['SWE', 'Sweden'],
            ['SYR', 'Syria'],
            ['THA', 'Thailand'],
            ['TLS', 'Timor-Leste'],
            ['TUR', 'Turkey'],
            ['TWN', 'Taiwan'],
            ['TZA', 'Tanzania'],
            ['UGA', 'Uganda'],
            ['UKR', 'Ukraine'],
            ['USA', 'United States'],
            ['VNM', 'Vietnam'],
            ['YEM', 'Yemen'],
            ['ZAF', 'South Africa'],
        ];

        $alpha2Map = [
            'AND' => 'AD',
            'ARG' => 'AR',
            'AUS' => 'AU',
            'AUT' => 'AT',
            'BEL' => 'BE',
            'BEN' => 'BJ',
            'BGD' => 'BD',
            'BLR' => 'BY',
            'BRA' => 'BR',
            'CAN' => 'CA',
            'CHE' => 'CH',
            'CHL' => 'CL',
            'CHN' => 'CN',
            'CIV' => 'CI',
            'DEU' => 'DE',
            'DNK' => 'DK',
            'DOM' => 'DO',
            'EGY' => 'EG',
            'ESP' => 'ES',
            'ETH' => 'ET',
            'FRA' => 'FR',
            'GBR' => 'GB',
            'GHA' => 'GH',
            'GMB' => 'GM',
            'GRC' => 'GR',
            'HKG' => 'HK',
            'IDN' => 'ID',
            'IND' => 'IN',
            'IRL' => 'IE',
            'IRN' => 'IR',
            'ITA' => 'IT',
            'JPN' => 'JP',
            'KAZ' => 'KZ',
            'KEN' => 'KE',
            'KHM' => 'KH',
            'KOR' => 'KR',
            'LKA' => 'LK',
            'LTU' => 'LT',
            'LVA' => 'LV',
            'MEX' => 'MX',
            'MLT' => 'MT',
            'MMR' => 'MM',
            'MOZ' => 'MZ',
            'MYS' => 'MY',
            'NGA' => 'NG',
            'NLD' => 'NL',
            'NOR' => 'NO',
            'NPL' => 'NP',
            'NZL' => 'NZ',
            'PAK' => 'PK',
            'PER' => 'PE',
            'PHL' => 'PH',
            'PNG' => 'PG',
            'POL' => 'PL',
            'PRI' => 'PR',
            'PRT' => 'PT',
            'ROU' => 'RO',
            'RUS' => 'RU',
            'SAU' => 'SA',
            'SEN' => 'SN',
            'SGP' => 'SG',
            'SLE' => 'SL',
            'SRB' => 'RS',
            'SWE' => 'SE',
            'SYR' => 'SY',
            'THA' => 'TH',
            'TLS' => 'TL',
            'TUR' => 'TR',
            'TWN' => 'TW',
            'TZA' => 'TZ',
            'UGA' => 'UG',
            'UKR' => 'UA',
            'USA' => 'US',
            'VNM' => 'VN',
            'YEM' => 'YE',
            'ZAF' => 'ZA',
        ];

        foreach ($negaraData as [$kode, $nama]) {
            $alpha2 = $alpha2Map[$kode] ?? null;
            $urlBendera = $alpha2 ? "https://flagsapi.com/{$alpha2}/flat/64.png" : null;
            $this->insert('{{%negara}}', [
                'kode' => $kode,
                'nama' => $nama,
                'short_name' => $kode,
                'url_bendera' => $urlBendera,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250601_045023_seed_master_negara cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_045023_seed_master_negara cannot be reverted.\n";

        return false;
    }
    */
}
