<?php
require_once '../database/koneksi.php';

$halaman = 'katalog_kucing';
// Mengambil ID penjual dari session yang aktif saat login
$id_penjual = $_SESSION['id_user']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Katalog Kucing Saya - MeowMart</title>

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
                <h3 class="card-title">Katalog Kucing Saya</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Kucing</button>
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kucing</th>
                    <th>Ras Kucing</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur</th>
                    <th>Harga</th>
                    <th>Status Validasi</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Query biasa memfilter KHUSUS milik id_penjual yang login
                    $query_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE id_penjual = '$id_penjual' ORDER BY created_at DESC") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_kucing);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_kucing)) {
                            $id_kucing = $data['id_kucing'];
                            $nama_kucing = $data['nama_kucing'];
                            $id_ras = $data['id_ras'];
                            $jenis_kelamin = $data['jenis_kelamin'];
                            $umur_bulan = $data['umur_bulan'];
                            $harga = $data['harga'];
                            $status_validasi = $data['status_validasi']; // 'P' (Pending), 'V' (Valid), 'D' (Ditolak)
                            $status_jual = $data['status_jual'];
                            $deskripsi = $data['deskripsi'];
                            $file_kesehatan = $data['file_kesehatan'];

                            // Query biasa untuk mencari Nama Ras berdasarkan id_ras
                            $q_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
                            $d_ras = mysqli_fetch_assoc($q_ras);
                            $nama_ras = $d_ras['nama_ras'] ?? 'Lainnya';
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $nama_kucing; ?></td>
                                <td><?= $nama_ras; ?></td>
                                <td><?= ($jenis_kelamin == 'J') ? 'Jantan' : 'Betina'; ?></td>
                                <td><?= $umur_bulan; ?> Bulan</td>
                                <td>Rp <?= number_format($harga, 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                    if ($status_validasi == 'V') {
                                        echo '<span class="badge badge-success">Valid (Tampil)</span>';
                                    } elseif ($status_validasi == 'D') {
                                        echo '<span class="badge badge-danger">Ditolak</span>';
                                    } else {
                                        echo '<span class="badge badge-warning">Menunggu Validasi</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                  <!-- Tombol Detail -->
                                  <a class="btn btn-sm btn-info" href="detail_kucing.php?nama_kucing=<?= $nama_kucing; ?>"><i class="fas fa-eye"></i> Detail</a>

                                  <!-- Penjual hanya bisa Edit & Hapus jika kucing belum dibeli orang (Status Jual 'TS') -->
                                  <?php if ($status_jual == 'TS') { ?>
                                      <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit"
                                        data-id_kucing="<?= $id_kucing; ?>"
                                        data-id_ras="<?= $id_ras; ?>"
                                        data-nama_kucing="<?= $nama_kucing; ?>"
                                        data-harga="<?= $harga; ?>"
                                        data-jenis_kelamin="<?= $jenis_kelamin; ?>"
                                        data-umur_bulan="<?= $umur_bulan; ?>"
                                        data-deskripsi="<?= $deskripsi; ?>"
                                        data-file_kesehatan="<?= $file_kesehatan; ?>">
                                        <i class="fas fa-edit"></i> Edit
                                      </button>
                                      
                                      <a class="btn btn-sm btn-danger" href="proses_hapus_kucing.php?nama_kucing=<?= $nama_kucing ?>" onclick="return confirm('Yakin hapus data kucing ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                  <?php } else { ?>
                                      <span class="badge badge-secondary mt-1">Telah Terjual</span>
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

<!-- Modal Tambah Kucing -->
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kucing Baru</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="proses_tambah_kucing.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <!-- Penjual tidak perlu pilih nama, sistem langsung mengirimkan ID penjual yang login -->
                <input type="hidden" name="id_penjual" value="<?= $id_penjual; ?>">
                
                <div class="form-group">
                  <label>Nama Kucing</label>
                  <input type="text" name="nama_kucing" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Ras Kucing</label>
                  <select name="id_ras" class="form-control" required>
                    <option value="">-- Pilih Ras --</option>
                    <?php
                    $q_ras = mysqli_query($db, "SELECT * FROM kategori_ras");
                    while($r = mysqli_fetch_assoc($q_ras)){
                        echo '<option value="'.$r['id_ras'].'">'.$r['nama_ras'].'</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control" required>
                    <option value="J">Jantan</option>
                    <option value="B">Betina</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Umur (Bulan)</label>
                  <input type="number" name="umur_bulan" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Harga (Rp)</label>
                  <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Deskripsi (Kesehatan, Vaksin, dsb)</label>
                  <textarea name="deskripsi" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                  <label>Upload Sertifikat/Buku Vaksin (PDF)</label>
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
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="proses_edit_kucing.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">   
                <input type="hidden" name="id_kucing">
                
                <div class="form-group">
                  <label>Nama Kucing</label>
                  <input type="text" name="nama_kucing" class="form-control" readonly>
                  <small class="text-muted">Nama kucing tidak bisa diubah.</small>
                </div>

                <div class="form-group">
                  <label>Ras Kucing</label>
                  <select name="id_ras" class="form-control" required>
                    <?php
                    $q_ras2 = mysqli_query($db, "SELECT * FROM kategori_ras");
                    while($r2 = mysqli_fetch_assoc($q_ras2)){
                        echo '<option value="'.$r2['id_ras'].'">'.$r2['nama_ras'].'</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control" required>
                    <option value="J">Jantan</option>
                    <option value="B">Betina</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Umur (Bulan)</label>
                  <input type="number" name="umur_bulan" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Harga (Rp)</label>
                  <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                  <label>Sertifikat Baru (PDF)</label>
                  <input type="hidden" name="file_kesehatan_lama">
                  <input type="file" name="file_kesehatan" class="form-control" accept=".pdf">
                  <small class="text-muted">Biarkan kosong jika tidak diganti.</small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-edit" type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    var id_ras = $(e.relatedTarget).data('id_ras');
    var nama_kucing = $(e.relatedTarget).data('nama_kucing');
    var harga = $(e.relatedTarget).data('harga');
    var jenis_kelamin = $(e.relatedTarget).data('jenis_kelamin');
    var umur_bulan = $(e.relatedTarget).data('umur_bulan');
    var deskripsi = $(e.relatedTarget).data('deskripsi');
    var file_kesehatan = $(e.relatedTarget).data('file_kesehatan');
    
    $(e.currentTarget).find('input[name="id_kucing"]').val(id_kucing);
    $(e.currentTarget).find('select[name="id_ras"]').val(id_ras);
    $(e.currentTarget).find('input[name="nama_kucing"]').val(nama_kucing);
    $(e.currentTarget).find('input[name="harga"]').val(harga);
    $(e.currentTarget).find('select[name="jenis_kelamin"]').val(jenis_kelamin);
    $(e.currentTarget).find('input[name="umur_bulan"]').val(umur_bulan);
    $(e.currentTarget).find('textarea[name="deskripsi"]').val(deskripsi);
    $(e.currentTarget).find('input[name="file_kesehatan_lama"]').val(file_kesehatan);
  });
</script>
</body>
</html>