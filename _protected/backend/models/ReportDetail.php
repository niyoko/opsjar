<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "report_detail".
 *
 * @property int $id
 * @property int|null $id_report
 * @property int|null $id_jenis_narkotika
 * @property float|null $total
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 *
 * @property JenisNarkotika $jenisNarkotika0
 * @property Report $report0
 */
class ReportDetail extends \common\models\ReportDetail
{
    
}
