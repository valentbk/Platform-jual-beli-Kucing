<?php
require_once '../database/koneksi.php';

// Pengecekan Authority (Hanya Penjual yang boleh akses)
$peran = $_SESSION['role'] ?? '';
if ($peran != 'PJ') {
    echo '<script>window.location.href="../logout.php"</script>';
} else {

$halaman = 'home';
// Mengambil ID penjual dari session yang aktif
$id_penjual = $_SESSION['id_user']; 
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
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-book mr-2"></i> Profil
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
      // Memanggil sidebar khusus penjual (Pastikan kamu sudah buat file ini!)
      include '../sidebar_penjual.php';
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
        // --- QUERY MENGHITUNG STATISTIK KHUSUS PENJUAL INI ---
        
        // 1. Total Kucing milik penjual ini
        $q_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE id_penjual = '$id_penjual'");
        $tot_kucing = mysqli_num_rows($q_kucing);

        // 2. Pesanan Masuk (Status 'Diproses' -> artinya sudah dibayar dan siap dikirim)
        // Kita pakai Subquery karena kamu tidak pakai JOIN
        $q_pesanan = mysqli_query($db, "SELECT * FROM transaksi WHERE id_kucing IN (SELECT id_kucing FROM kucing WHERE id_penjual = '$id_penjual') AND status_transaksi = 'Diproses'");
        $tot_pesanan = mysqli_num_rows($q_pesanan);

        // 3. Kucing yang sudah Terjual (Status Jual = 'TJ')
        $q_terjual = mysqli_query($db, "SELECT * FROM kucing WHERE id_penjual = '$id_penjual' AND status_jual = 'TJ'");
        $tot_terjual = mysqli_num_rows($q_terjual);
        ?>

        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <!-- Box 1: Pesanan Masuk (Perlu Dikirim) -->
          <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $tot_pesanan; ?></h3>
                <p>Pesanan Perlu Dikirim</p>
              </div>
              <div class="icon">
                <i class="fas fa-box-open"></i>
              </div>
              <!-- Link diarahkan ke folder pesanan masuk penjual -->
              <a href="../pesanan_masuk" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- Box 2: Total Kucing Saya -->
          <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $tot_kucing; ?></h3>
                <p>Kucing Saya di Etalase</p>
              </div>
              <div class="icon">
                <i class="fas fa-cat"></i>
              </div>
              <!-- Link diarahkan ke katalog kucing penjual -->
              <a href="../katalog_saya" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Box 3: Total Kucing Terjual -->
          <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $tot_terjual; ?></h3>
                <p>Kucing Berhasil Terjual</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <!-- Bisa diarahkan ke riwayat penjualan -->
              <a href="../riwayat_penjualan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
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
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2026 <a href="#">MeowMart</a>.</strong>
    All rights reserved.
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
} // Penutup kurung kurawal untuk cross authority Penjual
?>