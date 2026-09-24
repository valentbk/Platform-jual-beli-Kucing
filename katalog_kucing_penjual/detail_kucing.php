<?php
require_once '../database/koneksi.php';

$halaman = 'katalog_kucing';
$id_penjual = $_SESSION['id_user'] ?? '';

// Cek apakah ada parameter nama_kucing di URL
if (!isset($_GET['nama_kucing'])) {
    echo '<script>window.location.href="index.php"</script>';
    exit;
}

$nama_kucing_get = mysqli_real_escape_string($db, $_GET['nama_kucing']);

// Mengambil data kucing khusus milik penjual ini
$query_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE nama_kucing = '$nama_kucing_get' AND id_penjual = '$id_penjual'");
$data = mysqli_fetch_assoc($query_kucing);

// Jika data tidak ditemukan (atau mencoba akses kucing orang lain)
if (!$data) {
    echo '<script>alert("Data tidak ditemukan atau bukan milik Anda!"); window.location.href="index.php"</script>';
    exit;
}

$id_ras = $data['id_ras'];
$q_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
$d_ras = mysqli_fetch_assoc($q_ras);
$nama_ras = $d_ras['nama_ras'] ?? 'Lainnya';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Kucing - MeowMart</title>

<?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama'] ?? 'Penjual'; ?> <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">MeowMart</span>
    </a>
    <div class="sidebar">
      <?php include '../sidebar_penjual.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Kucing: <?= $data['nama_kucing']; ?></h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- Bagian Informasi Teks -->
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <h3 class="profile-username text-center"><?= $data['nama_kucing']; ?></h3>
                <p class="text-muted text-center"><?= $nama_ras; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Jenis Kelamin</b> <a class="float-right"><?= ($data['jenis_kelamin'] == 'J') ? 'Jantan' : 'Betina'; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Umur</b> <a class="float-right"><?= $data['umur_bulan']; ?> Bulan</a>
                  </li>
                  <li class="list-group-item">
                    <b>Harga</b> <a class="float-right text-success font-weight-bold">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status Jual</b> 
                    <a class="float-right">
                      <?php if($data['status_jual'] == 'TS') echo '<span class="badge badge-info">Tersedia</span>'; else echo '<span class="badge badge-secondary">Terjual</span>'; ?>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Status Validasi</b> 
                    <a class="float-right">
                      <?php 
                      if ($data['status_validasi'] == 'V') echo '<span class="badge badge-success">Valid</span>';
                      elseif ($data['status_validasi'] == 'D') echo '<span class="badge badge-danger">Ditolak</span>';
                      else echo '<span class="badge badge-warning">Pending</span>';
                      ?>
                    </a>
                  </li>
                </ul>

                <strong><i class="fas fa-file-alt mr-1"></i> Deskripsi & Riwayat Kesehatan</strong>
                <p class="text-muted mt-2">
                  <?= nl2br($data['deskripsi']); ?>
                </p>

                <a href="index.php" class="btn btn-secondary btn-block mt-4"><b><i class="fas fa-arrow-left"></i> Kembali ke Katalog</b></a>
              </div>
            </div>
          </div>

          <!-- Bagian Penampil PDF -->
          <div class="col-md-6">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-pdf"></i> Sertifikat Kesehatan / Vaksin</h3>
              </div>
              <div class="card-body text-center">
                <?php if (!empty($data['file_kesehatan'])): ?>
                    <!-- Sesuaikan path folder PDF milik AdminLTE-mu. Contoh ini asumsikan folder admin ada di luar folder penjual -->
                    <?php $pdf_path = "../data_master_admin/pdf/" . $data['file_kesehatan']; ?>
                    
                    <embed src="<?= $pdf_path; ?>" type="application/pdf" width="100%" height="450px" />
                    
                    <div class="mt-3">
                        <a href="<?= $pdf_path; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-external-link-alt"></i> Buka di Tab Baru</a>
                        <a href="<?= $pdf_path; ?>" download class="btn btn-success btn-sm"><i class="fas fa-download"></i> Unduh File</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Belum ada file!</h5>
                        Sertifikat atau buku kesehatan belum diunggah untuk kucing ini.
                    </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 MeowMart.</strong> All rights reserved.
  </footer>
</div>

<?php include '../script.php'; ?>
</body>
</html>