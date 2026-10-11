<?php
require_once '../database/koneksi.php';

$peran = trim($_SESSION['role'] ?? '');
if ($peran != 'A') {
    echo '<script>window.location.href="../logout.php"</script>';
    exit;
}

$halaman = 'validasi_pembayaran';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Validasi Pembayaran - MeowMart</title>

<?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama'] ?? 'Admin'; ?> <i class="far fa-user"></i>
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

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Sistem Jual Beli</span>
    </a>
    <div class="sidebar">
      <?php include '../sidebar_admin.php'; ?>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">Data Validasi Pembayaran</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tgl Transaksi</th>
                    <th>Nama Pembeli</th>
                    <th>Nama Penjual</th>
                    <th>Nama Kucing</th>
                    <th>Total Bayar</th>
                    <th>Bukti Transfer</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $query_transaksi = mysqli_query($db, "SELECT * FROM transaksi WHERE status_transaksi = 'Verifikasi Pembayaran'") or die (mysqli_error($db));
                    
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

                            // Menarik data kucing beserta ID Penjualnya
                            $q_kucing = mysqli_query($db, "SELECT nama_kucing, id_penjual FROM kucing WHERE id_kucing = '$id_kucing'");
                            $d_kucing = mysqli_fetch_assoc($q_kucing);
                            $nama_kucing = $d_kucing['nama_kucing'] ?? 'Kucing Dihapus';
                            $id_penjual = $d_kucing['id_penjual'] ?? '';

                            // Menarik nama penjual berdasarkan ID Penjual yang didapat dari tabel kucing
                            $nama_penjual = 'Tidak Dikenal';
                            if (!empty($id_penjual)) {
                                $q_penjual = mysqli_query($db, "SELECT nama FROM users WHERE id_user = '$id_penjual'");
                                $d_penjual = mysqli_fetch_assoc($q_penjual);
                                $nama_penjual = $d_penjual['nama'] ?? 'Tidak Dikenal';
                            }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($tanggal_transaksi)); ?></td>
                                <td><?= $nama_pembeli; ?></td>
                                <td><?= $nama_penjual; ?></td>
                                <td><?= $nama_kucing; ?></td>
                                <td>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                                <td>
                                    <!-- Mengubah modal menjadi tautan buka gambar di tab baru -->
                                    <a href="../bukti_transfer/<?= $bukti_transfer; ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-image"></i> Lihat Bukti
                                    </a>
                                </td>
                                <td>
                                    <a href="proses_validasi.php?id=<?= $id_transaksi; ?>&aksi=valid" class="btn btn-sm btn-success" onclick="return confirm('Yakin validasi pembayaran ini?')"><i class="fas fa-check"></i> Valid</a>
                                    <a href="proses_validasi.php?id=<?= $id_transaksi; ?>&aksi=tolak" class="btn btn-sm btn-danger" onclick="return confirm('Yakin menolak pembayaran ini?')"><i class="fas fa-times"></i> Tolak</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                  </tbody>
                </table>
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