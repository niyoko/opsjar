<?php

namespace backend\controllers;

use backend\components\MyAlert;
use common\components\MyFormatter;
use backend\models\Narkotika;
use backend\models\Report;
use backend\models\ReportDetail;
use backend\models\search\ReportSearch;
use common\components\Roles;
use common\models\AnalyticsKanwil;
use common\models\AnalyticsModa;
use common\models\AnalyticsPotensiPenyelamatan;
use common\models\AnalyticsTotalNpp;
use common\models\Kantor;
use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ReportController implements the CRUD actions for report model.
 */
class ReportController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'ruleConfig' => [
                        'class' => \backend\components\AccessRule::className(),
                    ],
                    'rules' => [
                        [
                            'actions' => ['create', 'update', 'delete', 'view', 'index', 'manajemen', 'import-analytics', 'process'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_ADMIN]
                        ],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->user->identity->role == Roles::ROLE_ADMIN) {
            $this->layout = '@app/views/layouts-lte/main.php';
        } elseif (Yii::$app->user->identity->role == Roles::ROLE_USER) {
            $this->redirect('index');
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all report models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $searchModel = $this->loadParams($searchModel);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single report model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Report();
        $model->date = date('Y-m-d');
        $jenisNarkotika = Narkotika::optionsAll();
        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->load($this->request->post());
                $model->darat = MyFormatter::removeFormatNumber($model->darat);
                $model->udara = MyFormatter::removeFormatNumber($model->udara);
                $model->laut = MyFormatter::removeFormatNumber($model->laut);
                $model->tahun = date('Y', strtotime($model->date));
                $model->setProvinsi();
                if ($model->save()) {
                    $requestNarkotika = $_POST['narkotika'];
                    $index = 0;
                    foreach (Narkotika::optionsAll() as $key => $value) {
                        $detail = new ReportDetail();
                        $detail->id_report = $model->id;
                        $detail->id_jenis_narkotika =  $key;
                        $detail->total = isset($requestNarkotika[$index]) ? MyFormatter::removeFormatNumber($requestNarkotika[$index]) : 0;
                        if (!$detail->save()) {
                            throw new Exception("Error Processing Request " . $detail->getErrors(), 400);
                        }
                        $index++;
                    }

                    $transaction->commit();
                    \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'narkotika' => $jenisNarkotika
        ]);
    }

    /**
     * Updates an existing report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $jenisNarkotika = Narkotika::optionsAll();
        $modelDetail = ArrayHelper::map(ReportDetail::find()->where(['id_report' => $model->id])->orderBy('id_jenis_narkotika asc')->all(), 'id_jenis_narkotika', 'total');
        $model->nmormalisasiKasus();
        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->load($this->request->post());
                $model->darat = MyFormatter::removeFormatNumber($model->darat);
                $model->udara = MyFormatter::removeFormatNumber($model->udara);
                $model->laut = MyFormatter::removeFormatNumber($model->laut);
                $model->tahun = date('Y', strtotime($model->date));
                $model->setProvinsi();
                if ($model->save()) {
                    $requestNarkotika = $_POST['narkotika'];
                    $index = 0;
                    foreach (Narkotika::optionsAll() as $key => $value) {
                        $detail = ReportDetail::find()->where(['id_report' => $model->id, 'id_jenis_narkotika' => $key])->one();
                        $detail->id_report = $model->id;
                        $detail->id_jenis_narkotika =  $key;
                        $detail->total = isset($requestNarkotika[$index]) ? MyFormatter::removeFormatNumber($requestNarkotika[$index]) : 0;
                        if (!$detail->save()) {
                            throw new Exception("Error Processing Request " . $detail->getErrors(), 400);
                        }
                        $index++;
                    }

                    $transaction->commit();
                    \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new Exception("Error Processing Request " . $e->getMessage(), 400);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'narkotika' => $jenisNarkotika,
            'modelDetail' => $modelDetail
        ]);
    }

    /**
     * Deletes an existing report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        ReportDetail::deleteAll(['id_report' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = report::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionImportAnalytics()
    {
        $totalKasus = AnalyticsTotalNpp::getTotalKasus();
        $lastUpdated = AnalyticsTotalNpp::getLastUpdatedAt();
        $totalBerat = AnalyticsTotalNpp::getTotalBerat();
        $totalHemat = AnalyticsPotensiPenyelamatan::getTotalPenghematanTriliunByTahun(date('Y'));
        $moda = AnalyticsModa::getTotalKasusByTahun(date('Y'));
        return $this->render('import-analytics', [
            'totalKasus' => $totalKasus,
            'lastUpdated' => Yii::$app->formatter->asDateTime($lastUpdated) ?: 'Belum ada data',
            'totalBerat' => $totalBerat ? Yii::$app->formatter->asDecimal($totalBerat) . ' gr' : 'Belum ada data',
            'totalHemat' => $totalHemat ? Yii::$app->formatter->asDecimal($totalHemat) . ' Triliun' : 'Belum ada data',
            'moda' => $moda ? true : false,
        ]);
    }

    public function actionProcess()
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        try {
            $uploadedFile = UploadedFile::getInstanceByName('file');
            if (!$uploadedFile) {
                throw new \Exception('File tidak ditemukan.');
            }

            // Validate extension
            $ext = strtolower(pathinfo($uploadedFile->name, PATHINFO_EXTENSION));
            if (!in_array($ext, ['xlsx', 'xls'])) {
                throw new \Exception('Format file tidak didukung. Hanya .xlsx dan .xls');
            }

            // Configure reader
            $reader = $ext === 'xls' ? new Xls() : new Xlsx();
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);

            $spreadsheet = $reader->load($uploadedFile->tempName);
            $worksheet = $this->getAnalyticWorksheet($spreadsheet);

            // Process data
            $processedDataNpp = $this->processSheetDataTotalNpp($worksheet);
            $processedDataModa = $this->processSheetDataModa($worksheet);
            $processedDataPotensi = $this->processSheetDataPotensiPenyelamatan($worksheet);
            $processedDataKanwil = $this->processSheetDataKanwil($worksheet);

            // Save to database
            $this->saveProcessedData($processedDataNpp, $processedDataModa, $processedDataPotensi, $processedDataKanwil);

            @unlink($uploadedFile->tempName);

            return ['success' => true, 'message' => 'Data berhasil diproses'];
        } catch (\Exception $e) {
            @unlink($uploadedFile->tempName ?? '');
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function getAnalyticWorksheet($spreadsheet)
    {
        $worksheet = $spreadsheet->getSheetByName('ANALYTIC', false)
            ?: $spreadsheet->getSheetByName('analytic', false);

        if (!$worksheet) {
            throw new \Exception('Sheet "ANALYTIC" tidak ditemukan dalam file.');
        }

        return $worksheet;
    }

    private function saveProcessedData($nppData, $modaData, $potensiData, $kanwilData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Process NPP data
            if ($nppData) {
                $this->truncateAndBatchInsert(AnalyticsTotalNpp::tableName(), $nppData, AnalyticsTotalNpp::class);
            }

            // Process Moda data
            if ($modaData) {
                $this->truncateAndBatchInsert(AnalyticsModa::tableName(), $modaData, AnalyticsModa::class);
            }

            // Process Potensi data
            if ($potensiData) {
                $this->truncateAndBatchInsert(AnalyticsPotensiPenyelamatan::tableName(), $potensiData, AnalyticsPotensiPenyelamatan::class);
            }

            // Process Kanwil data
            if ($kanwilData) {
                $this->truncateAndBatchInsert(AnalyticsKanwil::tableName(), $kanwilData, AnalyticsKanwil::class);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function truncateAndBatchInsert($tableName, $data, $modelClass)
    {
        Yii::$app->db->createCommand()->truncateTable($tableName)->execute();

        $batch = [];
        foreach ($data as $item) {
            $model = new $modelClass();
            $model->attributes = $item;
            if (!$model->validate()) {
                throw new \Exception("Validasi gagal untuk {$tableName}: " . json_encode($model->errors));
            }
            $batch[] = $item;
        }

        if (!empty($batch)) {
            Yii::$app->db->createCommand()
                ->batchInsert($tableName, array_keys($batch[0]), $batch)
                ->execute();
        }
    }

    private function processSheetDataTotalNpp(Worksheet $worksheet)
    {
        $data = [];
        $columns = $this->getOddColumnsFromC();

        foreach ($columns as $col) {
            try {
                $year = $this->getValidYear($worksheet, $col, 5);
                if (!$year) continue;

                $nextCol = $this->nextColumn($col);

                $data[] = [
                    'tahun' => $year,
                    'kasus' => $this->cleanNumber($worksheet->getCell($col . 6)->getFormattedValue(), true),
                    'berat_gr' => $this->cleanNumber($worksheet->getCell($nextCol . 6)->getFormattedValue()),
                    'berat_kg' => $this->cleanNumber($worksheet->getCell($nextCol . 7)->getFormattedValue())
                ];
            } catch (\Exception $e) {
                continue;
            }
        }

        return $data;
    }

    private function processSheetDataModa(Worksheet $worksheet)
    {
        $data = [];
        $columns = $this->getOddColumnsFromC();

        foreach ($columns as $col) {
            try {
                $year = $this->getValidYear($worksheet, $col, AnalyticsModa::ROW_EXCEL_TAHUN);
                if (!$year) continue;

                $nextCol = $this->nextColumn($col);

                foreach (AnalyticsModa::getAllPerlintasan() as $perlintasan) {
                    $row = AnalyticsModa::getRowExcelPerlintasan($perlintasan);
                    $data[] = [
                        'tahun' => $year,
                        'perlintasan' => $perlintasan,
                        'kasus' => $this->cleanNumber($worksheet->getCell($col . $row)->getFormattedValue(), true),
                        'berat' => $this->cleanNumber($worksheet->getCell($nextCol . $row)->getFormattedValue()),
                        'last_updated_by' => Yii::$app->user->id
                    ];
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $data;
    }

    private function processSheetDataPotensiPenyelamatan(Worksheet $worksheet)
    {
        $data = [];
        $columns = $this->getOddColumnsFromC();

        foreach ($columns as $col) {
            try {
                $year = $this->getValidYear($worksheet, $col, AnalyticsPotensiPenyelamatan::ROW_EXCEL_YEAR);
                if (!$year) continue;

                $koefisiensi = $this->cleanNumber($worksheet->getCell($col . AnalyticsPotensiPenyelamatan::ROW_EXCEL_KOEFISIENSI)->getFormattedValue());
                $nextCol = $this->nextColumn($col);
                $penghematanRp = $this->cleanNumber($worksheet->getCell($nextCol . AnalyticsPotensiPenyelamatan::ROW_EXCEL_PENGHEMATAN_RP)->getFormattedValue());
                $jiwa = $this->cleanNumber($worksheet->getCell($col . AnalyticsPotensiPenyelamatan::ROW_EXCEL_JIWA)->getFormattedValue(), true);
                $penghematanTriliun = $this->cleanNumber($worksheet->getCell($nextCol . AnalyticsPotensiPenyelamatan::ROW_EXCEL_PENGHEMATAN_TRILIUN)->getFormattedValue());

                if ($koefisiensi !== null && $penghematanRp !== null && $jiwa !== null && $penghematanTriliun !== null) {
                    $data[] = [
                        'tahun' => $year,
                        'koefisiensi' => floatval($koefisiensi / 100), // Convert to decimal
                        'penghematan_rp' => $penghematanRp,
                        'jiwa' => $jiwa,
                        'penghematan_triliun' => $penghematanTriliun,
                        'last_updated_by' => Yii::$app->user->id
                    ];
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $data;
    }

    private function processSheetDataKanwil(Worksheet $worksheet)
    {
        $data = [];
        $offices = array_flip(Kantor::getAllOfices());

        // Define fixed positions based on your Excel structure
        $yearRow = 449;       // Tahun berada di row 449
        $startRow = 451;      // Data dimulai dari row 451
        $endRow = 584;        // Data berakhir di row 584
        $officeCol = 'B';     // Nama kantor ada di kolom B

        // Get year columns (C, E, G, I, K, ...)
        $columns = $this->getOddColumnsFromC();

        // Process each data row
        for ($row = $startRow; $row <= $endRow; $row++) {
            $officeName = trim(strval($worksheet->getCell($officeCol . $row)->getFormattedValue()));
            if (empty($officeName)) continue; // Skip empty office names

            $officeId = $offices[$officeName] ?? null;
            if (!$officeId) continue; // Skip if office not found

            // Process each year column
            foreach ($columns as $col) {
                try {
                    $year = $this->getValidYear($worksheet, $col, $yearRow);
                    if (!$year) continue;

                    $nextCol = $this->nextColumn($col);

                    $data[] = [
                        'id_office' => $officeId,
                        'kasus' => $this->cleanNumber($worksheet->getCell($col . $row)->getFormattedValue(), true),
                        'berat' => $this->cleanNumber($worksheet->getCell($nextCol . $row)->getFormattedValue()),
                        'tahun' => $year,
                    ];
                } catch (\Exception $e) {
                    continue; // Skip if error occurs
                }
            }
        }

        return $data;
    }

    private function getOddColumnsFromC()
    {
        $columns = [];
        foreach (range('C', 'Z') as $i => $col) {
            if ($i % 2 === 0) { // Every 2nd column (0-based index)
                $columns[] = $col;
            }
        }
        return $columns;
    }

    private function getValidYear(Worksheet $worksheet, $col, $row)
    {
        $yearValue = trim(strval($worksheet->getCell($col . $row)->getFormattedValue()));
        return preg_match('/^20[2-9][0-9]$/', $yearValue) ? (int)$yearValue : null;
    }


    /**
     * Helper to get next column letter
     */
    private function nextColumn($col)
    {
        $col = strtoupper($col);
        $result = '';
        $carry = true;
        for ($i = strlen($col) - 1; $i >= 0; $i--) {
            $char = $col[$i];
            if ($carry) {
                if ($char === 'Z') {
                    $char = 'A';
                } else {
                    $char = chr(ord($char) + 1);
                    $carry = false;
                }
            }
            $result = $char . $result;
        }
        if ($carry) {
            $result = 'A' . $result;
        }
        return $result;
    }


    /**
     * Clean and convert number from Excel format
     */
    private function cleanNumber($value, $int = false)
    {
        if ($value === null || $value === '' || trim($value) === '') {
            return null;
        }

        $cleaned = str_replace('.', '', trim($value)); // Hapus pemisah ribuan
        $cleaned = str_replace(',', '.', $cleaned);    // Ganti koma jadi titik (desimal)

        if (is_numeric($cleaned)) {
            return $int ? (int)$cleaned : (float)$cleaned;
        }

        return null;
    }


    private function loadParams($searchModel)
    {
        $request = Yii::$app->request->get();
        if (isset($request['tahun'])) {
            $searchModel->tahun = $request['tahun'];
        }
        if (isset($request['bulan'])) {
            $searchModel->bulan = $request['bulan'];
        }
        if (isset($request['name'])) {
            $searchModel->name = $request['name'];
        }
        return $searchModel;
    }
}
