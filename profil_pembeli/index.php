<?php
require_once '../database/koneksi.php';

$halaman = 'profil';
$id_pembeli = $_SESSION['id_user']; 

// Mengambil data user yang sedang login
$query = mysqli_query($db, "SELECT * FROM users WHERE id_user = '$id_pembeli'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profil & Alamat - MeowMart</title>

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
            <h1 class="m-0">Pengaturan Profil & Alamat</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Lengkapi Data Pengiriman Anda</h3>
              </div>
              
              <form action="proses_edit_profil.php" method="post">
                <div class="card-body">
                  <div class="alert alert-info">
                    Pastikan Nomor Handphone dan Alamat Pengiriman diisi dengan lengkap dan benar agar pesanan hewan peliharaan Anda sampai dengan selamat.
                  </div>

                  <!-- ID User tersembunyi -->
                  <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                  </div>

                  <div class="form-group">
                    <label>Username (Untuk Login)</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" readonly>
                    <small class="text-muted">Username tidak dapat diubah.</small>
                  </div>

                  <div class="form-group">
                    <label>Nomor Handphone (Aktif / WhatsApp)</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp'] ?? ''; ?>" placeholder="Contoh: 081234567890" required>
                  </div>

                  <div class="form-group">
                    <label>Alamat Lengkap Pengiriman</label>
                    <textarea name="alamat" class="form-control" rows="4" placeholder="Sertakan Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota, dan Kode Pos" required><?= $data['alamat'] ?? ''; ?></textarea>
                  </div>

                  <hr>
                  <div class="form-group">
                    <label>Ganti Password (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password baru jika ingin diganti">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" name="btn-simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
              </form>
              
            </div>
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