<?php
require_once '../database/koneksi.php';
$halaman = 'data_master';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MeowMart</title>

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
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kucing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data Kucing</button>
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Penjual</th>
                    <th>Nama Kucing</th>
                    <th>Ras Kucing</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur Bulan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Query biasa untuk mengambil seluruh data kucing
                    $query_ambil_data = mysqli_query($db, "SELECT * FROM kucing") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_ambil_data);
                    if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_ambil_data)) {
                        $nama_kucing = $data['nama_kucing'];
                        $harga = $data['harga'];
                        $status_jual = $data['status_jual'];
                        $status_validasi = $data['status_validasi'];
                        $foto_kucing = $data['foto_kucing'];
                        $jenis_kelamin = $data['jenis_kelamin'];
                        $id_kucing = $data['id_kucing'];
                        $id_penjual = $data['id_penjual'];
                        $id_ras = $data['id_ras'];
                        $umur_bulan = $data['umur_bulan'];
                        $deskripsi = $data['deskripsi'];
                        $file_kesehatan = $data['file_kesehatan'];
                        $created_at = $data['created_at'];

                        // Query biasa untuk mencari Nama Penjual berdasarkan id_penjual
                        $q_penjual = mysqli_query($db, "SELECT nama FROM users WHERE id_user = '$id_penjual' AND role = 'PJ'");
                        $d_penjual = mysqli_fetch_assoc($q_penjual);
                        $nama_penjual = $d_penjual['nama'] ?? 'Tidak Dikenal';

                        // Query biasa untuk mencari Nama Ras berdasarkan id_ras
                        $q_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
                        $d_ras = mysqli_fetch_assoc($q_ras);
                        $nama_ras = $d_ras['nama_ras'] ?? 'Lainnya';
                        ?>
                        <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $nama_penjual; ?></td>
                        <td><?= $nama_kucing; ?></td>
                        <td><?= $nama_ras; ?></td>
                        <td><?php 
                        if($jenis_kelamin == 'J') {
                            echo 'Jantan';
                        }else {
                            echo 'Betina';
                        }
                        ?></td>
                        <td><?= $umur_bulan; ?> Bulan</td>
                        <td>Rp <?= number_format($harga, 0, ',', '.'); ?></td>
                        <td>
                          <a class="btn btn-sm btn-primary" href="detail_kucing.php?nama_kucing=<?= $nama_kucing; ?>"><i class="fas fa-eye"></i> Detail</a>
                          
                          <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit"
                            data-id_kucing="<?= $id_kucing; ?>"
                            data-id_penjual="<?= $id_penjual; ?>"
                            data-id_ras="<?= $id_ras; ?>"
                            data-nama_kucing="<?= $nama_kucing; ?>"
                            data-harga="<?= $harga; ?>"
                            data-status_jual="<?= $status_jual; ?>"
                            data-status_validasi="<?= $status_validasi; ?>"
                            data-jenis_kelamin="<?= $jenis_kelamin; ?>"
                            data-umur_bulan="<?= $umur_bulan; ?>"
                            data-deskripsi="<?= $deskripsi; ?>"
                            data-file_kesehatan="<?= $file_kesehatan; ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                          <a class="btn btn-sm  btn-danger" href="proses_hapus.php?nama_kucing=<?= $nama_kucing ?>" onclick="return confirm('apakah kamu yakin akan menghapus data ini?')"><i class="fas fa-trash" ></i></a>
                        </td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Kucing</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                
                <!-- 1. Nama Penjual -->
                <div class="form-group">
                  <label>Nama Penjual</label>
                  <select name="id_penjual" class="form-control" required>
                    <option value="">-- Pilih Penjual --</option>
                    <?php
                    $q_penjual = mysqli_query($db, "SELECT * FROM users WHERE role = 'PJ'");
                    while($p = mysqli_fetch_assoc($q_penjual)){
                        echo '<option value="'.$p['id_user'].'">'.$p['nama'].'</option>';
                    }
                    ?>
                  </select>
                </div>

                <!-- 2. Nama Kucing -->
                <div class="form-group">
                  <label for="">Nama Kucing</label>
                  <input type="text" name="nama_kucing" class="form-control" placeholder="Masukan nama kucing" required>
                </div>

                <!-- 3. Ras Kucing -->
                <div class="form-group">
                  <label>Ras Kucing</label>
                  <select name="id_ras" class="form-control" required>
                    <option value="">-- Pilih Ras Kucing --</option>
                    <?php
                    $q_ras = mysqli_query($db, "SELECT * FROM kategori_ras");
                    while($r = mysqli_fetch_assoc($q_ras)){
                        echo '<option value="'.$r['id_ras'].'">'.$r['nama_ras'].'</option>';
                    }
                    ?>
                  </select>
                </div>

                <!-- 4. Jenis Kelamin -->
                <div class="form-group">
                  <label for="">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="J">Jantan</option>
                    <option value="B">Betina</option>
                  </select>
                </div>

                <!-- 5. Umur Bulan -->
                <div class="form-group">
                  <label for="">Umur (Bulan)</label>
                  <input type="number" name="umur_bulan" class="form-control" placeholder="Masukan umur dalam bulan" required>
                </div>

                <!-- 6. Harga -->
                <div class="form-group">
                  <label for="">Harga</label>
                  <input type="number" name="harga" class="form-control" placeholder="Masukan Harga" required>
                </div>

                <!-- 7. Status Jual -->
                <div class="form-group">
                  <label>Status Jual</label>
                  <select name="status_jual" class="form-control" required>
                    <option value="">-- Pilih Status Jual --</option>
                    <option value="TS">Tersedia</option>
                    <option value="TJ">Terjual</option>
                  </select>
                </div>

                <!-- 8. Status Validasi -->
                <div class="form-group">
                  <label>Status Validasi</label>
                  <select name="status_validasi" class="form-control" required>
                    <option value="">-- Pilih Status Validasi --</option>
                    <option value="P">Pending</option>
                    <option value="V">Valid</option>
                    <option value="D">Ditolak</option>
                  </select>
                </div>

                <!-- 9. Deskripsi -->
                <div class="form-group">
                  <label for="">Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" placeholder="Masukan Deskripsi" required></textarea>
                </div>

                <!-- 10. File Kesehatan -->
                <div class="form-group">
                  <label for="file_kesehatan">File Kesehatan (PDF)</label>
                  <input type="file" name="file_kesehatan" class="form-control" accept=".pdf">
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-tambah" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
        </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Kucing</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">   
                <input type="hidden" name="id_kucing">
                
                <!-- 1. Nama Penjual -->
                <div class="form-group">
                  <label>Nama Penjual</label>
                  <select name="id_penjual" class="form-control" required>
                    <option value="">-- Pilih Penjual --</option>
                    <?php
                    $q_penjual2 = mysqli_query($db, "SELECT * FROM users WHERE role = 'PJ'");
                    while($p2 = mysqli_fetch_assoc($q_penjual2)){
                        echo '<option value="'.$p2['id_user'].'">'.$p2['nama'].'</option>';
                    }
                    ?>
                  </select>
                </div>

                <!-- 2. Nama Kucing -->
                <div class="form-group">
                  <label for="">Nama Kucing</label>
                  <input type="text" name="nama_kucing" class="form-control" readonly>
                  <small class="text-muted">Nama kucing tidak bisa diubah.</small>
                </div>

                <!-- 3. Ras Kucing -->
                <div class="form-group">
                  <label>Ras Kucing</label>
                  <select name="id_ras" class="form-control" required>
                    <option value="">-- Pilih Ras Kucing --</option>
                    <?php
                    $q_ras2 = mysqli_query($db, "SELECT * FROM kategori_ras");
                    while($r2 = mysqli_fetch_assoc($q_ras2)){
                        echo '<option value="'.$r2['id_ras'].'">'.$r2['nama_ras'].'</option>';
                    }
                    ?>
                  </select>
                </div>

                <!-- 4. Jenis Kelamin -->
                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="J">Jantan</option>
                    <option value="B">Betina</option>
                  </select>
                </div>

                <!-- 5. Umur Bulan -->
                <div class="form-group">
                  <label for="">Umur (Bulan)</label>
                  <input type="number" name="umur_bulan" class="form-control" required>
                </div>

                <!-- 6. Harga -->
                <div class="form-group">
                  <label for="">Harga</label>
                  <input type="number" name="harga" class="form-control" required>
                </div>

                <!-- 7. Status Jual -->
                <div class="form-group">
                  <label>Status Jual</label>
                  <select name="status_jual" class="form-control" required>
                    <option value="">-- Pilih Status Jual --</option>
                    <option value="TS">Tersedia</option>
                    <option value="TJ">Terjual</option>
                  </select>
                </div>

                <!-- 8. Status Validasi -->
                <div class="form-group">
                  <label>Status Validasi</label>
                  <select name="status_validasi" class="form-control" required>
                    <option value="">-- Pilih Status Validasi --</option>
                    <option value="P">Pending</option>
                    <option value="V">Valid</option>
                    <option value="D">Ditolak</option>
                  </select>
                </div>

                <!-- 9. Deskripsi -->
                <div class="form-group">
                  <label for="">Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" required></textarea>
                </div>

                <!-- 10. File Kesehatan -->
                <div class="form-group">
                  <label for="">File Kesehatan (PDF)</label>
                  <input type="hidden" name="file_kesehatan_lama">
                  <input type="file" name="file_kesehatan" class="form-control" accept=".pdf">
                  <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file PDF.</small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-edit" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
        </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>

<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var id_kucing = $(e.relatedTarget).data('id_kucing');
    var id_penjual = $(e.relatedTarget).data('id_penjual');
    var id_ras = $(e.relatedTarget).data('id_ras');
    var nama_kucing = $(e.relatedTarget).data('nama_kucing');
    var harga = $(e.relatedTarget).data('harga');
    var status_jual = $(e.relatedTarget).data('status_jual');
    var status_validasi = $(e.relatedTarget).data('status_validasi');
    var jenis_kelamin = $(e.relatedTarget).data('jenis_kelamin');
    var umur_bulan = $(e.relatedTarget).data('umur_bulan');
    var deskripsi = $(e.relatedTarget).data('deskripsi');
    var file_kesehatan = $(e.relatedTarget).data('file_kesehatan');
    
    $(e.currentTarget).find('input[name="id_kucing"]').val(id_kucing);
    $(e.currentTarget).find('select[name="id_penjual"]').val(id_penjual);
    $(e.currentTarget).find('select[name="id_ras"]').val(id_ras);
    $(e.currentTarget).find('input[name="nama_kucing"]').val(nama_kucing);
    $(e.currentTarget).find('input[name="harga"]').val(harga);
    $(e.currentTarget).find('select[name="status_jual"]').val(status_jual);
    $(e.currentTarget).find('select[name="status_validasi"]').val(status_validasi);
    $(e.currentTarget).find('select[name="jenis_kelamin"]').val(jenis_kelamin);
    $(e.currentTarget).find('input[name="umur_bulan"]').val(umur_bulan);
    $(e.currentTarget).find('textarea[name="deskripsi"]').val(deskripsi);
    $(e.currentTarget).find('input[name="file_kesehatan_lama"]').val(file_kesehatan);
  });
</script>
</body>
</html>