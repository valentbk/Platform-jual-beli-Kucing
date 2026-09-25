<?php
require_once '../database/koneksi.php';

$halaman = 'pesanan_saya';
$id_pembeli = $_SESSION['id_user']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Saya - MeowMart</title>

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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Riwayat Pesanan Saya</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card mt-3">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped mt-3">
              <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Pembelian</th>
                <th>Nama Kucing</th>
                <th>Total Bayar</th>
                <th>Status Transaksi</th>
                <th>No. Resi Pengiriman</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>
                <?php 
                // Query mengambil data transaksi KHUSUS pembeli yang sedang login
                $query_pesanan = mysqli_query($db, "SELECT * FROM transaksi WHERE id_pembeli = '$id_pembeli' ORDER BY tanggal_transaksi DESC") or die (mysqli_error($db));

                $rv = mysqli_num_rows($query_pesanan);
                if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_pesanan)) {
                        $id_transaksi = $data['id_transaksi'];
                        $id_kucing = $data['id_kucing'];
                        $tanggal_transaksi = $data['tanggal_transaksi'];
                        $total_bayar = $data['total_bayar'];
                        $status_transaksi = $data['status_transaksi'];
                        $no_resi = $data['no_resi_pengiriman'];

                        // Cari nama kucing
                        $q_kucing = mysqli_query($db, "SELECT nama_kucing FROM kucing WHERE id_kucing = '$id_kucing'");
                        $d_kucing = mysqli_fetch_assoc($q_kucing);
                        $nama_kucing = $d_kucing['nama_kucing'] ?? 'Tidak Diketahui';
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($tanggal_transaksi)); ?></td>
                            <td><strong class="text-primary"><?= $nama_kucing; ?></strong></td>
                            <td>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                            <td>
                                <?php 
                                if ($status_transaksi == 'Verifikasi Pembayaran') {
                                    echo '<span class="badge badge-warning">Menunggu Verifikasi Admin</span>';
                                } elseif ($status_transaksi == 'Diproses') {
                                    echo '<span class="badge badge-info">Sedang Diproses Penjual</span>';
                                } elseif ($status_transaksi == 'Dikirim') {
                                    echo '<span class="badge badge-primary">Dalam Pengiriman</span>';
                                } elseif ($status_transaksi == 'Selesai') {
                                    echo '<span class="badge badge-success">Selesai</span>';
                                } else {
                                    echo '<span class="badge badge-secondary">'.$status_transaksi.'</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if (!empty($no_resi)) {
                                    echo '<span class="text-success font-weight-bold">'.$no_resi.'</span>';
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($status_transaksi == 'Dikirim') { ?>
                                    <!-- Jika status dikirim, pembeli BISA konfirmasi pesanan -->
                                    <a href="proses_terima.php?id=<?= $id_transaksi; ?>" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin pesanan sudah diterima dengan baik dan aman?')">
                                        <i class="fas fa-check-circle"></i> Pesanan Diterima
                                    </a>
                                <?php } elseif ($status_transaksi == 'Selesai') { ?>
                                    <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                <?php } else { ?>
                                    <button class="btn btn-sm btn-secondary" disabled>Menunggu...</button>
                                <?php } ?>
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