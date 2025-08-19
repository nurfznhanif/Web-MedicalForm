<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Model untuk tabel "data_form".
 *
 * @property int $id_form_data
 * @property int|null $id_form
 * @property int|null $id_registrasi
 * @property array $data
 * @property bool|null $is_delete
 * @property int|null $create_by
 * @property int|null $update_by
 * @property string|null $create_time_at
 * @property string|null $update_time_at
 */
class DataForm extends ActiveRecord
{
    // Properties untuk form input
    public $tanggal_pengkajian;
    public $jam_pengkajian;
    public $poliklinik;
    public $cara_masuk;
    public $anamnesis;
    public $alergi;
    public $keluhan_utama;
    public $keadaan_umum;
    public $warna_kulit;
    public $kesadaran;
    public $tanda_vital_td;
    public $tanda_vital_p;
    public $tanda_vital_n;
    public $tanda_vital_s;
    public $fungsi_alat_bantu;
    public $fungsi_prothesa;
    public $fungsi_cacat_tubuh;
    public $fungsi_adl;
    public $antro_berat;
    public $antro_tinggi;
    public $antro_lingkar;
    public $antro_imt;
    public $status_gizi;
    public $riwayat_penyakit_sekarang;
    public $riwayat_penyakit_sebelumnya;
    public $riwayat_penyakit_keluarga;
    public $riwayat_operasi;
    public $riwayat_pernah_dirawat;
    public $resiko_jatuh_items = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_form';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time_at',
                'updatedAtAttribute' => 'update_time_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_form', 'id_registrasi', 'create_by', 'update_by'], 'integer'],
            [['data'], 'safe'],
            [['is_delete'], 'boolean'],
            [['create_time_at', 'update_time_at'], 'safe'],
            // Rules untuk form properties
            [['tanggal_pengkajian', 'jam_pengkajian', 'poliklinik'], 'safe'],
            [['cara_masuk', 'anamnesis', 'alergi', 'keluhan_utama'], 'safe'],
            [['keadaan_umum', 'warna_kulit', 'kesadaran'], 'safe'],
            [['tanda_vital_td', 'tanda_vital_p', 'tanda_vital_n', 'tanda_vital_s'], 'safe'],
            [['antro_berat', 'antro_tinggi', 'antro_lingkar'], 'number'],
            [['resiko_jatuh_items'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_form_data' => 'ID Form Data',
            'id_form' => 'ID Form',
            'id_registrasi' => 'ID Registrasi',
            'data' => 'Data',
            'is_delete' => 'Is Delete',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'create_time_at' => 'Create Time At',
            'update_time_at' => 'Update Time At',
            'tanggal_pengkajian' => 'Tanggal Pengkajian',
            'jam_pengkajian' => 'Jam Pengkajian',
            'poliklinik' => 'Poliklinik',
        ];
    }

    /**
     * Sebelum simpan, convert form data ke JSON
     */
    public function beforeSave($insert)
    {
        if ($insert || $this->isAttributeChanged('tanggal_pengkajian')) {
            $this->data = $this->prepareFormData();
        }
        return parent::beforeSave($insert);
    }

    /**
     * Setelah find, load data dari JSON ke properties
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->loadFormData();
    }

    /**
     * Prepare form data untuk disimpan ke JSON
     */
    private function prepareFormData()
    {
        // Hitung IMT otomatis
        if ($this->antro_berat && $this->antro_tinggi) {
            $tinggi_meter = $this->antro_tinggi / 100;
            $this->antro_imt = round($this->antro_berat / ($tinggi_meter * $tinggi_meter), 2);
        }

        return [
            'tanggal_pengkajian' => $this->tanggal_pengkajian,
            'jam_pengkajian' => $this->jam_pengkajian,
            'poliklinik' => $this->poliklinik,
            'cara_masuk' => $this->cara_masuk,
            'anamnesis' => $this->anamnesis,
            'alergi' => $this->alergi,
            'keluhan_utama' => $this->keluhan_utama,
            'pemeriksaan_fisik' => [
                'keadaan_umum' => $this->keadaan_umum,
                'warna_kulit' => $this->warna_kulit,
                'kesadaran' => $this->kesadaran,
                'tanda_vital' => [
                    'td' => $this->tanda_vital_td,
                    'p' => $this->tanda_vital_p,
                    'n' => $this->tanda_vital_n,
                    's' => $this->tanda_vital_s,
                ],
                'fungsional' => [
                    'alat_bantu' => $this->fungsi_alat_bantu,
                    'prothesa' => $this->fungsi_prothesa,
                    'cacat_tubuh' => $this->fungsi_cacat_tubuh,
                    'adl' => $this->fungsi_adl,
                ],
                'antropometri' => [
                    'berat' => $this->antro_berat,
                    'tinggi' => $this->antro_tinggi,
                    'lingkar' => $this->antro_lingkar,
                    'imt' => $this->antro_imt,
                ],
            ],
            'status_gizi' => $this->status_gizi,
            'riwayat_penyakit' => [
                'sekarang' => $this->riwayat_penyakit_sekarang,
                'sebelumnya' => $this->riwayat_penyakit_sebelumnya,
                'keluarga' => $this->riwayat_penyakit_keluarga,
            ],
            'riwayat_operasi' => $this->riwayat_operasi,
            'riwayat_pernah_dirawat' => $this->riwayat_pernah_dirawat,
            'resiko_jatuh' => $this->resiko_jatuh_items,
        ];
    }

    /**
     * Load data dari JSON ke form properties
     */
    private function loadFormData()
    {
        if (!empty($this->data)) {
            $data = is_string($this->data) ? json_decode($this->data, true) : $this->data;

            $this->tanggal_pengkajian = $data['tanggal_pengkajian'] ?? '';
            $this->jam_pengkajian = $data['jam_pengkajian'] ?? '';
            $this->poliklinik = $data['poliklinik'] ?? '';
            $this->cara_masuk = $data['cara_masuk'] ?? '';
            $this->anamnesis = $data['anamnesis'] ?? '';
            $this->alergi = $data['alergi'] ?? '';
            $this->keluhan_utama = $data['keluhan_utama'] ?? '';

            // Pemeriksaan fisik
            $fisik = $data['pemeriksaan_fisik'] ?? [];
            $this->keadaan_umum = $fisik['keadaan_umum'] ?? '';
            $this->warna_kulit = $fisik['warna_kulit'] ?? '';
            $this->kesadaran = $fisik['kesadaran'] ?? '';

            // Tanda vital
            $vital = $fisik['tanda_vital'] ?? [];
            $this->tanda_vital_td = $vital['td'] ?? '';
            $this->tanda_vital_p = $vital['p'] ?? '';
            $this->tanda_vital_n = $vital['n'] ?? '';
            $this->tanda_vital_s = $vital['s'] ?? '';

            // Fungsional
            $fungsional = $fisik['fungsional'] ?? [];
            $this->fungsi_alat_bantu = $fungsional['alat_bantu'] ?? '';
            $this->fungsi_prothesa = $fungsional['prothesa'] ?? '';
            $this->fungsi_cacat_tubuh = $fungsional['cacat_tubuh'] ?? '';
            $this->fungsi_adl = $fungsional['adl'] ?? '';

            // Antropometri
            $antro = $fisik['antropometri'] ?? [];
            $this->antro_berat = $antro['berat'] ?? '';
            $this->antro_tinggi = $antro['tinggi'] ?? '';
            $this->antro_lingkar = $antro['lingkar'] ?? '';
            $this->antro_imt = $antro['imt'] ?? '';

            $this->status_gizi = $data['status_gizi'] ?? '';

            // Riwayat penyakit
            $riwayat = $data['riwayat_penyakit'] ?? [];
            $this->riwayat_penyakit_sekarang = $riwayat['sekarang'] ?? '';
            $this->riwayat_penyakit_sebelumnya = $riwayat['sebelumnya'] ?? '';
            $this->riwayat_penyakit_keluarga = $riwayat['keluarga'] ?? '';

            $this->riwayat_operasi = $data['riwayat_operasi'] ?? '';
            $this->riwayat_pernah_dirawat = $data['riwayat_pernah_dirawat'] ?? '';
            $this->resiko_jatuh_items = $data['resiko_jatuh'] ?? [];
        }
    }

    /**
     * Relasi dengan registrasi
     */
    public function getRegistrasi()
    {
        return $this->hasOne(Registrasi::class, ['id_registrasi' => 'id_registrasi']);
    }

    /**
     * Hitung total skor resiko jatuh
     */
    public function getTotalResikoJatuh()
    {
        $total = 0;
        if (is_array($this->resiko_jatuh_items)) {
            foreach ($this->resiko_jatuh_items as $item) {
                $total += (int) ($item['hasil'] ?? 0);
            }
        }
        return $total;
    }

    /**
     * Kategori resiko jatuh berdasarkan total skor
     */
    public function getKategoriResikoJatuh()
    {
        $total = $this->getTotalResikoJatuh();
        if ($total >= 0 && $total <= 24) {
            return 'Tidak beresiko';
        } elseif ($total >= 25 && $total <= 44) {
            return 'Resiko rendah';
        } else {
            return 'Resiko tinggi';
        }
    }
}
