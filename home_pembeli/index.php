<?php
require_once '../database/koneksi.php';

$peran = $_SESSION['role'];
if ($peran != 'PB') { // Hanya izinkan PB (Pembeli)
    echo '<script>window.location.href="../logout.php"</script>';
} else {

$halaman = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MeowMart | Dashboard Pembeli</title>

<?php
include '../library.php'; 
?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama']; ?> <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <!-- Menu ganti password disembunyikan / disesuaikan untuk pembeli -->
          <a href="../profil_pembeli" class="dropdown-item">
            <i class="fas fa-user-cog mr-2"></i> Pengaturan Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">MeowMart</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <?php
      // Panggil sidebar milik PEMBELI
      include '../sidebar_pembeli.php';
      ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Pembeli</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <?php
        $id_pembeli = $_SESSION['id_user'];
       
        // 1. Menghitung Pesanan Menunggu Verifikasi Admin
        $q_verifikasi = mysqli_query($db, "SELECT * FROM transaksi WHERE id_pembeli = '$id_pembeli' AND status_transaksi = 'Verifikasi Pembayaran'");
        $tot_verifikasi = mysqli_num_rows($q_verifikasi);

        // 2. Menghitung Pesanan Diproses & Dikirim (Dalam Perjalanan)
        $q_proses = mysqli_query($db, "SELECT * FROM transaksi WHERE id_pembeli = '$id_pembeli' AND status_transaksi IN ('Diproses', 'Dikirim')");
        $tot_proses = mysqli_num_rows($q_proses);

        // 3. Menghitung Pesanan Selesai
        $q_selesai = mysqli_query($db, "SELECT * FROM transaksi WHERE id_pembeli = '$id_pembeli' AND status_transaksi = 'Selesai'");
        $tot_selesai = mysqli_num_rows($q_selesai);

        // 4. Menghitung Kucing yang Tersedia di Katalog (Untuk menarik minat beli lagi)
        $q_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE status_jual = 'TS' AND status_validasi = 'V'");
        $tot_kucing = mysqli_num_rows($q_kucing);
        ?>

        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- Kotak 1: Biru (Menunggu Verifikasi) -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $tot_verifikasi; ?></h3>
                <p>Menunggu Verifikasi</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt"></i>
              </div>
              <a href="../pesanan_saya" class="small-box-footer">Lihat Pesanan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- Kotak 2: Kuning (Diproses/Dikirim) -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $tot_proses; ?></h3>
                <p>Dalam Pengiriman</p>
              </div>
              <div class="icon">
                <i class="fas fa-shipping-fast"></i>
              </div>
              <a href="../pesanan_saya" class="small-box-footer">Lacak Pesanan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Kotak 3: Hijau (Pesanan Selesai) -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $tot_selesai; ?></h3>
                <p>Pesanan Selesai</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <a href="../pesanan_saya" class="small-box-footer">Riwayat Belanja <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Kotak 4: Merah (Katalog Kucing) -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $tot_kucing; ?></h3>
                <p>Ketersediaan kucing</p>
              </div>
              <div class="icon">
                <i class="fas fa-cat"></i>
              </div>
              <a href="../katalog_pembeli" class="small-box-footer">Lihat Katalog <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2026 <a href="#">MeowMart</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php
include '../script.php'; 
?>
</body>
</html>
<?php
} 
?>