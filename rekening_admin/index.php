<?php
require_once '../database/koneksi.php';
$halaman = 'rekening_admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rekening Admin - MeowMart</title>

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
                <h3 class="card-title">Data Rekening Admin (Escrow)</h3>
              </div>
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Rekening</button>
                
                <table id="example1" class="table table-bordered table-striped mt-3">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Bank / E-Wallet</th>
                    <th>Nomor Rekening</th>
                    <th>Atas Nama</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $query_rek = mysqli_query($db, "SELECT * FROM rekening_admin ORDER BY id_rek_admin DESC") or die (mysqli_error($db));

                    $rv = mysqli_num_rows($query_rek);
                    if ($rv > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query_rek)) {
                            $id_rek_admin = $data['id_rek_admin'];
                            $nama_bank = $data['nama_bank'];
                            $no_rekening = $data['no_rekening'];
                            $atas_nama = $data['atas_nama'];
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $nama_bank; ?></td>
                                <td class="font-weight-bold text-primary"><?= $no_rekening; ?></td>
                                <td><?= $atas_nama; ?></td>
                                <td>
                                  <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit"
                                    data-id_rek_admin="<?= $id_rek_admin; ?>"
                                    data-nama_bank="<?= $nama_bank; ?>"
                                    data-no_rekening="<?= $no_rekening; ?>"
                                    data-atas_nama="<?= $atas_nama; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                  </button>

                                  <a class="btn btn-sm btn-danger" href="proses_hapus_rek.php?id=<?= $id_rek_admin ?>" onclick="return confirm('Apakah kamu yakin akan menghapus data rekening ini?')"><i class="fas fa-trash"></i> Hapus</a>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Rekening Admin</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah_rek.php" method="post">
            <div class="modal-body">
                
                <div class="form-group">
                  <label for="">Nama Bank / E-Wallet</label>
                  <input type="text" name="nama_bank" class="form-control" placeholder="Contoh: BCA, BNI, Dana, OVO" required>
                </div>

                <div class="form-group">
                  <label for="">Nomor Rekening</label>
                  <input type="number" name="no_rekening" class="form-control" placeholder="Masukan Nomor Rekening" required>
                </div>

                <div class="form-group">
                  <label for="">Atas Nama Pemilik</label>
                  <input type="text" name="atas_nama" class="form-control" placeholder="Atas nama di buku tabungan" required>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-tambah-rek" type="submit" class="btn btn-primary">Simpan</button>
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
              <h4 class="modal-title">Edit Rekening Admin</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit_rek.php" method="post">
            <div class="modal-body">   
                <input type="hidden" name="id_rek_admin">
                
                <div class="form-group">
                  <label for="">Nama Bank / E-Wallet</label>
                  <input type="text" name="nama_bank" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="">Nomor Rekening</label>
                  <input type="number" name="no_rekening" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="">Atas Nama Pemilik</label>
                  <input type="text" name="atas_nama" class="form-control" required>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-edit-rek" type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
            </form>
          </div>
        </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>

<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    // Menangkap data dari tombol yang diklik (disesuaikan dengan nama kolom DB)
    var id_rek_admin = $(e.relatedTarget).data('id_rek_admin');
    var nama_bank = $(e.relatedTarget).data('nama_bank');
    var no_rekening = $(e.relatedTarget).data('no_rekening');
    var atas_nama = $(e.relatedTarget).data('atas_nama');
    
    // Memasukkan data ke dalam input modal edit
    $(e.currentTarget).find('input[name="id_rek_admin"]').val(id_rek_admin);
    $(e.currentTarget).find('input[name="nama_bank"]').val(nama_bank);
    $(e.currentTarget).find('input[name="no_rekening"]').val(no_rekening);
    $(e.currentTarget).find('input[name="atas_nama"]').val(atas_nama);
  });
</script>
</body>
</html>