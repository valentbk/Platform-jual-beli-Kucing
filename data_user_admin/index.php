<?php
require_once '../database/koneksi.php';
$halaman = 'data_user';
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
      <!-- Navbar Search -->

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama']; ?> <i class="far fa-user"></i>
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
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah">
                  Tambah Data User
                </button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $query_ambil_data = mysqli_query($db,"SELECT * FROM users") or die (mysqli_error($db));
                    $rv = mysqli_num_rows($query_ambil_data);
                    if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_ambil_data)) {
                        $nama = $data ['nama'];
                        $email = $data ['email'];
                        $role = $data ['role'];
                        $no_hp = $data ['no_hp'];
                        $alamat = $data ['alamat'];
                        $id_user = $data ['id_user'];

                        ?>
                        <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $nama; ?></td>
                        <td><?= $email; ?></td>
                        <td><?php 
                        if($role == 'A') {
                            echo 'Admin';
                        }elseif ($role == 'PJ') {
                            echo 'Penjual';
                        }else {
                            echo 'Pembeli';
                        }
                        ?></td>
                        <td><?= $no_hp ?></td>
                        <td><?= $alamat ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-edit"
                          data-id_user="<?= $id_user; ?>"
                          data-nama="<?= $nama; ?>"
                          data-email="<?= $email; ?>"
                          data-role="<?= $role; ?>"
                          data-no_hp="<?= $no_hp ?>"
                          data-alamat="<?= $alamat ?>"
                          >
                            <i class="fas fa-edit"></i>
                          </button>
                          <a class="btn btn-sm  btn-danger" href="proses_hapus.php?id_user=<?= $id_user ?>" onclick="return confirm('apakah kamu yakin akan menghapus data ini?')"><i class="fas fa-trash" ></i></a>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

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
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah.php" method="post">
            <div class="modal-body">
                  <div class="form-group">
                    <input type="hidden" name="id_user" hidden>
                    <label for="">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                      <option value="">-- Pilih Role --</option>
                      <option value="A">Admin</option>
                      <option value="PJ">Penjual</option>
                      <option value="PB">Pembeli</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">NO HP</label>
                    <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukan No HP" required>
                  </div>
                  <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukan Alamat" required>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-tambah" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                    <input type="hidden" name="id_user" hidden>
                    <label for="">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                      <option value="">-- Pilih Role --</option>
                      <option value="A">Admin</option>
                      <option value="PJ">Penjual</option>
                      <option value="PB">Pembeli</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">NO HP</label>
                    <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukan No HP" required>
                  </div>
                  <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukan Alamat" required>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-edit" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.modal -->
  

<!-- REQUIRED SCRIPTS -->

<?php
include '../script.php'; 
 ?>

 <script>
  $('#modal-edit').on('show.bs.modal' , function(e){
    var id_user=$(e.relatedTarget).data('id_user');
    var nama=$(e.relatedTarget).data('nama');
    var email=$(e.relatedTarget).data('email');
    var role=$(e.relatedTarget).data('role');
    var no_hp=$(e.relatedTarget).data('no_hp');
    var alamat=$(e.relatedTarget).data('alamat');
    
    $(e.currentTarget).find('input[name="id_user"]').val(id_user);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="role"]').val(role);
    $(e.currentTarget).find('input[name="no_hp"]').val(no_hp);
    $(e.currentTarget).find('input[name="alamat"]').val(alamat);

  })
 </script>
</body>
</html>