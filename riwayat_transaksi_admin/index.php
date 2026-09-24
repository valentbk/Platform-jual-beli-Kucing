<?php
require_once '../database/koneksi.php';
$halaman = 'riwayat_transaksi';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Transaksi - MeowMart</title>

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
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama'] ?? 'User'; ?> <i class="far fa-user"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-book mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
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
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">Sistem Jual Beli</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <?php
      include '../sidebar_admin.php';
      ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">Data Riwayat Transaksi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Penjual</th>
                    <th>Nama Kucing</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>No Resi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Query biasa mengambil seluruh riwayat transaksi
                    $query_transaksi = mysqli_query($db, "SELECT * FROM transaksi ORDER BY tanggal_transaksi DESC") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_transaksi);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_transaksi)) {
                            $id_transaksi = $data['id_transaksi'];
                            $id_pembeli = $data['id_pembeli'];
                            $id_kucing = $data['id_kucing'];
                            $tanggal_transaksi = $data['tanggal_transaksi'];
                            $total_bayar = $data['total_bayar'];
                            $status_transaksi = $data['status_transaksi'];
                            $no_resi = $data['no_resi_pengiriman'];

                            // 1. Mencari Nama Pembeli berdasarkan id_pembeli
                            $q_pembeli = mysqli_query($db, "SELECT nama FROM users WHERE id_user = '$id_pembeli'");
                            $d_pembeli = mysqli_fetch_assoc($q_pembeli);
                            $nama_pembeli = $d_pembeli['nama'] ?? 'Tidak Dikenal';

                            // 2. Mencari Nama Kucing dan id_penjual dari tabel kucing
                            $q_kucing = mysqli_query($db, "SELECT nama_kucing, id_penjual FROM kucing WHERE id_kucing = '$id_kucing'");
                            $d_kucing = mysqli_fetch_assoc($q_kucing);
                            $nama_kucing = $d_kucing['nama_kucing'] ?? 'Kucing Dihapus';
                            $id_penjual = $d_kucing['id_penjual'] ?? 0;

                            // 3. Mencari Nama Penjual berdasarkan id_penjual (yang didapat dari tabel kucing tadi)
                            $q_penjual = mysqli_query($db, "SELECT nama FROM users WHERE id_user = '$id_penjual' AND role = 'PJ'");
                            $d_penjual = mysqli_fetch_assoc($q_penjual);
                            $nama_penjual = $d_penjual['nama'] ?? 'Tidak Dikenal';
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y', strtotime($tanggal_transaksi)); ?></td>
                                <td><?= $nama_pembeli; ?></td>
                                <td><?= $nama_penjual; ?></td>
                                <td><?= $nama_kucing; ?></td>
                                <td>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                    // Mewarnai badge status agar terlihat profesional
                                    if ($status_transaksi == 'Belum Bayar') {
                                        echo '<span class="badge badge-warning">Belum Bayar</span>';
                                    } elseif ($status_transaksi == 'Verifikasi Pembayaran') {
                                        echo '<span class="badge badge-info">Verifikasi</span>';
                                    } elseif ($status_transaksi == 'Diproses') {
                                        echo '<span class="badge badge-primary">Diproses</span>';
                                    } elseif ($status_transaksi == 'Dikirim') {
                                        echo '<span class="badge badge-info">Dikirim</span>';
                                    } elseif ($status_transaksi == 'Selesai') {
                                        echo '<span class="badge badge-success">Selesai</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Batal</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= !empty($no_resi) ? $no_resi : '-'; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>

</body>
</html>