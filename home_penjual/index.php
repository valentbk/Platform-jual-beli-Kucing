<?php
require_once '../database/koneksi.php';

$peran = trim($_SESSION['role'] ?? '');

$peran = $_SESSION['role'];
if ($peran != 'PJ') { // Memastikan hanya PJ (Penjual) yang bisa masuk
    echo '<script>window.location.href="../logout.php"</script>';
} else { 

$halaman = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MeowMart | Dashboard Penjual</title>

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
      include '../sidebar_penjual.php'; // Memanggil sidebar Penjual
      ?>
      <!-- /.sidebar-menu -->
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
            <h1 class="m-0">Dashboard Penjual</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <?php
        $id_penjual = $_SESSION['id_user'];
       
        // 1. Menghitung Total Kucing milik penjual
        $q_kucing = mysqli_query($db, "SELECT id_kucing FROM kucing WHERE id_penjual = '$id_penjual'");
        $tot_kucing = mysqli_num_rows($q_kucing);

        // 2. Menghitung Pesanan Masuk (Status = Diproses) yang perlu dikirim
        $q_pesanan = mysqli_query($db, "SELECT id_transaksi FROM transaksi JOIN kucing ON transaksi.id_kucing = kucing.id_kucing WHERE kucing.id_penjual = '$id_penjual' AND transaksi.status_transaksi = 'Diproses'");
        $tot_pesanan = mysqli_num_rows($q_pesanan);

        // 3. Menghitung Kucing Terjual (Status Jual = TJ)
        $q_terjual = mysqli_query($db, "SELECT id_kucing FROM kucing WHERE id_penjual = '$id_penjual' AND status_jual = 'TJ'");
        $tot_terjual = mysqli_num_rows($q_terjual);

        // 4. Menghitung Total Riwayat Withdraw (Penarikan Dana)
        $q_wd = mysqli_query($db, "SELECT id_penarikan FROM penarikan_dana WHERE id_penjual = '$id_penjual'");
        $tot_wd = mysqli_num_rows($q_wd);
        ?>

        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- Kotak Biru -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $tot_kucing; ?></h3>
                <p>Total Data Kucing</p>
              </div>
              <div class="icon">
                <i class="fas fa-cat"></i>
              </div>
              <!-- Sesuaikan link ini dengan nama folder katalog penjual kamu -->
              <a href="../katalog_kucing" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- Kotak Kuning -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $tot_pesanan; ?></h3>
                <p>Pesanan Perlu Dikirim</p>
              </div>
              <div class="icon">
                <i class="fas fa-box-open"></i>
              </div>
              <!-- Sesuaikan link ini dengan nama folder data pesanan penjual kamu -->
              <a href="../pesanan_penjual" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Kotak Hijau -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $tot_terjual; ?></h3>
                <p>Kucing Terjual</p>
              </div>
              <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <!-- Sesuaikan link ini dengan nama folder katalog penjual kamu -->
              <a href="../katalog_kucing" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Kotak Merah -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $tot_wd; ?></h3>
                <p>Riwayat Penarikan</p>
              </div>
              <div class="icon">
                <i class="fas fa-wallet"></i>
              </div>
              <!-- Sesuaikan link ini dengan nama folder withdraw penjual kamu -->
              <a href="../withdraw" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

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
} // TUTUP BLOK ELSE PEMBUNGKUS
?>