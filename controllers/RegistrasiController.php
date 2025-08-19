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
            'isEdit' => false
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

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data form medis berhasil diupdate.');
                return $this->redirect(['view-form', 'id' => $model->id_form_data]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal mengupdate data: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        // Load existing data into model properties for form
        $this->loadExistingDataToModel($model);

        return $this->render('edit-form', [
            'model' => $model,
            'registrasi' => $registrasi,
            'isEdit' => true
        ]);
    }

    /**
     * Load existing data to model properties for editing
     */
    private function loadExistingDataToModel($model)
    {
        $data = $model->getDisplayData();

        if (!empty($data)) {
            // Basic info
            $model->tanggal_pengkajian = $data['tanggal_pengkajian'] ?? '';
            $model->jam_pengkajian = $data['jam_pengkajian'] ?? '';
            $model->poliklinik = $data['poliklinik'] ?? '';

            // Pengkajian saat datang
            $model->cara_masuk = $data['cara_masuk'] ?? '';
            $model->anamnesis = $data['anamnesis'] ?? '';
            $model->anamnesis_diperoleh = $data['anamnesis_detail']['diperoleh'] ?? '';
            $model->anamnesis_hubungan = $data['anamnesis_detail']['hubungan'] ?? '';
            $model->alergi = $data['alergi'] ?? '';
            $model->keluhan_utama = $data['keluhan_utama'] ?? '';

            // Pemeriksaan fisik
            $fisik = $data['pemeriksaan_fisik'] ?? [];
            $model->keadaan_umum = $fisik['keadaan_umum'] ?? '';
            $model->warna_kulit = $fisik['warna_kulit'] ?? '';
            $model->kesadaran = $fisik['kesadaran'] ?? '';

            // Tanda vital
            $vital = $fisik['tanda_vital'] ?? [];
            $model->tanda_vital_td = $vital['td'] ?? '';
            $model->tanda_vital_p = $vital['p'] ?? '';
            $model->tanda_vital_n = $vital['n'] ?? '';
            $model->tanda_vital_s = $vital['s'] ?? '';

            // Fungsional
            $fungsional = $fisik['fungsional'] ?? [];
            $model->fungsi_alat_bantu = $fungsional['alat_bantu'] ?? '';
            $model->fungsi_prothesa = $fungsional['prothesa'] ?? '';
            $model->fungsi_cacat_tubuh = $fungsional['cacat_tubuh'] ?? '';
            $model->fungsi_adl = $fungsional['adl'] ?? '';
            $model->riwayat_jatuh_fungsional = $fungsional['riwayat_jatuh'] ?? '';

            // Antropometri
            $antro = $fisik['antropometri'] ?? [];
            $model->antro_berat = $antro['berat'] ?? '';
            $model->antro_tinggi = $antro['tinggi'] ?? '';
            $model->antro_lingkar = $antro['lingkar'] ?? '';
            $model->antro_imt = $antro['imt'] ?? '';

            $model->status_gizi = $data['status_gizi'] ?? '';

            // Riwayat penyakit
            $riwayat = $data['riwayat_penyakit'] ?? [];
            $model->riwayat_penyakit_sekarang = $riwayat['sekarang'] ?? '';
            $model->riwayat_penyakit_sebelumnya = $riwayat['sebelumnya'] ?? '';
            $model->riwayat_penyakit_keluarga = $riwayat['keluarga'] ?? '';

            // Riwayat operasi dan rawat inap
            $model->riwayat_operasi = $data['riwayat_operasi'] ?? '';
            $operasiDetail = $data['operasi_detail'] ?? [];
            $model->operasi_detail_apa = $operasiDetail['apa'] ?? '';
            $model->operasi_detail_kapan = $operasiDetail['kapan'] ?? '';

            $model->riwayat_pernah_dirawat = $data['riwayat_pernah_dirawat'] ?? '';
            $dirawatDetail = $data['dirawat_detail'] ?? [];
            $model->dirawat_detail_penyakit = $dirawatDetail['penyakit'] ?? '';
            $model->dirawat_detail_kapan = $dirawatDetail['kapan'] ?? '';

            // Load resiko jatuh untuk edit
            $resikoJatuh = $data['resiko_jatuh'] ?? [];
            $resikoItems = [];
            if (!empty($resikoJatuh)) {
                foreach ($resikoJatuh as $index => $item) {
                    $resikoItems['risk' . ($index + 1)] = (int)($item['hasil'] ?? 0);
                }
            }
            $model->resiko_jatuh_items = $resikoItems;
            $model->total_resiko_jatuh = $data['total_resiko_jatuh'] ?? 0;
            $model->kategori_resiko_jatuh = $data['kategori_resiko_jatuh'] ?? '';
        }
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
                if ($model->hasAttribute($key) || property_exists($model, $key)) {
                    $model->$key = $value;
                }
            }
        }

        // Process additional fields
        if (isset($postData['diperoleh'])) {
            $model->anamnesis_diperoleh = $postData['diperoleh'];
        }
        if (isset($postData['hubungan'])) {
            $model->anamnesis_hubungan = $postData['hubungan'];
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
        for ($i = 1; $i <= 6; $i++) {
            if (isset($postData["risk{$i}"])) {
                $riskData["risk{$i}"] = (int)$postData["risk{$i}"];
            }
        }

        // Set resiko jatuh items
        $model->resiko_jatuh_items = $riskData;

        // Process hidden risk data if available
        if (isset($postData['DataForm']['total_resiko_jatuh'])) {
            $model->total_resiko_jatuh = (int)$postData['DataForm']['total_resiko_jatuh'];
        }
        if (isset($postData['DataForm']['kategori_resiko_jatuh'])) {
            $model->kategori_resiko_jatuh = $postData['DataForm']['kategori_resiko_jatuh'];
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
