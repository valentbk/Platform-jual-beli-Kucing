<?php
require_once '../database/koneksi.php';
$halaman = 'penarikan_dana';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Penarikan Dana - MeowMart</title>

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
          Hallo, <?= $_SESSION['nama'] ?? 'Admin'; ?> <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="../ganti_password_superadmin" class="dropdown-item">
            <i class="fas fa-lock mr-2"></i> Ganti Password
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
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">Sistem Jual Beli</span>
    </a>
    <div class="sidebar">
      <?php include '../sidebar_admin.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">Permintaan Penarikan Dana (Withdraw)</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tgl Pengajuan</th>
                    <th>Penjual</th>
                    <th>Nominal</th>
                    <th>Tujuan Transfer</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Query mengambil seluruh data penarikan
                    $query_wd = mysqli_query($db, "SELECT * FROM penarikan_dana") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_wd);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_wd)) {
                            $id_penarikan = $data['id_penarikan'];
                            $id_penjual = $data['id_penjual'];
                            $id_rek_penjual = $data['id_rek_penjual'];
                            $nominal = $data['nominal'];
                            $tanggal_pengajuan = $data['tanggal_pengajuan'];
                            $bukti_transfer_admin = $data['bukti_transfer_admin'];
                            $status_penarikan = $data['status_penarikan']; 

                            $q_penjual = mysqli_query($db, "SELECT nama FROM users WHERE id_user = '$id_penjual'");
                            $d_penjual = mysqli_fetch_assoc($q_penjual);
                            $nama_penjual = $d_penjual['nama'] ?? 'Tidak Dikenal';

                            $q_rek = mysqli_query($db, "SELECT * FROM rekening_penjual WHERE id_rek_penjual = '$id_rek_penjual'");
                            $d_rek = mysqli_fetch_assoc($q_rek);
                            $nama_bank = $d_rek['nama_bank'] ?? '-';
                            $no_rekening = $d_rek['no_rekening'] ?? '-';
                            $atas_nama = $d_rek['atas_nama'] ?? '-';
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($tanggal_pengajuan)); ?></td>
                                <td><?= $nama_penjual; ?></td>
                                <td><strong class="text-success">Rp <?= number_format($nominal, 0, ',', '.'); ?></strong></td>
                                <td>
                                    <?= $nama_bank; ?> <br>
                                    <small><?= $no_rekening; ?> (<?= $atas_nama; ?>)</small>
                                </td>
                                <td>
                                    <?php 
                                    if ($status_penarikan == 'Pending') {
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    } elseif ($status_penarikan == 'Diproses') {
                                        echo '<span class="badge badge-info">Diproses</span>';
                                    } elseif ($status_penarikan == 'Sukses') {
                                        echo '<span class="badge badge-success">Sukses</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Ditolak</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($bukti_transfer_admin)) { ?>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-bukti<?= $id_penarikan; ?>">
                                            <i class="fas fa-image"></i> Lihat Bukti
                                        </button>
                                        
                                        <div class="modal fade" id="modal-bukti<?= $id_penarikan; ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Bukti Transfer ke Penjual</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>
                                              <div class="modal-body text-center">
                                                <img src="../bukti_withdraw/<?= $bukti_transfer_admin; ?>" alt="Bukti TF" class="img-fluid">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    <?php } else { echo '-'; } ?>
                                </td>
                                <td>
                                    <?php if($status_penarikan == 'Pending' || $status_penarikan == 'Diproses') { ?>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-proses"
                                            data-id_penarikan="<?= $id_penarikan; ?>"
                                            data-nominal="<?= $nominal; ?>"
                                            data-bank="<?= $nama_bank; ?> - <?= $no_rekening; ?> (<?= $atas_nama; ?>)">
                                            <i class="fas fa-cogs"></i> Proses
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
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

<!-- Modal Proses Penarikan -->
<div class="modal fade" id="modal-proses">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Proses Penarikan Dana</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_withdraw.php" method="post" enctype="multipart/form-data">
      <div class="modal-body">   
          <input type="hidden" name="id_penarikan">
          
          <div class="form-group">
            <label>Nominal yang harus ditransfer:</label>
            <input type="text" name="info_nominal" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Rekening Tujuan:</label>
            <input type="text" name="info_bank" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Pilih Status Baru</label>
            <select name="status_penarikan" class="form-control" required>
              <option value="Sukses">Sukses (Uang Terkirim)</option>
              <option value="Ditolak">Tolak Pencairan</option>
            </select>
          </div>

          <div class="form-group">
            <label>Upload Bukti Transfer (Gambar/Foto)</label>
            <input type="file" name="bukti_transfer_admin" class="form-control" accept="image/*">
            <small class="text-muted">Wajib diisi jika status diset menjadi "Sukses".</small>
          </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button name="btn-proses-wd" type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>

<script>
  $('#modal-proses').on('show.bs.modal', function(e){
    var id_penarikan = $(e.relatedTarget).data('id_penarikan');
    var nominal = $(e.relatedTarget).data('nominal');
    var bank = $(e.relatedTarget).data('bank');
    
    var reverse = nominal.toString().split('').reverse().join(''),
        ribuan  = reverse.match(/\d{1,3}/g);
    ribuan  = ribuan.join('.').split('').reverse().join('');
    
    $(e.currentTarget).find('input[name="id_penarikan"]').val(id_penarikan);
    $(e.currentTarget).find('input[name="info_nominal"]').val('Rp ' + ribuan);
    $(e.currentTarget).find('input[name="info_bank"]').val(bank);
  });
</script>
</body>
</html>