<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'formatter' => [
            'class' => '\common\components\MyFormatter',
            'locale' => 'ID',
            'timeZone' => 'Asia/Jakarta',
            'defaultTimeZone' => 'Asia/Jakarta',
            'dateFormat' => 'dd MMM yyyy',
            'datetimeFormat' => 'dd MMM yyyy, HH:mm zzz',
            'timeFormat' => 'HH:mm zzz',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'IDR',
            'nullDisplay' => '-',
            'numberFormatterSymbols' => [
                NumberFormatter::CURRENCY_SYMBOL => 'Rp'
            ],
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ]
        ],
    ],
];
