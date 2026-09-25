<?php
require_once '../database/koneksi.php';
$halaman = 'validasi_pembayaran';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Validasi Pembayaran - MeowMart</title>

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
                <h3 class="card-title">Data Validasi Pembayaran</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tgl Transaksi</th>
                    <th>Nama Pembeli</th>
                    <th>Nama Kucing</th>
                    <th>Total Bayar</th>
                    <th>Bukti Transfer</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $query_transaksi = mysqli_query($db, "SELECT * FROM transaksi WHERE status_transaksi = 'Verifikasi Pembayaran' ORDER BY tanggal_transaksi DESC") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_transaksi);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_transaksi)) {
                            $id_transaksi = $data['id_transaksi'];
                            $id_pembeli = $data['id_pembeli'];
                            $id_kucing = $data['id_kucing'];
                            $tanggal_transaksi = $data['tanggal_transaksi'];
                            $total_bayar = $data['total_bayar'];
                            $bukti_transfer = $data['bukti_transfer'];

                            $q_pembeli = mysqli_query($db, "SELECT nama FROM users WHERE id_user = '$id_pembeli'");
                            $d_pembeli = mysqli_fetch_assoc($q_pembeli);
                            $nama_pembeli = $d_pembeli['nama'] ?? 'Tidak Dikenal';

                            $q_kucing = mysqli_query($db, "SELECT nama_kucing FROM kucing WHERE id_kucing = '$id_kucing'");
                            $d_kucing = mysqli_fetch_assoc($q_kucing);
                            $nama_kucing = $d_kucing['nama_kucing'] ?? 'Kucing Dihapus';
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($tanggal_transaksi)); ?></td>
                                <td><?= $nama_pembeli; ?></td>
                                <td><?= $nama_kucing; ?></td>
                                <td>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-bukti<?= $id_transaksi; ?>">
                                        <i class="fas fa-image"></i> Lihat Bukti
                                    </button>
                                </td>
                                <td>
                                    <a href="proses_validasi.php?id=<?= $id_transaksi; ?>&aksi=valid" class="btn btn-sm btn-success" onclick="return confirm('Yakin validasi pembayaran ini?')"><i class="fas fa-check"></i> Valid</a>
                                    <a href="proses_validasi.php?id=<?= $id_transaksi; ?>&aksi=tolak" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menolak pembayaran ini?')"><i class="fas fa-times"></i> Tolak</a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-bukti<?= $id_transaksi; ?>">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Bukti Transfer</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <img src="../bukti_transfer/<?= $bukti_transfer; ?>" alt="Bukti Transfer" class="img-fluid" style="max-height: 400px; width: auto;">
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                  </div>
                                </div>
                              </div>
                            </div>

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