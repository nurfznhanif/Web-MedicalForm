<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Model untuk tabel "registrasi".
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
        ];
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
        $lastNo = $command->queryScalar();

        if ($lastNo) {
            $lastNumber = (int) substr($lastNo, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . sprintf('%04d', $newNumber);
    }

    /**
     * Generate nomor rekam medis
     */
    private function generateNoRekamMedis()
    {
        $prefix = 'RM';
        $date = date('y');

        // Gunakan raw SQL untuk menghindari masalah tipe data PostgreSQL
        $sql = "SELECT no_rekam_medis FROM registrasi WHERE no_rekam_medis::text LIKE :pattern ORDER BY id_registrasi DESC LIMIT 1";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValue(':pattern', $prefix . $date . '%');
        $lastNo = $command->queryScalar();

        if ($lastNo) {
            $lastNumber = (int) substr($lastNo, -5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . sprintf('%05d', $newNumber);
    }

    /**
     * Relasi dengan data form
     */
    public function getDataForms()
    {
        return $this->hasMany(DataForm::class, ['id_registrasi' => 'id_registrasi']);
    }
}
