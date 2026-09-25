<?php
require_once '../database/koneksi.php';

$halaman = 'katalog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Katalog Kucing - MeowMart</title>

<?php
include '../library.php'; 
?>
<style>
  /* Sedikit CSS tambahan agar kotak gambar seragam */
  .cat-image-container {
    height: 200px;
    width: 100%;
    background-color: #f4f6f9;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 5px;
    margin-bottom: 15px;
  }
  .cat-image-container i {
    font-size: 5rem;
    color: #adb5bd;
  }
</style>
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
          Hallo, <?= $_SESSION['nama'] ?? 'Pembeli'; ?> <i class="far fa-user"></i>
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
      <?php include '../sidebar_pembeli.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Katalog Kucing</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <div class="row">
          <?php 
          // 1. QUERY PENTING: Hanya panggil kucing yang "Tersedia" dan "Valid"
          $query_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE status_jual = 'TS' AND status_validasi = 'V' ORDER BY created_at DESC") or die (mysqli_error($db));

          $rv = mysqli_num_rows($query_kucing);
          if ($rv > 0) {
              while ($data = mysqli_fetch_array($query_kucing)) {
                  $nama_kucing = $data['nama_kucing'];
                  $id_ras = $data['id_ras'];
                  $jenis_kelamin = $data['jenis_kelamin'];
                  $umur_bulan = $data['umur_bulan'];
                  $harga = $data['harga'];
                  
                  // Query mencari Nama Ras
                  $q_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
                  $d_ras = mysqli_fetch_assoc($q_ras);
                  $nama_ras = $d_ras['nama_ras'] ?? 'Lainnya';
                  ?>
                  
                  <!-- Kotak Produk (Grid col-md-3 artinya 1 baris muat 4 kucing) -->
                  <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                    <div class="card card-primary card-outline w-100">
                      <div class="card-body box-profile">
                        
                        <!-- Placeholder Foto Kucing -->
                        <div class="cat-image-container">
                          <!-- Jika nanti kamu punya kolom foto_kucing, bisa pakai tag <img src="..."> di sini -->
                          <i class="fas fa-cat"></i> 
                        </div>

                        <h3 class="profile-username text-center"><?= $nama_kucing; ?></h3>
                        <p class="text-muted text-center"><?= $nama_ras; ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                            <b>Kelamin</b> <a class="float-right"><?= ($jenis_kelamin == 'J') ? 'Jantan' : 'Betina'; ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Umur</b> <a class="float-right"><?= $umur_bulan; ?> Bulan</a>
                          </li>
                          <li class="list-group-item text-center">
                            <h4 class="text-success font-weight-bold mt-2 mb-0">Rp <?= number_format($harga, 0, ',', '.'); ?></h4>
                          </li>
                        </ul>

                        <!-- Tombol yang mengarah ke halaman Detail sekaligus Checkout -->
                        <a href="detail_beli.php?nama_kucing=<?= $nama_kucing; ?>" class="btn btn-primary btn-block">
                          <b><i class="fas fa-shopping-cart"></i> Detail & Beli</b>
                        </a>
                      </div>
                    </div>
                  </div>

                  <?php
              }
          } else {
              // Jika tidak ada kucing yang dijual/valid
              echo '
              <div class="col-12">
                <div class="alert alert-info">
                  <h5><i class="icon fas fa-info"></i> Mohon Maaf!</h5>
                  Saat ini belum ada data kucing yang tersedia untuk dibeli. Silakan kembali lagi nanti.
                </div>
              </div>';
          }
          ?>
        </div> <!-- /.row -->

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