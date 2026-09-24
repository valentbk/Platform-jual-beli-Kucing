<?php
require_once '../database/koneksi.php';
$halaman = 'data_ras';
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
      <span class="brand-text font-weight-light">Sistem Jual Beli Kucing</span>
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
                <h3 class="card-title">Data Kategori Ras Kucing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus"></i> Tambah Data Ras
                </button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Ras</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // Mengambil data dari tabel kategori_ras sesuai struktur database
                    $query_ambil_data = mysqli_query($db,"SELECT * FROM kategori_ras") or die (mysqli_error($db));
                    $rv = mysqli_num_rows($query_ambil_data);
                    if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_ambil_data)) {
                        $id_ras = $data['id_ras'];
                        $nama_ras = $data['nama_ras'];
                        ?>
                        <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $nama_ras; ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-edit"
                          data-id_ras="<?= $id_ras; ?>"
                          data-nama_ras="<?= $nama_ras; ?>"
                          >
                            <i class="fas fa-edit"></i> Edit
                          </button>
                          <a class="btn btn-sm btn-danger" href="proses_hapus_ras.php?id_ras=<?= $id_ras ?>" onclick="return confirm('Apakah kamu yakin akan menghapus data ras ini?')"><i class="fas fa-trash"></i> Hapus</a>
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
              <h4 class="modal-title">Tambah Data Ras Kucing</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah_ras.php" method="post">
            <div class="modal-body">
                  <div class="form-group">
                    <label for="">Nama Ras</label>
                    <input type="text" name="nama_ras" class="form-control" id="nama_ras" placeholder="Masukan Nama Ras Kucing" required>
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
              <h4 class="modal-title">Edit Data Ras Kucing</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit_ras.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id_ras">
                <label for="">Nama Ras</label>
                <input type="text" name="nama_ras" class="form-control" id="edit_nama_ras" placeholder="Masukan Nama Ras" required>
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
<?php
include '../script.php'; 
?>

<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var id_ras = $(e.relatedTarget).data('id_ras');
    var nama_ras = $(e.relatedTarget).data('nama_ras');
    
    $(e.currentTarget).find('input[name="id_ras"]').val(id_ras);
    $(e.currentTarget).find('input[name="nama_ras"]').val(nama_ras);
  });
</script>
</body>
</html>