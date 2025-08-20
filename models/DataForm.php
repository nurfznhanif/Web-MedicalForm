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
    // Properties untuk form input - Basic Info
    public $tanggal_pengkajian;
    public $jam_pengkajian;
    public $poliklinik;

    // Pengkajian saat datang
    public $cara_masuk;
    public $anamnesis;
    public $anamnesis_diperoleh;
    public $anamnesis_hubungan;
    public $alergi;
    public $keluhan_utama;

    // Pemeriksaan fisik
    public $keadaan_umum;
    public $warna_kulit;
    public $kesadaran;
    public $tanda_vital_td;
    public $tanda_vital_p;
    public $tanda_vital_n;
    public $tanda_vital_s;

    // Fungsional
    public $fungsi_alat_bantu;
    public $fungsi_prothesa;
    public $fungsi_cacat_tubuh;
    public $fungsi_adl;
    public $riwayat_jatuh_fungsional;

    // Antropometri
    public $antro_berat;
    public $antro_tinggi;
    public $antro_panjang;
    public $antro_lingkar;
    public $antro_imt;

    // Status gizi
    public $status_gizi;

    // Riwayat penyakit
    public $riwayat_penyakit_sekarang;
    public $riwayat_penyakit_sebelumnya;
    public $riwayat_penyakit_keluarga;

    // Riwayat operasi dan rawat inap
    public $riwayat_operasi;
    public $operasi_detail_apa;
    public $operasi_detail_kapan;
    public $riwayat_pernah_dirawat;
    public $dirawat_detail_penyakit;
    public $dirawat_detail_kapan;

    // Resiko jatuh
    public $resiko_jatuh_items = [];
    public $total_resiko_jatuh;
    public $kategori_resiko_jatuh;

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

            // Rules untuk form properties - Required fields
            [['tanggal_pengkajian', 'jam_pengkajian', 'poliklinik'], 'required'],

            // Safe attributes untuk semua field form
            [['cara_masuk', 'anamnesis', 'anamnesis_diperoleh', 'anamnesis_hubungan', 'alergi', 'keluhan_utama'], 'safe'],
            [['keadaan_umum', 'warna_kulit', 'kesadaran'], 'safe'],
            [['tanda_vital_td', 'tanda_vital_p', 'tanda_vital_n', 'tanda_vital_s'], 'safe'],
            [['fungsi_alat_bantu', 'fungsi_prothesa', 'fungsi_cacat_tubuh', 'fungsi_adl', 'riwayat_jatuh_fungsional'], 'safe'],
            [['antro_berat', 'antro_tinggi', 'antro_lingkar', 'antro_panjang'], 'number'],
            [['antro_imt'], 'number'],
            [['status_gizi'], 'safe'],
            [['riwayat_penyakit_sekarang', 'riwayat_penyakit_sebelumnya', 'riwayat_penyakit_keluarga'], 'safe'],
            [['riwayat_operasi', 'operasi_detail_apa', 'operasi_detail_kapan'], 'safe'],
            [['riwayat_pernah_dirawat', 'dirawat_detail_penyakit', 'dirawat_detail_kapan'], 'safe'],
            [['resiko_jatuh_items', 'total_resiko_jatuh', 'kategori_resiko_jatuh'], 'safe'],
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
            'cara_masuk' => 'Cara Masuk',
            'anamnesis' => 'Anamnesis',
            'alergi' => 'Alergi',
            'keluhan_utama' => 'Keluhan Utama',
            'keadaan_umum' => 'Keadaan Umum',
            'warna_kulit' => 'Warna Kulit',
            'kesadaran' => 'Kesadaran',
            'antro_berat' => 'Berat Badan (Kg)',
            'antro_tinggi' => 'Tinggi Badan (Cm)',
            'antro_panjang' => 'Panjang Badan (Cm)',
            'antro_lingkar' => 'Lingkar Kepala (Cm)',
            'antro_imt' => 'IMT',
            'status_gizi' => 'Status Gizi',
        ];
    }

    /**
     * Sebelum simpan, convert form data ke JSON
     */
    public function beforeSave($insert)
    {
        $this->data = $this->prepareFormDataForSave();
        return parent::beforeSave($insert);
    }

    /**
     * Setelah find, load data dari JSON ke properties
     */
    public function afterFind()
    {
        parent::afterFind();
        if (!empty($this->data)) {
            try {
                $this->loadFormData();
            } catch (\Exception $e) {
                // Log error
                Yii::error("Error loading form data for ID {$this->id_form_data}: " . $e->getMessage());
                // Set default values jika terjadi error
                $this->setDefaultValues();
            }
        }
    }

    /**
     * Set default values untuk menghindari error
     */
    private function setDefaultValues()
    {
        $this->tanggal_pengkajian = '';
        $this->jam_pengkajian = '';
        $this->poliklinik = '';
        $this->cara_masuk = '';
        $this->anamnesis = '';
        $this->alergi = '';
        $this->keluhan_utama = '';
        $this->resiko_jatuh_items = [];
        $this->total_resiko_jatuh = 0;
        $this->kategori_resiko_jatuh = '';
    }

    /**
     * Prepare form data untuk disimpan ke JSON
     */
    public function prepareFormDataForSave()
    {
        // Hitung IMT otomatis
        if ($this->antro_berat && $this->antro_tinggi && !$this->antro_imt) {
            $tinggi_meter = $this->antro_tinggi / 100;
            $this->antro_imt = round($this->antro_berat / ($tinggi_meter * $tinggi_meter), 2);
        }

        // Prepare resiko jatuh data dengan struktur yang benar
        $resikoJatuhArray = [];
        $totalResikoJatuh = 0;

        $resikoLabels = [
            1 => 'Riwayat jatuh yang baru atau dalam 3 bulan terakhir',
            2 => 'Diagnosa medis sekunder > 1',
            3 => 'Alat bantu jalan',
            4 => 'Ad akses IV atau terapi heparin lock',
            5 => 'Cara berjalan/berpindah',
            6 => 'Status mental'
        ];

        if (!is_array($this->resiko_jatuh_items)) {
            $this->resiko_jatuh_items = [];
        }

        // Process risk items
        for ($i = 1; $i <= 6; $i++) {
            $riskKey = 'risk' . $i;
            $hasil = 0;

            // Cek dari berbagai sumber data
            if (isset($this->resiko_jatuh_items[$riskKey])) {
                $hasil = (int)$this->resiko_jatuh_items[$riskKey];
            } elseif (isset($_POST[$riskKey])) {
                // Ambil dari POST data jika ada
                $hasil = (int)$_POST[$riskKey];
                $this->resiko_jatuh_items[$riskKey] = $hasil;
            }

            $totalResikoJatuh += $hasil;

            $resikoJatuhArray[] = [
                'resiko' => $resikoLabels[$i],
                'hasil' => $hasil
            ];
        }

        // Set total dari perhitungan atau dari property yang sudah di-set
        if ($this->total_resiko_jatuh && is_numeric($this->total_resiko_jatuh)) {
            $totalResikoJatuh = (int)$this->total_resiko_jatuh;
        } else {
            $this->total_resiko_jatuh = $totalResikoJatuh;
        }

        // Kategori resiko jatuh
        if ($totalResikoJatuh <= 24) {
            $this->kategori_resiko_jatuh = 'Tidak berisiko (0-24)';
        } elseif ($totalResikoJatuh <= 44) {
            $this->kategori_resiko_jatuh = 'Resiko rendah (25-44)';
        } else {
            $this->kategori_resiko_jatuh = 'Resiko tinggi (≥45)';
        }

        return [
            // Basic info
            'tanggal_pengkajian' => $this->tanggal_pengkajian ?: '',
            'jam_pengkajian' => $this->jam_pengkajian ?: '',
            'poliklinik' => $this->poliklinik ?: '',

            // Pengkajian saat datang
            'cara_masuk' => $this->cara_masuk ?: '',
            'anamnesis' => $this->anamnesis ?: '',
            'anamnesis_detail' => [
                'diperoleh' => $this->anamnesis_diperoleh ?: '',
                'hubungan' => $this->anamnesis_hubungan ?: '',
            ],
            'alergi' => $this->alergi ?: '',
            'keluhan_utama' => $this->keluhan_utama ?: '',

            // Pemeriksaan fisik
            'pemeriksaan_fisik' => [
                'keadaan_umum' => $this->keadaan_umum ?: '',
                'warna_kulit' => $this->warna_kulit ?: '',
                'kesadaran' => $this->kesadaran ?: '',
                'tanda_vital' => [
                    'td' => $this->tanda_vital_td ?: '',
                    'p' => $this->tanda_vital_p ?: '',
                    'n' => $this->tanda_vital_n ?: '',
                    's' => $this->tanda_vital_s ?: '',
                ],
                'fungsional' => [
                    'alat_bantu' => $this->fungsi_alat_bantu ?: '',
                    'prothesa' => $this->fungsi_prothesa ?: '',
                    'cacat_tubuh' => $this->fungsi_cacat_tubuh ?: '',
                    'adl' => $this->fungsi_adl ?: '',
                    'riwayat_jatuh' => $this->riwayat_jatuh_fungsional ?: '',
                ],
                'antropometri' => [
                    'berat' => $this->antro_berat ?: '',
                    'tinggi' => $this->antro_tinggi ?: '',
                    'lingkar' => $this->antro_lingkar ?: '',
                    'panjang' => $this->antro_panjang ?: '',
                    'imt' => $this->antro_imt ?: '',
                ],
            ],
            'status_gizi' => $this->status_gizi ?: '',

            // Riwayat penyakit
            'riwayat_penyakit' => [
                'sekarang' => $this->riwayat_penyakit_sekarang ?: '',
                'sebelumnya' => $this->riwayat_penyakit_sebelumnya ?: '',
                'keluarga' => $this->riwayat_penyakit_keluarga ?: '',
            ],

            // Riwayat operasi dan rawat inap
            'riwayat_operasi' => $this->riwayat_operasi ?: '',
            'operasi_detail' => [
                'apa' => $this->operasi_detail_apa ?: '',
                'kapan' => $this->operasi_detail_kapan ?: '',
            ],
            'riwayat_pernah_dirawat' => $this->riwayat_pernah_dirawat ?: '',
            'dirawat_detail' => [
                'penyakit' => $this->dirawat_detail_penyakit ?: '',
                'kapan' => $this->dirawat_detail_kapan ?: '',
            ],

            // Resiko jatuh 
            'resiko_jatuh' => $resikoJatuhArray,
            'resiko_jatuh_items' => $this->resiko_jatuh_items,
            'total_resiko_jatuh' => $this->total_resiko_jatuh ?: 0,
            'kategori_resiko_jatuh' => $this->kategori_resiko_jatuh ?: '',
        ];
    }

    /**
     * Load data dari JSON ke form properties
     */
    private function loadFormData()
    {
        if (empty($this->data)) {
            return;
        }

        $data = is_string($this->data) ? json_decode($this->data, true) : $this->data;

        if (!is_array($data)) {
            return;
        }

        // Basic info
        $this->tanggal_pengkajian = $data['tanggal_pengkajian'] ?? '';
        $this->jam_pengkajian = $data['jam_pengkajian'] ?? '';
        $this->poliklinik = $data['poliklinik'] ?? '';

        // Pengkajian saat datang
        $this->cara_masuk = $data['cara_masuk'] ?? '';
        $this->anamnesis = $data['anamnesis'] ?? '';

        // Safe access untuk anamnesis_detail
        $anamnesisDetail = $data['anamnesis_detail'] ?? [];
        if (is_array($anamnesisDetail)) {
            $this->anamnesis_diperoleh = $anamnesisDetail['diperoleh'] ?? '';
            $this->anamnesis_hubungan = $anamnesisDetail['hubungan'] ?? '';
        }

        $this->alergi = $data['alergi'] ?? '';
        $this->keluhan_utama = $data['keluhan_utama'] ?? '';

        // Pemeriksaan fisik
        $fisik = $data['pemeriksaan_fisik'] ?? [];
        if (is_array($fisik)) {
            $this->keadaan_umum = $fisik['keadaan_umum'] ?? '';
            $this->warna_kulit = $fisik['warna_kulit'] ?? '';
            $this->kesadaran = $fisik['kesadaran'] ?? '';

            // Tanda vital
            $vital = $fisik['tanda_vital'] ?? [];
            if (is_array($vital)) {
                $this->tanda_vital_td = $vital['td'] ?? '';
                $this->tanda_vital_p = $vital['p'] ?? '';
                $this->tanda_vital_n = $vital['n'] ?? '';
                $this->tanda_vital_s = $vital['s'] ?? '';
            }

            // Fungsional
            $fungsional = $fisik['fungsional'] ?? [];
            if (is_array($fungsional)) {
                $this->fungsi_alat_bantu = $fungsional['alat_bantu'] ?? '';
                $this->fungsi_prothesa = $fungsional['prothesa'] ?? '';
                $this->fungsi_cacat_tubuh = $fungsional['cacat_tubuh'] ?? '';
                $this->fungsi_adl = $fungsional['adl'] ?? '';
                $this->riwayat_jatuh_fungsional = $fungsional['riwayat_jatuh'] ?? '';
            }

            // Antropometri
            $antro = $fisik['antropometri'] ?? [];
            if (is_array($antro)) {
                $this->antro_berat = $antro['berat'] ?? '';
                $this->antro_tinggi = $antro['tinggi'] ?? '';
                $this->antro_lingkar = $antro['lingkar'] ?? '';
                $this->antro_panjang = $antro['panjang'] ?? '';
                $this->antro_imt = $antro['imt'] ?? '';
            }
        }

        $this->status_gizi = $data['status_gizi'] ?? '';

        // Riwayat penyakit
        $riwayat = $data['riwayat_penyakit'] ?? [];
        if (is_array($riwayat)) {
            $this->riwayat_penyakit_sekarang = $riwayat['sekarang'] ?? '';
            $this->riwayat_penyakit_sebelumnya = $riwayat['sebelumnya'] ?? '';
            $this->riwayat_penyakit_keluarga = $riwayat['keluarga'] ?? '';
        }

        // Riwayat operasi dan rawat inap
        $this->riwayat_operasi = $data['riwayat_operasi'] ?? '';

        $operasiDetail = $data['operasi_detail'] ?? [];
        if (is_array($operasiDetail)) {
            $this->operasi_detail_apa = $operasiDetail['apa'] ?? '';
            $this->operasi_detail_kapan = $operasiDetail['kapan'] ?? '';
        }

        $this->riwayat_pernah_dirawat = $data['riwayat_pernah_dirawat'] ?? '';

        $dirawatDetail = $data['dirawat_detail'] ?? [];
        if (is_array($dirawatDetail)) {
            $this->dirawat_detail_penyakit = $dirawatDetail['penyakit'] ?? '';
            $this->dirawat_detail_kapan = $dirawatDetail['kapan'] ?? '';
        }

        // Resiko jatuh dengan multiple sources
        $this->total_resiko_jatuh = is_numeric($data['total_resiko_jatuh'] ?? 0) ? (int)$data['total_resiko_jatuh'] : 0;
        $this->kategori_resiko_jatuh = $data['kategori_resiko_jatuh'] ?? '';

        // Load resiko jatuh items dengan prioritas
        $riskItems = [];

        // Prioritas 1: Dari resiko_jatuh_items langsung
        if (isset($data['resiko_jatuh_items']) && is_array($data['resiko_jatuh_items'])) {
            $riskItems = $data['resiko_jatuh_items'];
        }
        // Prioritas 2: Dari array resiko_jatuh
        elseif (isset($data['resiko_jatuh']) && is_array($data['resiko_jatuh'])) {
            foreach ($data['resiko_jatuh'] as $index => $item) {
                if (is_array($item) && isset($item['hasil'])) {
                    $riskKey = 'risk' . ($index + 1);
                    $riskItems[$riskKey] = is_numeric($item['hasil']) ? (int)$item['hasil'] : 0;
                }
            }
        }

        $this->resiko_jatuh_items = $riskItems;
    }

    /**
     * Force reload data
     */
    public function forceReloadData()
    {
        $this->loadFormData();
        return $this;
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
        if (is_numeric($this->total_resiko_jatuh)) {
            return (int)$this->total_resiko_jatuh;
        }

        $total = 0;
        if (is_array($this->resiko_jatuh_items)) {
            foreach ($this->resiko_jatuh_items as $item) {
                if (is_numeric($item)) {
                    $total += (int)$item;
                }
            }
        }
        return $total;
    }

    /**
     * Kategori resiko jatuh berdasarkan total skor
     */
    public function getKategoriResikoJatuh()
    {
        if (!empty($this->kategori_resiko_jatuh)) {
            return $this->kategori_resiko_jatuh;
        }

        $total = $this->getTotalResikoJatuh();
        if ($total >= 0 && $total <= 24) {
            return 'Tidak berisiko (0-24)';
        } elseif ($total >= 25 && $total <= 44) {
            return 'Resiko rendah (25-44)';
        } else {
            return 'Resiko tinggi (≥45)';
        }
    }

    /**
     * Get formatted display data for views
     */
    public function getDisplayData()
    {
        if (empty($this->data)) {
            return [];
        }

        try {
            $data = is_string($this->data) ? json_decode($this->data, true) : $this->data;
            return is_array($data) ? $data : [];
        } catch (\Exception $e) {
            Yii::error("Error getting display data for ID {$this->id_form_data}: " . $e->getMessage());
            return [];
        }
    }
}
