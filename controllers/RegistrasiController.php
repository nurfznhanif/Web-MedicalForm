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
     * Hapus registrasi
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Data registrasi berhasil dihapus.');

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data form medis berhasil disimpan.');
            return $this->redirect(['view-form', 'id' => $model->id_form_data]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data form medis berhasil diupdate.');
            return $this->redirect(['view-form', 'id' => $model->id_form_data]);
        }

        return $this->render('edit-form', [
            'model' => $model,
            'registrasi' => $registrasi,
        ]);
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
     * Hapus form data medis
     */
    public function actionDeleteForm($id)
    {
        $model = $this->findDataFormModel($id);
        $id_registrasi = $model->id_registrasi;

        $model->is_delete = true;
        $model->save();

        Yii::$app->session->setFlash('success', 'Data form medis berhasil dihapus.');
        return $this->redirect(['view', 'id' => $id_registrasi]);
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
                $kategori = 'Underweight';
            } elseif ($imt < 25) {
                $kategori = 'Normal';
            } elseif ($imt < 30) {
                $kategori = 'Overweight';
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
