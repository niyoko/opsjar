<?php

namespace backend\models;

use common\components\MyFormatter;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int|null $id_provinsi
 * @property string|null $date
 * @property float|null $udara
 * @property float|null $laut
 * @property float|null $darat
 * @property float|null $total
 * @property string|null $surat_tugas
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 * @property int|null $tahun
 *
 * @property Provinsi $provinsi0
 * @property ReportDetail[] $reportDetails0
 */
class Report extends \common\models\Report
{
    public function getProvinsiName(){
        return $this->provinsi->name ?: '-';
    }

    public function getMeth($formated = false){
        $md = ReportDetail::find()->where(['id_report' => $this->id, 'id_jenis_narkotika' => Narkotika::TYPE_METH])->one();
        $total = $md ? $md->total : 0;
        return $formated ? MyFormatter::applyNumberFormat($total).'gr' : $total;
    }

    public function getCocaine($formated = false){
        $md = ReportDetail::find()->where(['id_report' => $this->id, 'id_jenis_narkotika' => Narkotika::TYPE_COCAINE])->one();
        $total = $md ? $md->total : 0;
        return $formated ? MyFormatter::applyNumberFormat($total).'gr' : $total;
    }

    public function getGanja($formated = false){
        $md = ReportDetail::find()->where(['id_report' => $this->id, 'id_jenis_narkotika' => Narkotika::TYPE_GANJA])->one();
        $total = $md ? $md->total : 0;
        return $formated ? MyFormatter::applyNumberFormat($total).'gr' : $total;
    }

    public function getMdma($formated = false){
        $md = ReportDetail::find()->where(['id_report' => $this->id, 'id_jenis_narkotika' => Narkotika::TYPE_MDMA])->one();
        $total = $md ? $md->total : 0;
        return $formated ? MyFormatter::applyNumberFormat($total).'gr' : $total;
    }

    public function getLainnya($formated = false){
        $md = ReportDetail::find()->where(['id_report' => $this->id, 'id_jenis_narkotika' => Narkotika::TYPE_LAINNYA])->one();
        $total = $md ? $md->total : 0;
        return $formated ? MyFormatter::applyNumberFormat($total).'gr' : $total;
    }

    public function getTotalGr($formated = false){
        $total = $this->getMeth() + $this->getCocaine() + $this->getGanja() + $this->getMdma() + $this->getLainnya();
        return $formated ? MyFormatter::applyNumberFormat($total).'gr' : $total;
    }

    public function getReportedDate(){
        return Yii::$app->formatter->asDate($this->date);
    }

    public function getActionButton(){
        $button = Html::a('<i class="material-icons-round">edit</i> Ubah', ['update','id' => $this->id], ['class' => 'dropdown-item']);
        $button .=  Html::a('<span class="text-danger"><i class="material-icons-round">delete</i> Hapus</span>', ['delete','id' => $this->id], ['class' => 'dropdown-item', 'data-pjax' => 0, 'data-confirm' => 'Apakah anda yakin?', 'data-method' => 'post']);
        $button_text = '<i class="material-icons-round text-warning">more_horiz</i>';
        $button_template = '
            <a class="" type="button" tabindex="0" role="menu" id="detail" data-toggle="dropdown">{button_text} </a>
            <div class="dropdown-menu order" aria-labelledby="detail">
                {buttons}
            </div>
        ';
        $button_template = str_replace('{buttons}', $button, $button_template);
        $button_template = str_replace('{button_text}', $button_text, $button_template);
        return $button_template;
    }

    public static function getDataSeluruhIndonesia($tahun, $provinsi, $bulan){
        $query = new Query();
        $query->from('report');
        $query->select([
            'darat' => 'SUM(report.darat)',
            'laut' => 'SUM(report.laut)',
            'udara' => 'SUM(report.udara)',
        ])->where(['tahun' => $tahun]);
        if($bulan){
            $query->andWhere(['MONTH(report.date)' => $bulan]);
        }
        
        if($provinsi){
            $query->andWhere(['id_provinsi' => $provinsi]);
        }
        $data = $query->one();
        
        $darat = 0;
        $laut = 0;
        $udara = 0;
        
        if($data){        
            $darat = round($data['darat']);
            $laut = round($data['laut']);
            $udara = round($data['udara']);
        }


        return [
            'darat' => $darat,
            'laut' => $laut,
            'udara' => $udara
        ];
    }

    public static function getDataDetail($tahun, $provinsi, $bulan = null){
        $query = new Query();
        $query->from('report_detail');
        $query->join('join', 'report', 'report.id = report_detail.id_report');
        $query->where(['report.tahun' => $tahun]);
        if($provinsi){
            $query->andWhere(['report.id_provinsi' => $provinsi]);
        }
        if($bulan){
            $query->andWhere(['MONTH(report.date)' => $bulan]);
        }
        $query->groupBy('id_jenis_narkotika');
        $query->select([
            'narkotika' => 'id_jenis_narkotika',
            'jml' => 'sum(report_detail.total)',
        ]);

        $data =  $query->all();
        $max = 0;
        if($data){
            $data = ArrayHelper::map($data, 'narkotika', 'jml');
            $max = max($data);
        }
        $result = [];
        $color = Narkotika::optionsAllColor();
       
        foreach (Narkotika::optionsAll() as $key => $v) {;
            $result[$key] = [
                'id' => $key,
                'label' => $v,
                'total' => isset($data[$key]) ? $data[$key]: 0,
                'color' => $color[$key],
                'width' => $max && isset($data[$key]) ? round($data[$key] * 100 / $max ) : 0,
            ];
        }
        return $result;

    }

    public static function getKasusTertinggi($tahun, $bulan){
        $query = new Query();
        $query->from('report');
        $query->join('join', 'office', 'office.id = report.id_office');
        $query->select([
            'total' => '(SUM(COALESCE(report.darat,0)+COALESCE(report.laut,0)+COALESCE(report.udara,0)))',
            'id_office',
            'name' => 'office.shortname'
        ])->where(['tahun' => $tahun]);
        if($bulan){
            $query->andWhere(['MONTH(report.date)' => $bulan]);
        }
        $query->groupBy('id_office')->orderBy('total desc');

        return $query->limit(5)->all();
    }


    public static function getJnppData($tahun, $bulan){
        $query = new Query();
        $query->from('report');
        $query->where(['tahun' => $tahun, 'MONTH(report.date)' => $bulan]);
        $query->select([
            'MONTH(report.date) tgl',
            'SUM(report.darat) as dar',
            'SUM(report.laut) as lau',
            'SUM(report.udara) as uda',
            'SUM(report.total) as tangkapan'
        ]);
        $query->groupBy('MONTH(report.date)');

        return $query->one();
    }

    public function nmormalisasiKasus(){
        $formatKasus = function ($value){
            $res = 0;
            if(MyFormatter::hasDecimal($value)){
                $res = MyFormatter::applyNumberFormat($value);
            }
            else{
                $res = round($value);
            }
            return $res;
        };


        $this->udara = $formatKasus($this->udara);
        $this->laut = $formatKasus($this->laut);
        $this->darat = $formatKasus($this->darat);
    }


    public function setProvinsi(){
        if($this->id_office){
            $this->id_provinsi = $this->kantor->provinsi->id;
        }
    }
}
