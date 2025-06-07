<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;

\yii\web\YiiAsset::register($this);

$formatCurrency = function ($value) {
    if ($value > 1e12) {
        return "Rp\xC2\xA0" .  Yii::$app->formatter->asDecimal($value / 1e12, 2) . "\xC2\xA0T";
    }
    if ($value > 1e9) {
        return "Rp\xC2\xA0" .  Yii::$app->formatter->asDecimal($value / 1e9, 2) . "\xC2\xA0M";
    }

    return "Rp\xC2\xA0" . Yii::$app->formatter->asDecimal($value);
};

$formatBerat = function ($value) {
    return Yii::$app->formatter->asDecimal($value / 1000) . "\xC2\xA0kg";
};

$cards = [
    [
        [
            ['Total Kasus', 'document_search', fn() => Yii::$app->formatter->asDecimal($totalKasus)],
            ['Total Berat', 'box', fn() => $formatBerat($totalBerat)],
        ],
        [
            ['Potensi Penghematan Negara', 'money_bag', fn() => $formatCurrency($totalPenghematan)],
        ],
        [
            ['Potensi Jiwa Terselamatkan', 'diversity_3', fn() =>  Yii::$app->formatter->asDecimal($totalJiwa)],
        ],
    ],
    [
        [
            ['Jenis NPP', 'category', function () {
                $items = [
                    ['Ganja', 'bg-abu', "1.837\xC2\xA0KG"],
                    ['Methamphetamine', 'bg-orange', "1.364\xC2\xA0KG"],
                    ['Biji Ganja', 'bg-gelap', "969\xC2\xA0KG"],
                    ['MDMA', 'bg-biru-muda', "148\xC2\xA0KG"],
                ];

                return Html::tag("div", implode('', [
                    Html::tag(
                        "div",
                        Html::tag("canvas", '', ['id' => 'npp-chart']),
                        [
                            'style' => 'position: relative; height: 100px'
                        ]
                    ),
                    Html::tag("div", implode('', array_map(function ($item) {
                        return Html::tag("div", implode('', [
                            Html::tag("span", implode('', [
                                Html::tag("span", '', ['class' => 'w-3 h-3 rounded-sm flex-none ' . $item[1]]),
                                Html::tag("span", $item[0], ['class' => 'font-normal text-[12px]']),
                            ]), [
                                'class' => 'flex flex-row items-center flex-none w-[100px] break-all gap-1'
                            ]),
                            Html::tag("span", $item[2], ['class' => 'text-[18px]']),
                        ]), [
                            'class' => 'flex flex-row items-center gap-2 justify-between w-full'
                        ]);
                    }, $items)), ['class' => 'flex flex-column gap-1']),
                ]), ['class' => 'flex flex-row gap-3']);
            }],
        ],
        [
            ['Moda Penyelundupan', 'delivery_truck_speed', function () use ($moda, $formatBerat) {
                $items = [
                    'udara' => ['travel', 'text-orange'],
                    'ekspedisi' => ['quick_reorder', 'text-abu'],
                    'darat' => ['local_shipping', 'text-gelap'],
                    'laut' => ['anchor', 'text-biru-muda'],
                ];

                return Html::tag("div", implode('', array_map(function ($item) use ($formatBerat, $items) {
                    if (!$item['perlintasan']) return '';

                    $label = strtoupper(substr($item['perlintasan'], 0, 1)) . substr($item['perlintasan'], 1);
                    $icon = '';
                    $color = '';

                    if (array_key_exists($item['perlintasan'], $items)) {
                        $icon = $items[$item['perlintasan']][0];
                        $color = $items[$item['perlintasan']][1];
                    }

                    return Html::tag("div", implode('', [
                        Html::tag("span", implode('', [
                            $icon ? Html::tag("span", $icon, ['class' => 'material-symbols-outlined ' . $color]) : '',
                            Html::tag("span", $label, ['class' => 'font-normal text-[12px]']),
                        ]), [
                            'class' => 'flex flex-row items-center gap-1'
                        ]),
                        Html::tag("span", $formatBerat($item['berat']), ['class' => 'text-[18px]']),
                    ]), [
                        'class' => 'flex flex-row items-center gap-2 justify-between w-full'
                    ]);
                }, $moda)), [
                    'class' => 'flex flex-column gap-1',
                ]);
            }]
        ]
    ],
];

$this->registerJs(<<<JS
const ctx = document.getElementById('npp-chart');

new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: [
        'Red',
        'Blue',
        'Yellow'
      ],
      datasets: [{
        label: 'My First Dataset',
        data: [300, 50, 100],
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)',
          'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
      }]
  },
  options: {
    layout: {
      padding:0,
    },
    plugins: {
      legend: {
        display: false,
      }
    }
  }
});
JS, View::POS_END);

?>

<div class="index-container flex flex-column gap-4 p-2">
    <div class="flex flex-row justify-between gap-4 items-center w-full">
        <div class="font-black text-[18px]">DASHBOARD DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN</div>
        <div class="flex flex-row gap-2 items-center">
            <label for="select-tahun" class="font-bold">Tahun</label>
            <select id="select-tahun">
                <?php foreach ($years as $year): ?>
                    <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="flex flex-row justify-between gap-4 items-start w-full">
        <?php $i = 0; ?>
        <?php foreach ($cards as $cardItems): ?>
            <div class="flex gap-4">
                <?php foreach ($cardItems as $items): ?>
                    <div class="shadow-md/35 p-2 rounded-lg flex">
                        <?php foreach ($items as $item): ?>
                            <div class="flex flex-column p-2 gap-2 <?= $i ? 'justify-start' : 'justify-between' ?> not-last:border-r-2 border-abu-muda">
                                <div class="text-abu flex gap-1 items-center text-[12px]">
                                    <span class="material-symbols-outlined"><?= $item[1] ?></span>
                                    <span class=" font-medium"><?= $item[0] ?></span>
                                </div>
                                <div class="font-bold text-[18px]"><?= call_user_func($item[2]) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
    <div id="main-map" class="mx-auto w-fit"></div>
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="Modal Detail" aria-hidden="true">
        <div class="modal-dialog max-w-[1335px]!" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold text-dark" id="modalDetailLabel">Provinsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-c p-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs('window.allOffice = ' . json_encode($allOffice) . ';', View::POS_HEAD);
$this->registerJs('window.dataProvinsi = ' . json_encode($dataProvinsi) . ';', View::POS_HEAD);
$this->registerJs('window.anggota = ' . json_encode($anggota) . ';', View::POS_HEAD);
$this->registerJs(file_get_contents(__DIR__ . '/_index.js'), View::POS_END);
