<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */

$this->title = 'Print Form Pengkajian';

// CSS untuk print
$this->registerCss("
@media print {
    .no-print { display: none !important; }
    body { font-size: 12px; }
    .print-header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
    table { border-collapse: collapse; width: 100%; }
    table, th, td { border: 1px solid black; }
    th, td { padding: 5px; text-align: left; }
    .checkbox-item { display: inline-block; margin-right: 15px; }
    .form-section { margin-bottom: 15px; border: 1px solid #000; padding: 10px; }
    .section-title { font-weight: bold; background-color: #f0f0f0; padding: 5px; margin-bottom: 10px; }
}

body { font-family: Arial, sans-serif; font-size: 12px; }
.print-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    border-bottom: 2px solid #000; 
    padding-bottom: 10px; 
    margin-bottom: 20px; 
}
.logo-section { text-align: right; }
.patient-info { 
    background: #f8f9fa; 
    border: 1px solid #000; 
    padding: 10px; 
    margin-bottom: 15px; 
}
.form-section { 
    border: 1px solid #000; 
    padding: 10px; 
    margin-bottom: 15px; 
}
.section-title { 
    font-weight: bold; 
    background-color: #e9ecef; 
    padding: 5px; 
    margin-bottom: 10px; 
}
.checkbox-group { 
    display: flex; 
    flex-wrap: wrap; 
    gap: 15px; 
}
.checkbox-item { 
    display: flex; 
    align-items: center; 
    gap: 5px; 
}
.checkbox-item input[type='checkbox'] { 
    transform: scale(1.2); 
}
.vital-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 10px; 
}
.antropometri-grid { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); 
    gap: 10px; 
}
.resiko-table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 10px; 
}
.resiko-table th, .resiko-table td { 
    border: 1px solid #000; 
    padding: 5px; 
    font-size: 11px; 
}
.resiko-table th { 
    background-color: #e9ecef; 
    font-weight: bold; 
}
.text-center { text-align: center; }
.text-right { text-align: right; }
.flex-between { display: flex; justify-content: space-between; }
.mb-2 { margin-bottom: 10px; }
.row { display: flex; flex-wrap: wrap; }
.col-6 { width: 50%; }
.col-4 { width: 33.33%; }
.col-3 { width: 25%; }
");
?>

<div class="no-print" style="margin-bottom: 20px;">
    <?= Html::button('Print', ['onclick' => 'window.print()', 'class' => 'btn btn-primary']) ?>
    <?= Html::a('Kembali', ['view-form', 'id' => $model->id_form_data], ['class' => 'btn btn-secondary']) ?>
</div>

