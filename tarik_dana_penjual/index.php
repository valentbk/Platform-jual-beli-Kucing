<?php
require_once '../database/koneksi.php';

$halaman = 'tarik_dana';
// Mengambil ID penjual dari session yang aktif saat login
$id_penjual = $_SESSION['id_user']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tarik Dana - MeowMart</title>

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
                <h3 class="card-title">Riwayat Penarikan Dana</h3>
              </div>
              <div class="card-body">
                <!-- Tombol Ajukan Penarikan -->
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-hand-holding-usd"></i> Ajukan Penarikan Dana
                </button>
                
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tgl Pengajuan</th>
                    <th>Nominal</th>
                    <th>Rekening Tujuan</th>
                    <th>Status</th>
                    <th>Bukti Transfer Admin</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Query mengambil riwayat penarikan milik penjual ini
                    $query_wd = mysqli_query($db, "SELECT * FROM penarikan_dana WHERE id_penjual = '$id_penjual' ORDER BY tanggal_pengajuan DESC") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_wd);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_wd)) {
                            $id_penarikan = $data['id_penarikan'];
                            $id_rek_penjual = $data['id_rek_penjual'];
                            $nominal = $data['nominal'];
                            $tanggal_pengajuan = $data['tanggal_pengajuan'];
                            $bukti_transfer = $data['bukti_transfer_admin'];
                            $status_penarikan = $data['status_penarikan'];

                            // Query mencari detail rekening
                            $q_rek = mysqli_query($db, "SELECT nama_bank, no_rekening FROM rekening_penjual WHERE id_rek_penjual = '$id_rek_penjual'");
                            $d_rek = mysqli_fetch_assoc($q_rek);
                            $nama_bank = $d_rek['nama_bank'] ?? 'Tidak Ditemukan';
                            $no_rekening = $d_rek['no_rekening'] ?? '-';
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($tanggal_pengajuan)); ?></td>
                                <td><strong class="text-success">Rp <?= number_format($nominal, 0, ',', '.'); ?></strong></td>
                                <td><?= $nama_bank; ?> - <?= $no_rekening; ?></td>
                                <td>
                                    <?php 
                                    if ($status_penarikan == 'Pending') {
                                        echo '<span class="badge badge-warning">Pending (Menunggu Admin)</span>';
                                    } elseif ($status_penarikan == 'Diproses') {
                                        echo '<span class="badge badge-info">Sedang Diproses Admin</span>';
                                    } elseif ($status_penarikan == 'Sukses') {
                                        echo '<span class="badge badge-success">Sukses (Uang Dikirim)</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Ditolak</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($bukti_transfer)) { ?>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-bukti<?= $id_penarikan; ?>">
                                            <i class="fas fa-image"></i> Lihat Bukti
                                        </button>

                                        <!-- Modal Lihat Bukti -->
                                        <div class="modal fade" id="modal-bukti<?= $id_penarikan; ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Bukti Transfer dari Admin</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>
                                              <div class="modal-body text-center">
                                                <!-- Arahkan path gambar ke folder admin/bukti_withdraw/ -->
                                                <img src="../bukti_withdraw/<?= $bukti_transfer; ?>" alt="Bukti TF" class="img-fluid">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    <?php } else { ?>
                                        <span class="text-muted">-</span>
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

<!-- Modal Ajukan Penarikan -->
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Formulir Penarikan Dana</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="proses_tarik.php" method="post">
            <div class="modal-body">
                <input type="hidden" name="id_penjual" value="<?= $id_penjual; ?>">
                
                <div class="form-group">
                  <label>Pilih Rekening Tujuan Anda</label>
                  <select name="id_rek_penjual" class="form-control" required>
                    <option value="">-- Pilih Rekening --</option>
                    <?php
                    // Menampilkan HANYA rekening milik penjual ini yang sudah ditambahkan di menu Rekening Saya
                    $q_rek_opt = mysqli_query($db, "SELECT * FROM rekening_penjual WHERE id_penjual = '$id_penjual'");
                    while($r_opt = mysqli_fetch_assoc($q_rek_opt)){
                        echo '<option value="'.$r_opt['id_rek_penjual'].'">'.$r_opt['nama_bank'].' - '.$r_opt['no_rekening'].' ('.$r_opt['atas_nama'].')</option>';
                    }
                    ?>
                  </select>
                  <small class="text-danger">*Jika kosong, silakan tambah rekening di menu Data Rekening Saya terlebih dahulu.</small>
                </div>

                <div class="form-group">
                  <label>Nominal Penarikan (Rp)</label>
                  <input type="number" name="nominal" class="form-control" placeholder="Contoh: 500000" min="10000" required>
                  <small class="text-muted">Pastikan nominal sesuai dengan hasil penjualan Anda.</small>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button name="btn-tarik" type="submit" class="btn btn-success">Ajukan Penarikan</button>
            </div>
            </form>
          </div>
        </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>
</body>
</html>