<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DataForm */

$this->title = 'Print Form Pengkajian';

// Get data
$data = $model->getDisplayData();
$registrasi = $model->registrasi;

// CSS untuk print
$this->registerCss("
@media print {
    .no-print { display: none !important; }
    body { font-size: 12px; line-height: 1.3; }
    .print-header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
    table { border-collapse: collapse; width: 100%; }
    table, th, td { border: 1px solid black; }
    th, td { padding: 4px; text-align: left; font-size: 11px; }
    .checkbox-item { display: inline-block; margin-right: 15px; }
    .form-section { margin-bottom: 15px; border: 1px solid #000; padding: 10px; }
    .section-title { font-weight: bold; background-color: #f0f0f0; padding: 5px; margin-bottom: 10px; }
    .page-break { page-break-before: always; }
}

body { 
    font-family: Arial, sans-serif; 
    font-size: 12px; 
    line-height: 1.4; 
    color: #000; 
    background: white; 
    margin: 0; 
    padding: 20px; 
}

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
    <?= Html::button('<i class="fas fa-print"></i> Print', ['onclick' => 'window.print()', 'class' => 'btn btn-primary']) ?>
    <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['view-form', 'id' => $model->id_form_data], ['class' => 'btn btn-secondary']) ?>
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
                <strong>Nama Lengkap : <?= Html::encode($registrasi->nama_pasien ?? 'PASIEN CONTOH') ?></strong><br>
                <strong>Tanggal Lahir : <?= $registrasi->tanggal_lahir ? date('d F Y', strtotime($registrasi->tanggal_lahir)) : '20 April 1998' ?></strong><br>
                <strong>No. RM : <?= Html::encode($registrasi->no_rekam_medis ?? '00-17-XX-XX') ?></strong>
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
            <div><strong>Tanggal Pengkajian:</strong> <?= $data['tanggal_pengkajian'] ?? '13/11/2024' ?></div>
            <div><strong>Jam Pengkajian:</strong> <?= $data['jam_pengkajian'] ?? '13:40' ?></div>
            <div><strong>Poliklinik:</strong> <?= $data['poliklinik'] ?? 'KLINIK OBGYN' ?></div>
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
                        <input type="checkbox" <?= ($data['cara_masuk'] ?? '') == 'jalan_tanpa_bantuan' ? 'checked' : '' ?>> Jalan tanpa bantuan
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($data['cara_masuk'] ?? '') == 'kursi_tanpa_bantuan' ? 'checked' : '' ?>> Kursi tanpa bantuan
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($data['cara_masuk'] ?? '') == 'tempat_tidur_dorong' ? 'checked' : '' ?>> Tempat tidur dorong
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($data['cara_masuk'] ?? '') == 'lain_lain' ? 'checked' : '' ?>> Lain-lain
                    </div>
                </div>
            </div>
            <div class="col-6">
                <strong>2. Anamnesis:</strong><br>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($data['anamnesis'] ?? '') == 'autoanamnesis' ? 'checked' : '' ?>> Autoanamnesis
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" <?= ($data['anamnesis'] ?? '') == 'aloanamnesis' ? 'checked' : '' ?>> Aloanamnesis
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    Diperoleh : <u><?= Html::encode($data['anamnesis_detail']['diperoleh'] ?? '') ?></u>
                    Hubungan : <u><?= Html::encode($data['anamnesis_detail']['hubungan'] ?? '') ?></u>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <strong>Alergi:</strong> <?= Html::encode($data['alergi'] ?? 'seiring nyeri bagian vagina, flek sudah 2 hr yll') ?>
        </div>

        <div class="mb-2">
            <strong>3. Keluhan utama saat ini:</strong><br>
            <?= nl2br(Html::encode($data['keluhan_utama'] ?? 'seiring nyeri bagian vagina, flek sudah 2 hr yll')) ?>
        </div>
    </div>

    <!-- Pemeriksaan Fisik -->
    <div class="form-section">
        <div class="section-title">4. Pemeriksaan fisik:</div>

        <?php $fisik = $data['pemeriksaan_fisik'] ?? []; ?>

        <div class="row mb-2">
            <div class="col-4">
                <strong>a. Keadaan umum:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['keadaan_umum'] ?? '') == 'tidak_tampak_sakit' ? 'checked' : '' ?>> Tidak tampak sakit
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['keadaan_umum'] ?? '') == 'sakit_ringan' ? 'checked' : '' ?>> Sakit ringan
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['keadaan_umum'] ?? '') == 'sedang' ? 'checked' : '' ?>> Sedang
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['keadaan_umum'] ?? '') == 'berat' ? 'checked' : '' ?>> Berat
                </div>
            </div>
            <div class="col-4">
                <strong>b. Warna kulit:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['warna_kulit'] ?? '') == 'normal' ? 'checked' : '' ?>> Normal
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['warna_kulit'] ?? '') == 'sianosis' ? 'checked' : '' ?>> Sianosis
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['warna_kulit'] ?? '') == 'pucat' ? 'checked' : '' ?>> Pucat
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['warna_kulit'] ?? '') == 'kemerahan' ? 'checked' : '' ?>> Kemerahan
                </div>
            </div>
            <div class="col-4">
                <strong>Kesadaran:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['kesadaran'] ?? '') == 'compos_mentis' ? 'checked' : '' ?>> Compos mentis
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['kesadaran'] ?? '') == 'apatis' ? 'checked' : '' ?>> Apatis
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['kesadaran'] ?? '') == 'somnolent' ? 'checked' : '' ?>> Somnolent
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['kesadaran'] ?? '') == 'sopor' ? 'checked' : '' ?>> Sopor
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['kesadaran'] ?? '') == 'soporokoma' ? 'checked' : '' ?>> Soporokoma
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($fisik['kesadaran'] ?? '') == 'koma' ? 'checked' : '' ?>> Koma
                </div>
            </div>
        </div>

        <!-- Tanda Vital -->
        <div class="mb-2">
            <strong>Tanda vital:</strong>
            <?php $vital = $fisik['tanda_vital'] ?? []; ?>
            <div class="vital-grid">
                <div>TD : <?= Html::encode($vital['td'] ?? '130/92 mmHg') ?></div>
                <div>P : <?= Html::encode($vital['p'] ?? 'x/menit') ?></div>
                <div>N : <?= Html::encode($vital['n'] ?? '124 x/menit') ?></div>
                <div>S : <?= Html::encode($vital['s'] ?? '36 oC') ?></div>
            </div>
        </div>

        <!-- Fungsional dan Antropometri -->
        <div class="row mb-2">
            <div class="col-6">
                <strong>Fungsional:</strong><br>
                <?php $fungsional = $fisik['fungsional'] ?? []; ?>
                1. Alat bantu : <?= Html::encode($fungsional['alat_bantu'] ?? '') ?><br>
                2. Prothesa : <?= Html::encode($fungsional['prothesa'] ?? '') ?><br>
                3. Cacat tubuh : <?= Html::encode($fungsional['cacat_tubuh'] ?? '') ?><br>
                4. ADL : <?= Html::encode($fungsional['adl'] ?? '') ?><br>
                5. Riwayat jatuh : <?= Html::encode($fungsional['riwayat_jatuh'] ?? 'Mandiri') ?><br>
            </div>
            <div class="col-6">
                <strong>Antropometri:</strong><br>
                <?php $antro = $fisik['antropometri'] ?? []; ?>
                <div class="antropometri-grid">
                    <div>Berat : <?= $antro['berat'] ?? '62' ?> Kg</div>
                    <div>Tinggi badan : <?= $antro['tinggi'] ?? '160' ?> Cm</div>
                    <div>Panjang badan (PB) : <?= $antro['lingkar'] ?? '' ?> Cm</div>
                    <div>Lingkar kepala (LK) : __ Cm</div>
                    <div>IMT : <?= $antro['imt'] ?? '' ?></div>
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
                    <input type="checkbox" <?= ($data['status_gizi'] ?? '') == 'ideal' ? 'checked' : '' ?>> Ideal
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($data['status_gizi'] ?? '') == 'kurang' ? 'checked' : '' ?>> Kurang
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($data['status_gizi'] ?? '') == 'obesitas' ? 'checked' : '' ?>> Obesitas / overweight
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Penyakit -->
    <div class="form-section">
        <?php $riwayat = $data['riwayat_penyakit'] ?? []; ?>
        <div class="row mb-2">
            <div class="col-4">
                <strong>5. Riwayat penyakit sekarang:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['sekarang'] ?? '') == 'dm' ? 'checked' : '' ?>> DM
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['sekarang'] ?? '') == 'hipertensi' ? 'checked' : '' ?>> Hipertensi
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['sekarang'] ?? '') == 'jantung' ? 'checked' : '' ?>> Jantung
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['sekarang'] ?? '') == 'lain_lain' ? 'checked' : '' ?>> Lain-lain
                </div>
            </div>
            <div class="col-4">
                <strong>6. Riwayat penyakit sebelumnya:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['sebelumnya'] ?? '') == 'tidak' ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['sebelumnya'] ?? '') == 'ya' ? 'checked' : '' ?>> Ya
                </div>
            </div>
            <div class="col-4">
                <strong>7. Riwayat penyakit keluarga:</strong><br>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['keluarga'] ?? '') == 'tidak' ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($riwayat['keluarga'] ?? '') == 'ya' ? 'checked' : '' ?>> Ya
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
                    <input type="checkbox" <?= ($data['riwayat_operasi'] ?? '') == 'tidak' ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($data['riwayat_operasi'] ?? '') == 'ya' ? 'checked' : '' ?>> Ya
                </div>
                <?php if (($data['riwayat_operasi'] ?? '') == 'ya'): ?>
                    <?php $operasiDetail = $data['operasi_detail'] ?? []; ?>
                    <div style="margin-left: 20px;">
                        Operasi apa? : <?= Html::encode($operasiDetail['apa'] ?? 'APP') ?><br>
                        Kapan? : <?= Html::encode($operasiDetail['kapan'] ?? '2017') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-6">
                <strong>10. Riwayat pernah dirawat di RS:</strong>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($data['riwayat_pernah_dirawat'] ?? '') == 'tidak' ? 'checked' : '' ?>> Tidak
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" <?= ($data['riwayat_pernah_dirawat'] ?? '') == 'ya' ? 'checked' : '' ?>> Ya
                </div>
                <?php if (($data['riwayat_pernah_dirawat'] ?? '') == 'ya'): ?>
                    <?php $dirawatDetail = $data['dirawat_detail'] ?? []; ?>
                    <div style="margin-left: 20px;">
                        Penyakit apa? : <?= Html::encode($dirawatDetail['penyakit'] ?? 'post app') ?><br>
                        Kapan? : <?= Html::encode($dirawatDetail['kapan'] ?? '2017') ?>
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
                <?php
                $resikoJatuh = $data['resiko_jatuh'] ?? [];
                $totalResiko = 0;

                // Default data jika tidak ada
                if (empty($resikoJatuh)) {
                    $resikoJatuh = [
                        ['resiko' => 'Riwayat jatuh yang baru atau dalam 3 bulan terakhir', 'hasil' => 25],
                        ['resiko' => 'Diagnosa medis sekunder > 1', 'hasil' => 15],
                        ['resiko' => 'Alat bantu jalan', 'hasil' => 0],
                        ['resiko' => 'Ad akses IV atau terapi heparin lock', 'hasil' => 20],
                        ['resiko' => 'Cara berjalan/berpindah', 'hasil' => 0],
                        ['resiko' => 'Status mental', 'hasil' => 0]
                    ];
                }

                $skalaOptions = [
                    1 => 'Tidak = 0<br>Ya = 25',
                    2 => 'Tidak = 0<br>Ya = 15',
                    3 => '0<br>15<br>15',
                    4 => 'Tidak = 0<br>Ya = 20',
                    5 => '0<br>10<br>20<br>0<br>15',
                    6 => '0<br>15'
                ];

                foreach ($resikoJatuh as $index => $item):
                    $no = $index + 1;
                    $hasil = (int)($item['hasil'] ?? 0);
                    $totalResiko += $hasil;
                ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= Html::encode($item['resiko'] ?? '') ?></td>
                        <td><?= $skalaOptions[$no] ?? '' ?></td>
                        <td class="text-center"><?= $hasil ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Nilai total</strong></td>
                    <td class="text-center"><strong><?= $totalResiko ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 10px;">
            <div style="padding: 10px; background-color: #f8f9fa; border: 1px solid #000;">
                <?php
                // Determine risk category
                if ($totalResiko <= 24) {
                    $kategoriResiko = 'Tidak berisiko (0-24)';
                    $rekomendasi = 'Perawatan standar';
                } elseif ($totalResiko <= 44) {
                    $kategoriResiko = 'Resiko rendah (25-44)';
                    $rekomendasi = 'Lakukan intervensi jatuh standar';
                } else {
                    $kategoriResiko = 'Resiko tinggi (≥45)';
                    $rekomendasi = 'Lakukan intervensi jatuh risiko tinggi';
                }
                ?>
                <strong>Kategori Resiko:</strong> <?= $kategoriResiko ?><br>
                <strong>Rekomendasi:</strong> <?= $rekomendasi ?><br>
                <small>
                    <strong>Tidak beresiko: 0-24</strong> | Perawatan yang baik<br>
                    <strong>Resiko rendah: 25-44</strong> | Lakukan intervensi jatuh standar<br>
                    <strong>Resiko tinggi: >=45</strong> | Lakukan intervensi jatuh risiko tinggi
                </small>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px;">
        <p>Medical Form System - PT BIGS Integrasi Teknologi</p>
        <p>Tanggal cetak: <?= date('d/m/Y H:i:s') ?></p>
        <p>Form ID: FM<?= str_pad($model->id_form_data, 4, '0', STR_PAD_LEFT) ?></p>
    </div>
</div>

<?php
// JavaScript untuk auto-print jika diperlukan
$this->registerJs("
// Auto focus untuk print dialog
window.addEventListener('load', function() {
    // Bisa ditambahkan auto print jika diperlukan
    // window.print();
});

// Print function
function printForm() {
    window.print();
}

// Keyboard shortcut
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        printForm();
    }
});
");
?>