<div class="print-content">
    <!-- Header -->
    <div class="print-header">
        <div>
            <h3 style="margin: 0;">LAMPIRAN 1</h3>
        </div>
        <div class="logo-section">
            <div style="color: #FF6B35; font-weight: bold; font-size: 16px;">
                PT BIGS<br>
                INTEGRASI<br>
                TEKNOLOGI
            </div>
        </div>
    </div>

    <!-- Judul Form -->
    <div class="text-center mb-2">
        <h3 style="margin: 0;">PENGKAJIAN KEPERAWATAN POLIKLINIK KEBIDANAN</h3>
    </div>

    <!-- Info Pasien -->
    <div class="patient-info">
        <div class="row">
            <div class="col-6">
                <strong>Nama Lengkap : PASIEN CONTOH</strong><br>
                <strong>Tanggal Lahir : 20 April 1998</strong><br>
                <strong>No. RM : 00-17-XX-XX</strong>
            </div>
            <div class="col-6 text-right">
                <div style="border: 1px solid #000; padding: 10px; display: inline-block;">
                    <strong>Petugas</strong><br>
                    <strong>Tanggal / pukul : <?= date('d/m/Y H:i') ?></strong><br>
                    <strong>Nama lengkap</strong><br>
                    <strong>Tanda tangan</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="form-section">
        <div class="flex-between mb-2">
            <div><strong>Tanggal Pengkajian:</strong> <?= $model->tanggal_pengkajian ?: '13/11/2024' ?></div>
            <div><strong>Jam Pengkajian:</strong> <?= $model->jam_pengkajian ?: '13:40' ?></div>
            <div><strong>Poliklinik:</strong> <?= $model->poliklinik ?: 'KLINIK OBGYN' ?></div>
        </div>
    </div>

    <!-- Pengkajian saat datang -->
    <div class="form-section">
        <div class="section-title">Pengkajian saat datang (diisi oleh perawat)</div>

        <div class="row mb-2">
            <div class="col-6">
                <strong>1. Cara masuk:</strong><br>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($model->cara_masuk == 'jalan_tanpa_bantuan') ? 'checked' : '' ?>> Jalan tanpa bantuan
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($model->cara_masuk == 'kursi_tanpa_bantuan') ? 'checked' : '' ?>> Kursi tanpa bantuan
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($model->cara_masuk == 'tempat_tidur_dorong') ? 'checked' : '' ?>> Tempat tidur dorong
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($model->cara_masuk == 'lain_lain') ? 'checked' : '' ?>> Lain-lain
                    </div>
                </div>
            </div>
            <div class="col-6">
                <strong>2. Anamnesis:</strong><br>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($model->anamnesis == 'autoanamnesis') ? 'checked' : '' ?>> Autoanamnesis
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($model->anamnesis == 'aloanamnesis') ? 'checked' : '' ?>> Aloanamnesis
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    Diperoleh : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    Hubungan : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <strong>Alergi:</strong> <?= Html::encode($model->alergi ?: 'seiring nyeri bagian vagina, flek sudah 2 hr yll') ?>
        </div>

        <div class="mb-2">
            <strong>3. Keluhan utama saat ini:</strong><br>
            <?= nl2br(Html::encode($model->keluhan_utama ?: 'seiring nyeri bagian vagina, flek sudah 2 hr yll')) ?>
        </div>
    </div>

    <!-- Pemeriksaan Fisik -->
    <div class="form-section">
        <div class="section-title">4. Pemeriksaan fisik:</div>

        <div class="row mb-2">
            <div class="col-4">
                <strong>a. Keadaan umum:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->keadaan_umum == 'tidak_tampak_sakit') ? 'checked' : '' ?>> Tidak tampak sakit
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->keadaan_umum == 'sakit_ringan') ? 'checked' : '' ?>> Sakit ringan
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->keadaan_umum == 'sedang') ? 'checked' : '' ?>> Sedang
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->keadaan_umum == 'berat') ? 'checked' : '' ?>> Berat
                </div>
            </div>
            <div class="col-4">
                <strong>b. Warna kulit:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->warna_kulit == 'normal') ? 'checked' : '' ?>> Normal
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->warna_kulit == 'sianosis') ? 'checked' : '' ?>> Sianosis
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->warna_kulit == 'pucat') ? 'checked' : '' ?>> Pucat
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->warna_kulit == 'kemerahan') ? 'checked' : '' ?>> Kemerahan
                </div>
            </div>
            <div class="col-4">
                <strong>Kesadaran:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->kesadaran == 'compos_mentis') ? 'checked' : '' ?>> Compos mentis
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->kesadaran == 'apatis') ? 'checked' : '' ?>> Apatis
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->kesadaran == 'somnolent') ? 'checked' : '' ?>> Somnolent
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->kesadaran == 'sopor') ? 'checked' : '' ?>> Sopor
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->kesadaran == 'soporokoma') ? 'checked' : '' ?>> Soporokoma
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->kesadaran == 'koma') ? 'checked' : '' ?>> Koma
                </div>
            </div>
        </div>

        <!-- Tanda Vital -->
        <div class="mb-2">
            <strong>Tanda vital:</strong>
            <div class="vital-grid">
                <div>TD : <?= Html::encode($model->tanda_vital_td ?: '130/92 mmHg') ?></div>
                <div>P : <?= Html::encode($model->tanda_vital_p ?: 'x/menit') ?></div>
                <div>N : <?= Html::encode($model->tanda_vital_n ?: '124 x/menit') ?></div>
                <div>S : <?= Html::encode($model->tanda_vital_s ?: '36 oC') ?></div>
            </div>
        </div>

        <!-- Fungsional dan Antropometri -->
        <div class="row mb-2">
            <div class="col-6">
                <strong>Fungsional:</strong><br>
                1. Alat bantu : <?= Html::encode($model->fungsi_alat_bantu ?: '') ?><br>
                2. Prothesa : <?= Html::encode($model->fungsi_prothesa ?: '') ?><br>
                3. Cacat tubuh : <?= Html::encode($model->fungsi_cacat_tubuh ?: '') ?><br>
                4. ADL : <?= Html::encode($model->fungsi_adl ?: '') ?><br>
                5. Riwayat jatuh : Mandiri<br>
            </div>
            <div class="col-6">
                <strong>Antropometri:</strong><br>
                <div class="antropometri-grid">
                    <div>Berat : <?= $model->antro_berat ?: '62' ?> Kg</div>
                    <div>Tinggi badan : <?= $model->antro_tinggi ?: '50' ?> Cm</div>
                    <div>Panjang badan (PB) : <?= $model->antro_lingkar ?: '' ?> Cm</div>
                    <div>Lingkar kepala (LK) : __ Cm</div>
                    <div>IMT : <?= $model->antro_imt ?: '' ?></div>
                </div>
                <div style="margin-top: 10px;">
                    <strong>Catatan:</strong><br>
                    PB & LK Khusus Pediatri
                </div>
            </div>
        </div>

        <!-- Status Gizi -->
        <div class="mb-2">
            <strong>c. Status gizi:</strong>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->status_gizi == 'ideal') ? 'checked' : '' ?>> Ideal
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->status_gizi == 'kurang') ? 'checked' : '' ?>> Kurang
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->status_gizi == 'obesitas') ? 'checked' : '' ?>> Obesitas / overweight
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Penyakit -->
    <div class="form-section">
        <div class="row mb-2">
            <div class="col-4">
                <strong>5. Riwayat penyakit sekarang:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_sekarang == 'dm') ? 'checked' : '' ?>> DM
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_sekarang == 'hipertensi') ? 'checked' : '' ?>> Hipertensi
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_sekarang == 'jantung') ? 'checked' : '' ?>> Jantung
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_sekarang == 'lain_lain') ? 'checked' : '' ?>> Lain-lain
                </div>
            </div>
            <div class="col-4">
                <strong>6. Riwayat penyakit sebelumnya:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_sebelumnya == 'tidak') ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_sebelumnya == 'ya') ? 'checked' : '' ?>> Ya
                </div>
            </div>
            <div class="col-4">
                <strong>7. Riwayat penyakit keluarga:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_keluarga == 'tidak') ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_penyakit_keluarga == 'ya') ? 'checked' : '' ?>> Ya
                </div>
            </div>
        </div>
        <div class="mb-2">
            <strong>8. Riwayat penyakit keluarga:</strong> ___________________
        </div>
    </div>

    <!-- Riwayat Operasi -->
    <div class="form-section">
        <div class="row mb-2">
            <div class="col-6">
                <strong>9. Riwayat operasi:</strong>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_operasi == 'Tidak') ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_operasi == 'Ya') ? 'checked' : '' ?>> Ya
                </div>
                <?php if ($model->riwayat_operasi == 'Ya'): ?>
                    <div style="margin-left: 20px;">
                        Operasi apa? : APP<br>
                        Kapan? : 2017
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-6">
                <strong>10. Riwayat pernah dirawat di RS:</strong>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_pernah_dirawat == 'Tidak') ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($model->riwayat_pernah_dirawat == 'Ya') ? 'checked' : '' ?>> Ya
                </div>
                <?php if ($model->riwayat_pernah_dirawat == 'Ya'): ?>
                    <div style="margin-left: 20px;">
                        Penyakit apa? : post app<br>
                        Kapan? : 2017
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Pengkajian Resiko Jatuh -->
    <div class="form-section">
        <div class="section-title">15. Pengkajian resiko jatuh</div>

        <table class="resiko-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="60%">Resiko</th>
                    <th width="20%">Skala</th>
                    <th width="15%">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Riwayat jatuh yang baru atau dalam 3 bulan terakhir</td>
                    <td>Tidak = 0<br>Ya = 25</td>
                    <td class="text-center">25</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Diagnosa medis sekunder > 1</td>
                    <td>Tidak = 0<br>Ya = 15</td>
                    <td class="text-center">15</td>
                </tr>
                <tr>
                    <td rowspan="3">3</td>
                    <td>Mandiri, bedrest, dibantu perawat, kursi roda</td>
                    <td>0</td>
                    <td rowspan="3" class="text-center">0</td>
                </tr>
                <tr>
                    <td>Penopang, tongkat/walker</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>Mencengkeram furniture/sesuatu untuk topangan</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Ad akses IV atau terapi heparin lock</td>
                    <td>Tidak = 0<br>Ya = 20</td>
                    <td class="text-center">20</td>
                </tr>
                <tr>
                    <td rowspan="4">5</td>
                    <td>Cara berjalan/berpindah: Lemah, langkah, diseret</td>
                    <td>0</td>
                    <td rowspan="4" class="text-center">0</td>
                </tr>
                <tr>
                    <td>Terganggu, perlu bantuan, keseimbangan buruk</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Orientasi sesuai kemampuan diri</td>
                    <td>20</td>
                </tr>
                <tr>
                    <td>Lupa keterbatasan diri</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Status mental:</td>
                    <td>0</td>
                    <td class="text-center">0</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Nilai total</strong></td>
                    <td class="text-center"><strong><?= $model->getTotalResikoJatuh() ?: '60' ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 10px;">
            <div style="padding: 10px; background-color: #f8f9fa; border: 1px solid #000;">
                <strong>Kategori Resiko:</strong> <?= $model->getKategoriResikoJatuh() ?: 'Resiko tinggi' ?><br>
                <small>
                    <strong>Tidak beresiko: 0-24</strong> | Perawatan yang baik Resiko rendah: 25-44<br>
                    <strong>Lakukan intervensi jatuh standar</strong> | Resiko tinggi: >=45<br>
                    <strong>Lakukan intervensi jatuh risiko tinggi</strong>
                </small>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px;">
        <p>Yii Framework - Tanggal cetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>
</div>