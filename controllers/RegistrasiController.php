<?php

namespace app\controllers;

use Yii;
use app\models\Registrasi;
use app\models\DataForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Controller untuk mengelola data registrasi
 */
class RegistrasiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-form' => ['POST'],
                    'hard-delete' => ['POST'],
                    'hard-delete-form' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Menampilkan daftar registrasi
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Registrasi::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['id_registrasi' => SORT_DESC]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Menampilkan detail registrasi
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Membuat registrasi baru
     */
    public function actionCreate()
    {
        $model = new Registrasi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data registrasi berhasil disimpan.');
            return $this->redirect(['view', 'id' => $model->id_registrasi]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Edit registrasi
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data registrasi berhasil diupdate.');
            return $this->redirect(['view', 'id' => $model->id_registrasi]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Hapus registrasi (SOFT DELETE)
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);

            // Soft delete semua form terkait dulu
            DataForm::updateAll(
                ['is_delete' => true, 'update_time_at' => new \yii\db\Expression('NOW()')],
                ['id_registrasi' => $id]
            );

            // Hapus registrasi
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Data registrasi berhasil dihapus.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menghapus data registrasi.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * HARD DELETE - Hapus permanen registrasi
     */
    public function actionHardDelete($id)
    {
        try {
            $model = $this->findModel($id);

            // Hapus semua form data terkait dulu (HARD DELETE)
            $formDeleteCount = DataForm::deleteAll(['id_registrasi' => $id]);

            // Hapus registrasi
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Data registrasi dan $formDeleteCount form berhasil dihapus permanen.");
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menghapus data registrasi.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Form input data medis
     */
    public function actionInputForm($id_registrasi)
    {
        $registrasi = $this->findModel($id_registrasi);
        $model = new DataForm();
        $model->id_registrasi = $id_registrasi;

        if ($model->load(Yii::$app->request->post())) {
            // Process form data
            $this->processFormData($model, Yii::$app->request->post());

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data form medis berhasil disimpan.');
                return $this->redirect(['view-form', 'id' => $model->id_form_data]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan data: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        return $this->render('input-form', [
            'model' => $model,
            'registrasi' => $registrasi,
        ]);
    }

    /**
     * Edit form data medis
     */
    public function actionEditForm($id)
    {
        $model = $this->findDataFormModel($id);
        $registrasi = $model->registrasi;

        if ($model->load(Yii::$app->request->post())) {
            // Process form data
            $this->processFormData($model, Yii::$app->request->post());

            // Set the data directly instead of relying on beforeSave
            $model->data = $model->prepareFormDataForSave();

            if ($model->save(false)) { // Skip validation for now
                Yii::$app->session->setFlash('success', 'Data form medis berhasil diupdate.');
                return $this->redirect(['view-form', 'id' => $model->id_form_data]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal mengupdate data: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        return $this->render('edit-form', [
            'model' => $model,
            'registrasi' => $registrasi,
        ]);
    }

    /**
     * Hapus form data medis (SOFT DELETE)
     */
    public function actionDeleteForm($id)
    {
        try {
            $model = $this->findDataFormModel($id);
            $id_registrasi = $model->id_registrasi;

            $model->is_delete = true;
            $model->update_time_at = new \yii\db\Expression('NOW()');

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Data form medis berhasil dihapus.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menghapus form medis.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->redirect(['view', 'id' => $id_registrasi ?? 1]);
    }

    /**
     * HARD DELETE - Hapus permanen form data medis
     */
    public function actionHardDeleteForm($id)
    {
        try {
            // Cari model tanpa filter is_delete karena mau hard delete
            $model = DataForm::findOne(['id_form_data' => $id]);

            if (!$model) {
                throw new NotFoundHttpException('Data form tidak ditemukan.');
            }

            $id_registrasi = $model->id_registrasi;

            // HARD DELETE - hapus permanen dari database
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Form berhasil dihapus permanen dari database.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menghapus form dari database.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
            $id_registrasi = 1; // fallback
        }

        return $this->redirect(['view', 'id' => $id_registrasi]);
    }

    /**
     * Process form data before saving
     */
    private function processFormData($model, $postData)
    {
        // Set basic info
        if (isset($postData['DataForm'])) {
            $formData = $postData['DataForm'];

            // Set individual properties
            foreach ($formData as $key => $value) {
                if (property_exists($model, $key)) {
                    $model->$key = $value;
                }
            }
        }

        // Process additional fields
        if (isset($postData['anamnesis_diperoleh'])) {
            $model->anamnesis_diperoleh = $postData['anamnesis_diperoleh'];
        }
        if (isset($postData['anamnesis_hubungan'])) {
            $model->anamnesis_hubungan = $postData['anamnesis_hubungan'];
        }
        if (isset($postData['operasi_apa'])) {
            $model->operasi_detail_apa = $postData['operasi_apa'];
        }
        if (isset($postData['operasi_kapan'])) {
            $model->operasi_detail_kapan = $postData['operasi_kapan'];
        }
        if (isset($postData['penyakit_apa'])) {
            $model->dirawat_detail_penyakit = $postData['penyakit_apa'];
        }
        if (isset($postData['dirawat_kapan'])) {
            $model->dirawat_detail_kapan = $postData['dirawat_kapan'];
        }

        // Process risk assessment data
        $riskData = [];
        $totalRisk = 0;
        for ($i = 1; $i <= 6; $i++) {
            $riskKey = "risk{$i}";
            if (isset($postData[$riskKey])) {
                $value = (int)$postData[$riskKey];
                $riskData[$riskKey] = $value;
                $totalRisk += $value;
            }
        }

        // Set resiko jatuh items
        $model->resiko_jatuh_items = $riskData;
        $model->total_resiko_jatuh = $totalRisk;

        // Determine risk category
        if ($totalRisk <= 24) {
            $model->kategori_resiko_jatuh = 'Tidak berisiko (0-24)';
        } elseif ($totalRisk <= 44) {
            $model->kategori_resiko_jatuh = 'Resiko rendah (25-44)';
        } else {
            $model->kategori_resiko_jatuh = 'Resiko tinggi (≥45)';
        }

        // Auto-calculate IMT if berat and tinggi provided
        if ($model->antro_berat && $model->antro_tinggi && $model->antro_tinggi > 0) {
            $tinggiMeter = $model->antro_tinggi / 100;
            $model->antro_imt = round($model->antro_berat / ($tinggiMeter * $tinggiMeter), 2);
        }
    }

    /**
     * Lihat form data medis
     */
    public function actionViewForm($id)
    {
        $model = $this->findDataFormModel($id);
        return $this->render('view-form', [
            'model' => $model,
        ]);
    }

    /**
     * Print form medis
     */
    public function actionPrintForm($id)
    {
        $model = $this->findDataFormModel($id);

        // Set layout khusus untuk print
        $this->layout = 'print';

        return $this->render('print-form', [
            'model' => $model,
        ]);
    }

    /**
     * Ajax untuk hitung IMT
     */
    public function actionHitungImt()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $berat = (float) Yii::$app->request->post('berat');
        $tinggi = (float) Yii::$app->request->post('tinggi');

        if ($berat > 0 && $tinggi > 0) {
            $tinggi_meter = $tinggi / 100;
            $imt = round($berat / ($tinggi_meter * $tinggi_meter), 2);

            // Tentukan kategori IMT
            $kategori = '';
            if ($imt < 18.5) {
                $kategori = 'Kurang Berat Badan';
            } elseif ($imt < 25) {
                $kategori = 'Normal';
            } elseif ($imt < 27) {
                $kategori = 'Gemuk';
            } else {
                $kategori = 'Obesitas';
            }

            return [
                'success' => true,
                'imt' => $imt,
                'kategori' => $kategori
            ];
        }

        return ['success' => false];
    }

    /**
     * Cari model registrasi
     */
    protected function findModel($id)
    {
        if (($model = Registrasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak ditemukan.');
    }

    /**
     * Cari model data form
     */
    protected function findDataFormModel($id)
    {
        if (($model = DataForm::findOne(['id_form_data' => $id, 'is_delete' => false])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data form yang diminta tidak ditemukan.');
    }
}
