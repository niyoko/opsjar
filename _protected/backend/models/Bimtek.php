<?php

namespace backend\models;

use common\components\Roles;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "bimtek".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surat_tugas
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int|null $tahun
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Bimtek extends \common\models\Bimtek
{
    public function getStatusBadges()
   {
        $prefix = 'badge';
        if(Yii::$app->user->identity->role == Roles::ROLE_USER){
            $prefix = 'bg';
        }
        switch ($this->status) {
            case 1:
                $label = '<span class="badge '.$prefix.'-secondary w-100">Scheduled</span>';
                break;
            case 2:
                $label = '<span class="badge  '.$prefix.'-warning w-100">Ongoing</span>';
                break;
            case 3:
                $label = '<span class="badge  '.$prefix.'-success w-100">Selesai</span>';
                break;
            case 4:
                $label = '<span class="badge  '.$prefix.'-danger w-100">Cancelled</span>';
                break;
            
            default:
                $label = '';
                break;
        }

        return $label;
   }

   public function getTanggalPelaksanaan(){
        return Yii::$app->formatter->asDate($this->date_start). ' - '. Yii::$app->formatter->asDate($this->date_end);
   }

   public static function optionsBulan(){
        return [
            '01' => 'Januari',
            '02' => 'Febuari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',

        ];
   }

   public static function optionsBulanShort(){
    return [
        '01' => 'Jan',
        '02' => 'Feb',
        '03' => 'Mar',
        '04' => 'Apr',
        '05' => 'Mei',
        '06' => 'Jun',
        '07' => 'Jul',
        '08' => 'Agu',
        '09' => 'Sep',
        '10' => 'Okt',
        '11' => 'Nov',
        '12' => 'Des',

    ];
}

   public static function optionsTahun(){
        $tahun = date('Y');
        $data = [];
        for ($i=$tahun; $i > ($tahun-5) ; $i--) { 
            $data[$i] = $i;
        }
        return $data;
        
}

   public function getActionButton(){
        $btnUpdate = Html::a('<i class="material-icons-round">edit</i> Ubah', ['update?id='. $this->id], ['class' => 'btn btn-outline-warning']);
      
        $btnDelete = Html::a('<i class="material-icons-round">delete</i>', $this->id ? '/bimtek/delete?id='.$this->id : '#', ['class' => 'btn', 'data-pjax' => 0, 'data-confirm' => 'Apakah anda yakin?', 'data-method' => 'post']);        
        return $btnUpdate . $btnDelete;
   }

   public function getSuratTugasBtn(){
        $disabled = true;
        $label = "Surat Tugas Belum Diunggah";
        if($this->surat_tugas){
            $label = "Unduh";
            $disabled = false;
        }

        return $this->surat_tugas ? Html::a($this->nomor_surat ?: '<i>Belum ada nomor surat</i>', $this->surat_tugas, ['class' => '', 'target' => '_blank']) : '<span class="text-sm"><i>File belum diunggah</i></span>';

    }

    public function getLaporanBtn(){
        $disabled = true;
        $label = "Laporan Belum Diunggah";
        if($this->surat_tugas){
            $label = "Unduh";
            $disabled = false;
        }

        return $this->surat_tugas ? Html::a('<i class="material-icons-round">download</i> '.$label, $this->report, ['class' => 'btn btn-outline-success', 'target' => '_blank']) : '<span class="text-sm"><i>File belum diunggah</i></span>';

    }
}
