<?php
require_once '../database/koneksi.php';

$halaman = 'pesanan_masuk';
$id_penjual = $_SESSION['id_user']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Masuk - MeowMart</title>

<?php
include '../library.php'; 
?>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">Data Pesanan Masuk</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tgl Order</th>
                    <th>Kucing</th>
                    <th>Data Pembeli (Tujuan)</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>No. Resi / Pengiriman</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Query mengambil transaksi yang ID Kucingnya ada di dalam tabel kucing milik penjual ini
                    $query_pesanan = mysqli_query($db, "SELECT * FROM transaksi WHERE id_kucing IN (SELECT id_kucing FROM kucing WHERE id_penjual = '$id_penjual') ORDER BY tanggal_transaksi DESC") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_pesanan);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_pesanan)) {
                            $id_transaksi = $data['id_transaksi'];
                            $id_kucing = $data['id_kucing'];
                            $id_pembeli = $data['id_pembeli'];
                            $tanggal_transaksi = $data['tanggal_transaksi'];
                            $total_bayar = $data['total_bayar'];
                            $status_transaksi = $data['status_transaksi'];
                            $no_resi = $data['no_resi_pengiriman'];

                            // Query mencari Nama Kucing
                            $q_kucing = mysqli_query($db, "SELECT nama_kucing FROM kucing WHERE id_kucing = '$id_kucing'");
                            $d_kucing = mysqli_fetch_assoc($q_kucing);
                            $nama_kucing = $d_kucing['nama_kucing'] ?? '-';

                            // Query mencari Data Pembeli (Nama, No HP, Alamat) untuk pengiriman
                            $q_pembeli = mysqli_query($db, "SELECT nama, no_hp, alamat FROM users WHERE id_user = '$id_pembeli'");
                            $d_pembeli = mysqli_fetch_assoc($q_pembeli);
                            $nama_pembeli = $d_pembeli['nama'] ?? '-';
                            $no_hp_pembeli = $d_pembeli['no_hp'] ?? '-';
                            $alamat_pembeli = $d_pembeli['alamat'] ?? '-';
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($tanggal_transaksi)); ?></td>
                                <td><strong class="text-primary"><?= $nama_kucing; ?></strong></td>
                                <td>
                                    <b><?= $nama_pembeli; ?></b> (<?= $no_hp_pembeli; ?>)<br>
                                    <small><?= $alamat_pembeli; ?></small>
                                </td>
                                <td>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                    if ($status_transaksi == 'Verifikasi Pembayaran') {
                                        echo '<span class="badge badge-warning">Menunggu Admin</span>';
                                    } elseif ($status_transaksi == 'Diproses') {
                                        echo '<span class="badge badge-primary">Perlu Dikirim</span>';
                                    } elseif ($status_transaksi == 'Dikirim') {
                                        echo '<span class="badge badge-info">Dalam Pengiriman</span>';
                                    } elseif ($status_transaksi == 'Selesai') {
                                        echo '<span class="badge badge-success">Selesai</span>';
                                    } else {
                                        echo '<span class="badge badge-secondary">'.$status_transaksi.'</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= !empty($no_resi) ? $no_resi : '-'; ?></td>
                                <td>
                                  <?php if ($status_transaksi == 'Diproses') { ?>
                                      <!-- Jika status Diproses, Penjual harus input resi -->
                                      <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-kirim"
                                        data-id_transaksi="<?= $id_transaksi; ?>"
                                        data-nama_pembeli="<?= $nama_pembeli; ?>"
                                        data-kucing="<?= $nama_kucing; ?>">
                                        <i class="fas fa-truck"></i> Kirim Pesanan
                                      </button>
                                  <?php } else { ?>
                                      <!-- Jika belum waktunya dikirim atau sudah selesai -->
                                      <button class="btn btn-sm btn-secondary" disabled>Tidak ada aksi</button>
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

<!-- Modal Input Resi / Kirim Pesanan -->
<div class="modal fade" id="modal-kirim">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Kirim Pesanan (Input Resi)</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="proses_kirim.php" method="post">
            <div class="modal-body">   
                <input type="hidden" name="id_transaksi">
                
                <div class="form-group">
                  <label>Nama Pembeli</label>
                  <input type="text" name="info_pembeli" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label>Kucing yang dikirim</label>
                  <input type="text" name="info_kucing" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label>Nomor Resi / Kurir Pengiriman</label>
                  <input type="text" name="no_resi" class="form-control" placeholder="Contoh: JNT-123456789 atau Nama Supir Pet Travel" required>
                  <small class="text-muted">Pastikan hewan dikirim dengan aman.</small>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button name="btn-kirim" type="submit" class="btn btn-success">Konfirmasi Pengiriman</button>
            </div>
            </form>
          </div>
        </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>

<script>
  // Script melempar data ke modal
  $('#modal-kirim').on('show.bs.modal', function(e){
    var id_transaksi = $(e.relatedTarget).data('id_transaksi');
    var nama_pembeli = $(e.relatedTarget).data('nama_pembeli');
    var kucing = $(e.relatedTarget).data('kucing');
    
    $(e.currentTarget).find('input[name="id_transaksi"]').val(id_transaksi);
    $(e.currentTarget).find('input[name="info_pembeli"]').val(nama_pembeli);
    $(e.currentTarget).find('input[name="info_kucing"]').val(kucing);
  });
</script>
</body>
</html>