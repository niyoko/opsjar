<?php

namespace backend\models;

use common\components\MyFormatter;
use Yii;

/**
 * This is the model class for table "capaian_kinerja".
 *
 * @property int $id
 * @property float|null $stakeholders_value
 * @property float|null $stakeholders_percentage
 * @property float|null $internal_business_process_value
 * @property float|null $internal_business_process_percentage
 * @property float|null $learning_growth_value
 * @property float|null $learning_growth_percentage
 * @property int|null $tahun
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 * @property float|null $nko
 */
class CapaianKinerja extends \common\models\CapaianKinerja
{
    public function removeAllFormatNumber(){
        $this->stakeholders_value =  MyFormatter::removeFormatNumber($this->stakeholders_value);
        $this->stakeholders_percentage =  MyFormatter::removeFormatNumber($this->stakeholders_percentage);
        $this->internal_business_process_value =  MyFormatter::removeFormatNumber($this->internal_business_process_value);
        $this->internal_business_process_percentage =  MyFormatter::removeFormatNumber($this->internal_business_process_percentage);
        $this->learning_growth_value =  MyFormatter::removeFormatNumber($this->learning_growth_value);
        $this->learning_growth_percentage =  MyFormatter::removeFormatNumber($this->learning_growth_percentage);
        $this->nko =  MyFormatter::removeFormatNumber($this->nko);
    }

    public function roundAllField(){
        $this->stakeholders_value =  round($this->stakeholders_value);
        $this->stakeholders_percentage =  round($this->stakeholders_percentage);
        $this->internal_business_process_value =  round($this->internal_business_process_value);
        $this->internal_business_process_percentage =  round($this->internal_business_process_percentage);
        $this->learning_growth_value =  round($this->learning_growth_value);
        $this->learning_growth_percentage =  round($this->learning_growth_percentage);
        $this->nko =  round($this->nko);
    }

    public function formatAllField(){
        $this->stakeholders_value =  number_format($this->stakeholders_value,2 , ",", ".");
        $this->stakeholders_percentage =   number_format($this->stakeholders_percentage,2 , ",", ".");
        $this->internal_business_process_value =  number_format($this->internal_business_process_value,2 , ",", ".");
        $this->internal_business_process_percentage =  number_format($this->internal_business_process_percentage,2 , ",", ".");
        $this->learning_growth_value = number_format($this->learning_growth_value,2 , ",", ".");
        $this->learning_growth_percentage = number_format($this->learning_growth_percentage,2 , ",", ".");
        $this->nko = number_format($this->nko,2 , ",", ".");
    }

    public static function getNko($tahun){
        $kinerja = CapaianKinerja::find()->where(['tahun' => $tahun])->one();
        if(!$kinerja){
            $kinerja =  new CapaianKinerja();
        }
        // $kinerja->roundAllField();
        return $kinerja->nko;
    }
    
}
