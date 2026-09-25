<?php
require_once '../database/koneksi.php';

$halaman = 'katalog';
$id_pembeli = $_SESSION['id_user'] ?? '';

if (!isset($_GET['nama_kucing'])) {
    echo '<script>window.location.href="index.php"</script>';
    exit;
}

$nama_kucing_get = mysqli_real_escape_string($db, $_GET['nama_kucing']);

// 1. Ambil data kucing
$query_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE nama_kucing = '$nama_kucing_get' AND status_jual = 'TS' AND status_validasi = 'V'");
$data = mysqli_fetch_assoc($query_kucing);

if (!$data) {
    echo '<script>alert("Kucing tidak ditemukan atau sudah terjual!"); window.location.href="index.php"</script>';
    exit;
}

$id_kucing = $data['id_kucing'];
$harga = $data['harga'];

// Ambil nama ras
$id_ras = $data['id_ras'];
$q_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
$d_ras = mysqli_fetch_assoc($q_ras);
$nama_ras = $d_ras['nama_ras'] ?? 'Lainnya';

// 2. Ambil data pembeli (Untuk menampilkan alamat pengiriman)
$q_pembeli = mysqli_query($db, "SELECT nama, no_hp, alamat FROM users WHERE id_user = '$id_pembeli'");
$d_pembeli = mysqli_fetch_assoc($q_pembeli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - MeowMart</title>
  <?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
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

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">MeowMart</span>
    </a>
    <div class="sidebar">
      <?php include '../sidebar_pembeli.php'; ?>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Pembelian (Checkout)</h1>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- Informasi Kucing (Kiri) -->
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Informasi Hewan</h3>
              </div>
              <div class="card-body box-profile">
                <h3 class="profile-username text-center"><?= $data['nama_kucing']; ?></h3>
                <p class="text-muted text-center"><?= $nama_ras; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Jenis Kelamin</b> <a class="float-right"><?= ($data['jenis_kelamin'] == 'J') ? 'Jantan' : 'Betina'; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Umur</b> <a class="float-right"><?= $data['umur_bulan']; ?> Bulan</a>
                  </li>
                  <li class="list-group-item">
                    <b>Sertifikat / Vaksin</b> 
                    <a class="float-right">
                        <?php if(!empty($data['file_kesehatan'])) { ?>
                            <a href="../data_master/pdf/<?= $data['file_kesehatan']; ?>" target="_blank" class="badge badge-info float-right"><i class="fas fa-file-pdf"></i> Lihat File</a>
                        <?php } else { echo '<span class="text-muted float-right">Tidak ada file</span>'; } ?>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Harga (Total Bayar)</b> <a class="float-right text-success font-weight-bold" style="font-size: 20px;">Rp <?= number_format($harga, 0, ',', '.'); ?></a>
                  </li>
                </ul>

                <strong><i class="fas fa-file-alt mr-1"></i> Deskripsi Penjual:</strong>
                <p class="text-muted mt-2 border p-2 bg-light">
                  <?= nl2br($data['deskripsi']); ?>
                </p>
              </div>
            </div>
          </div>

          <!-- Form Pembayaran & Pengiriman (Kanan) -->
          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Pembayaran & Pengiriman</h3>
              </div>
              <form action="proses_beli.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  
                  <div class="alert alert-info alert-dismissible">
                    <h5><i class="icon fas fa-info"></i> Alamat Pengiriman</h5>
                    Pastikan alamat Anda di bawah ini sudah lengkap. Jika salah, ubah di menu Profil terlebih dahulu.
                  </div>
                  
                  <p>
                    <strong>Penerima:</strong> <?= $d_pembeli['nama']; ?> (<?= $d_pembeli['no_hp'] ?? '-'; ?>)<br>
                    <strong>Alamat:</strong> <?= $d_pembeli['alamat'] ?? 'Belum diisi!'; ?>
                  </p>

                  <hr>
                  
                  <h5 class="text-danger font-weight-bold">Langkah Pembayaran (Escrow):</h5>
                  <p>1. Silakan transfer senilai <strong>Rp <?= number_format($harga, 0, ',', '.'); ?></strong> ke salah satu rekening Admin MeowMart berikut ini:</p>
                  
                  <!-- Menampilkan List Rekening Admin -->
                  <div class="row">
                    <?php 
                    $q_rek_admin = mysqli_query($db, "SELECT * FROM rekening_admin");
                    while($r_admin = mysqli_fetch_assoc($q_rek_admin)) {
                    ?>
                    <div class="col-sm-6 mb-2">
                        <div class="border p-2 bg-light text-center">
                            <b><?= $r_admin['nama_bank']; ?></b><br>
                            <span class="text-primary font-weight-bold"><?= $r_admin['no_rekening']; ?></span><br>
                            <small>a.n <?= $r_admin['atas_nama']; ?></small>
                        </div>
                    </div>
                    <?php } ?>
                  </div>

                  <p class="mt-3">2. Setelah transfer, foto/screenshot struk dan unggah di bawah ini:</p>

                  <!-- Input Hidden untuk diproses -->
                  <input type="hidden" name="id_kucing" value="<?= $id_kucing; ?>">
                  <input type="hidden" name="total_bayar" value="<?= $harga; ?>">

                  <div class="form-group">
                    <label>Upload Bukti Transfer (JPG/PNG)</label>
                    <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
                  </div>
                  
                </div>
                <div class="card-footer">
                  <a href="index.php" class="btn btn-default">Batal</a>
                  <button type="submit" name="btn-beli" class="btn btn-success float-right" onclick="return confirm('Apakah Anda yakin data transfer sudah benar?')">Beli & Konfirmasi Pembayaran</button>
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