<?php
require_once 'database/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$halaman = 'katalog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Katalog Kucing - MeowMart</title>

<?php
include 'library_root.php'; 
?>
<style>
  .cat-image-container {
    height: 150px;
    width: 100%;
    background-color: #f4f6f9;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 5px;
    margin-bottom: 15px;
  }
  .cat-image-container i {
    font-size: 5rem;
    color: #adb5bd;
  }
</style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <i class="fas fa-cat text-primary"></i>
        <span class="brand-text font-weight-light"><b>Meow</b>Mart</span>
      </a>

      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        
        <?php if(isset($_SESSION['id_user']) && $_SESSION['role'] == 'PB') { 
            $id_user_login = $_SESSION['id_user'];
            $q_keranjang = mysqli_query($db, "SELECT COUNT(id_keranjang) AS jumlah_keranjang FROM keranjang WHERE id_user = '$id_user_login'");
            $d_keranjang = mysqli_fetch_assoc($q_keranjang);
            $jumlah_keranjang = $d_keranjang['jumlah_keranjang'];
        ?>
            <li class="nav-item">
              <a class="nav-link" href="keranjang_pembeli/index.php">
                <i class="fas fa-shopping-cart"></i>
                <?php if($jumlah_keranjang > 0) { ?>
                    <span class="badge badge-danger navbar-badge"><?= $jumlah_keranjang; ?></span>
                <?php } ?>
              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                Hallo, <?= $_SESSION['nama']; ?> <i class="far fa-user"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="logout.php" class="dropdown-item">
                  <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
                </a>
              </div>
            </li>
        <?php } else { ?>
            <!-- jika belum login -->
            <li class="nav-item">
              <a href="login.php" class="btn btn-outline-primary btn-sm mt-1">Masuk</a>
              <a href="register.php" class="btn btn-primary btn-sm mt-1 ml-2">Daftar</a>
            </li>
        <?php } ?>
        
      </ul>
    </div>
  </nav>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Etalase <small>Kucing Pilihan</small></h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        
        <div class="row">
          <?php 
          $query_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE status_jual = 'TS' AND status_validasi = 'V' ORDER BY id_kucing DESC") or die (mysqli_error($db));

          $rv = mysqli_num_rows($query_kucing);
          if ($rv > 0) {
              while ($data = mysqli_fetch_array($query_kucing)) {
                  $id_kucing = $data['id_kucing'];
                  $nama_kucing = $data['nama_kucing'];
                  $id_ras = $data['id_ras'];
                  $jenis_kelamin = $data['jenis_kelamin'];
                  $umur_bulan = $data['umur_bulan'];
                  $harga = $data['harga'];
                  
                  $q_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
                  $d_ras = mysqli_fetch_assoc($q_ras);
                  $nama_ras = $d_ras['nama_ras'] ?? 'Lainnya';
                  ?>
                  
                  <!-- Kotak Produk -->
                  <div class="col-md-3 col-sm-6 col-6 d-flex align-items-stretch">
                    <div class="card card-primary card-outline w-100">
                      <div class="card-body box-profile">
                        
                        <div class="cat-image-container">
                          <?php 
                          if (!empty($data['foto_kucing'])) { 
                          ?>
                              <img src="asset_adminlte/img/<?= $data['foto_kucing']; ?>" alt="<?= $nama_kucing; ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">
                          <?php 
                          } else { 
                          ?>
                              <i class="fas fa-cat"></i> 
                          <?php 
                          } 
                          ?>
                        </div>

                        <h3 class="profile-username text-center"><?= $nama_kucing; ?></h3>
                        <p class="text-muted text-center"><?= $nama_ras; ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                            <b>Kelamin</b> <a class="float-right"><?= ($jenis_kelamin == 'J') ? 'Jantan' : 'Betina'; ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Umur</b> <a class="float-right"><?= $umur_bulan; ?> Bulan</a>
                          </li>
                          <li class="list-group-item text-center">
                            <h4 class="text-success font-weight-bold mt-2 mb-0">Rp <?= number_format($harga, 0, ',', '.'); ?></h4>
                          </li>
                        </ul>

                        <!-- Logika Proteksi Tombol Beli & Masukkan Keranjang -->
                        <?php if(isset($_SESSION['id_user']) && $_SESSION['role'] == 'PB') { ?>
                            <div class="row">
                                <div class="col-6">
                                    <a href="katalog_pembeli/detail_beli.php?nama_kucing=<?= urlencode($nama_kucing); ?>" class="btn btn-info btn-block btn-sm">
                                      <b>Detail</b>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <!-- Form untuk memasukkan ke keranjang -->
                                    <form action="keranjang_pembeli/proses_tambah_keranjang.php" method="POST">
                                        <input type="hidden" name="id_kucing" value="<?= $id_kucing; ?>">
                                        <button type="submit" name="tambah_keranjang" class="btn btn-primary btn-block btn-sm">
                                            <b><i class="fas fa-cart-plus"></i> Masukkan</b>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a href="login.php" onclick="alert('Silakan Masuk atau Daftar sebagai Pembeli terlebih dahulu untuk melakukan transaksi!');" class="btn btn-primary btn-block">
                              <b><i class="fas fa-shopping-cart"></i> Beli Kucing</b>
                            </a>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                  <?php
              }
          } else {
              echo '
              <div class="col-12">
                <div class="alert alert-info">
                  <h5><i class="icon fas fa-info"></i> Mohon Maaf!</h5>
                  Saat ini belum ada data kucing yang tersedia untuk dibeli. Silakan kembali lagi nanti.
                </div>
              </div>';
          }
          ?>
        </div> <!-- /.row -->

      </div>
    </div>
  </div>

  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2026 MeowMart.</strong> All rights reserved.
  </footer>
</div>

<?php 
include 'script_root.php'; 
?>
</body>
</html>