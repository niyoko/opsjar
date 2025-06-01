<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;

\yii\web\YiiAsset::register($this);

$cards = [
    [
        [
            ['Total Kasus', 'document_search', fn() => 438],
            ['Total Berat', 'box', fn() => '4.451,45 KG'],
        ],
        [
            ['Potensi Penghematan Negara', 'money_bag', fn() => 'Rp 10.180,228M'],
        ],
        [
            ['Potensi Jiwa Terselamatkan', 'diversity_3', fn() => '6.366.781'],
        ],
    ],
    [
        [
            ['Jenis NPP', 'category', function () {
                $items = [
                    ['Ganja', 'bg-abu', '1.837 KG'],
                    ['Methamphetamine', 'bg-orange', '1.364 KG'],
                    ['Biji Ganja', 'bg-gelap', '969 KG'],
                    ['MDMA', 'bg-biru-muda', '148 KG'],
                ];

                return Html::tag("div", implode('', [
                    Html::tag(
                        "div",
                        Html::tag("canvas", '', ['id' => 'npp-chart']),
                        [
                            'style' => 'position: relative; height: 150px'
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
            ['Moda Penyelundupan', 'delivery_truck_speed', function () {
                $items = [
                    ['Udara', 'travel', 'text-orange', 211],
                    ['Ekspedisi', 'quick_reorder', 'text-abu', 120],
                    ['Darat', 'local_shipping', 'text-gelap', 160],
                    ['Laut', 'anchor', 'text-biru-muda', 482],
                ];
                return Html::tag("div", implode('', array_map(function ($item) {
                    return Html::tag("div", implode('', [
                        Html::tag("span", implode('', [
                            Html::tag("span", $item[1], ['class' => 'material-symbols-outlined ' . $item[2]]),
                            Html::tag("span", $item[0], ['class' => 'font-normal text-[12px]']),
                        ]), [
                            'class' => 'flex flex-row items-center gap-1'
                        ]),
                        Html::tag("span", $item[3], ['class' => 'text-[18px]']),
                    ]), [
                        'class' => 'flex flex-row items-center gap-2 justify-between w-full'
                    ]);
                }, $items)), [
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

<div class="index-container flex flex-column gap-3 p-2">
    <div class="font-black text-[18px]">DASHBOARD DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN</div>
    <div class="flex justify-between items-start w-full">
        <?php foreach ($cards as $cardItems): ?>
            <div class="flex gap-4">
                <?php foreach ($cardItems as $items): ?>
                    <div class="shadow-md/35 p-2 rounded-lg flex">
                        <?php foreach ($items as $item): ?>
                            <div class="flex flex-column px-4 py-1 gap-2 not-last:border-r-2 border-abu-muda">
                                <div class="text-abu flex gap-1 items-center text-[12px]">
                                    <span class="material-symbols-outlined"><?= $item[1] ?></span>
                                    <span class=" font-medium"><?= $item[0] ?></span>
                                </div>
                                <div class="font-bold text-[24px]"><?= call_user_func($item[2]) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="main-map" class="mx-auto w-fit"></div>
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="Modal Detail" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-lg">
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
$this->registerJs('window.dataKanwil = ' . json_encode($dataKanwil) . ';', View::POS_HEAD);
$this->registerJs(file_get_contents(__DIR__ . '/_index.js'), View::POS_END);
