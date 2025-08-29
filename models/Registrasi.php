<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Model untuk tabel "registrasi" dengan validasi NIK unik.
 *
 * @property int $id_registrasi
 * @property string $no_registrasi
 * @property string|null $no_rekam_medis
 * @property string $nama_pasien
 * @property string|null $tanggal_lahir
 * @property string|null $nik
 * @property int|null $create_by
 * @property string|null $create_time_at
 * @property int|null $update_by
 * @property string|null $update_time_at
 */
class Registrasi extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registrasi';
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
            [['nama_pasien'], 'required'],
            [['tanggal_lahir', 'create_time_at', 'update_time_at'], 'safe'],
            [['create_by', 'update_by'], 'integer'],
            [['no_registrasi', 'no_rekam_medis', 'nik'], 'string', 'max' => 64],
            [['nama_pasien'], 'string', 'max' => 255],

            // VALIDASI NIK UNIK - SOLUSI UTAMA
            [['nik'], 'string', 'length' => 16, 'message' => 'NIK harus 16 digit'],
            [['nik'], 'match', 'pattern' => '/^[0-9]{16}$/', 'message' => 'NIK harus berupa 16 digit angka'],
            [['nik'], 'unique', 'message' => 'NIK sudah terdaftar dalam sistem. Silakan periksa kembali.'],
            [['nik'], 'validateNikUnique'], // Custom validator tambahan
        ];
    }

    /**
     * Custom validator untuk NIK unik dengan pesan lebih informatif
     */
    public function validateNikUnique($attribute, $params)
    {
        if (empty($this->$attribute)) {
            return; // Skip jika NIK kosong
        }

        // Query untuk cek NIK sudah ada atau belum
        $query = static::find()->where(['nik' => $this->$attribute]);

        // Jika ini adalah update, exclude record yang sedang di-edit
        if (!$this->isNewRecord) {
            $query->andWhere(['!=', 'id_registrasi', $this->id_registrasi]);
        }

        $existingRecord = $query->one();

        if ($existingRecord) {
            // Berikan informasi lebih detail tentang NIK yang sudah terdaftar
            $this->addError($attribute, "NIK {$this->$attribute} sudah terdaftar atas nama: {$existingRecord->nama_pasien} (No. Reg: {$existingRecord->no_registrasi})");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_registrasi' => 'ID Registrasi',
            'no_registrasi' => 'No. Registrasi',
            'no_rekam_medis' => 'No. Rekam Medis',
            'nama_pasien' => 'Nama Pasien',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nik' => 'NIK',
            'create_by' => 'Dibuat Oleh',
            'create_time_at' => 'Tanggal Dibuat',
            'update_by' => 'Diupdate Oleh',
            'update_time_at' => 'Tanggal Update',
        ];
    }

    /**
     * Generate nomor registrasi otomatis
     */
    public function beforeSave($insert)
    {
        if ($insert && empty($this->no_registrasi)) {
            $this->no_registrasi = $this->generateNoRegistrasi();
        }

        if (empty($this->no_rekam_medis)) {
            $this->no_rekam_medis = $this->generateNoRekamMedis();
        }

        return parent::beforeSave($insert);
    }

    /**
     * Generate nomor registrasi
     */
    private function generateNoRegistrasi()
    {
        $prefix = 'REG';
        $date = date('Ymd');

        // Gunakan raw SQL untuk menghindari masalah tipe data PostgreSQL
        $sql = "SELECT no_registrasi FROM registrasi WHERE no_registrasi::text LIKE :pattern ORDER BY id_registrasi DESC LIMIT 1";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(':pattern', $prefix . $date . '%');
        $lastRecord = $command->queryScalar();

        if ($lastRecord) {
            // Extract nomor urut dari nomor registrasi terakhir
            $lastNumber = (int) substr($lastRecord, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $date . $newNumber;
    }

    /**
     * Generate nomor rekam medis
     */
    private function generateNoRekamMedis()
    {
        $prefix = 'RM';
        $year = date('y');

        $sql = "SELECT no_rekam_medis FROM registrasi WHERE no_rekam_medis::text LIKE :pattern ORDER BY id_registrasi DESC LIMIT 1";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(':pattern', $prefix . $year . '%');
        $lastRecord = $command->queryScalar();

        if ($lastRecord) {
            $lastNumber = (int) substr($lastRecord, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $year . $newNumber;
    }

    /**
     * Static method untuk cek NIK sudah ada atau belum (untuk AJAX)
     */
    public static function isNikExists($nik, $excludeId = null)
    {
        $query = static::find()->where(['nik' => $nik]);

        if ($excludeId) {
            $query->andWhere(['!=', 'id_registrasi', $excludeId]);
        }

        return $query->exists();
    }

    /**
     * Get registrasi by NIK
     */
    public static function getByNik($nik)
    {
        return static::findOne(['nik' => $nik]);
    }
}
