<?php

namespace backend\models;

use common\components\MyFormatter;
use Yii;

/**
 * This is the model class for table "capaian_iku".
 *
 * @property int $id
 * @property int|null $tahun
 * @property float|null $grey
 * @property float|null $below
 * @property float|null $meet
 * @property float|null $exceed
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class CapaianIku extends \common\models\CapaianIku
{

    public function removeAllFormatNumber(){
        $this->below = $this->below ? MyFormatter::removeFormatNumber($this->below) : 0;
        $this->meet = $this->meet ? MyFormatter::removeFormatNumber($this->meet) : 0;
        $this->exceed = $this->exceed ? MyFormatter::removeFormatNumber($this->exceed) : 0;
        $this->grey = $this->grey ? MyFormatter::removeFormatNumber($this->grey) : 0;
    }

    public function roundAllField(){
        $this->below = $this->below ? round($this->below) : 0;
        $this->meet = $this->meet ? round($this->meet) : 0;
        $this->exceed = $this->exceed ? round($this->exceed) : 0;
        $this->grey = $this->grey ? round($this->grey) : 0;
    }

    public function getTotal(){
        return round($this->below + $this->meet + $this->exceed + $this->grey);
    }
}
