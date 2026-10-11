<?php
require_once '../database/koneksi.php';

// Proteksi: Hanya pembeli yang sudah login yang bisa masuk
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'PB') {
    echo '<script>alert("Akses ditolak! Silakan login terlebih dahulu."); window.location.href="../login.php";</script>';
    exit;
}

$halaman = 'keranjang';
$id_user_login = $_SESSION['id_user'];

// 1. Ambil data pembeli untuk ditampilkan di Alamat Pengiriman
$q_pembeli = mysqli_query($db, "SELECT nama, no_hp, alamat FROM users WHERE id_user = '$id_user_login'");
$d_pembeli = mysqli_fetch_assoc($q_pembeli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keranjang Saya - MeowMart</title>
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
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../index.php" class="brand-link">
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
        <h1 class="m-0"><i class="fas fa-shopping-cart"></i> Keranjang Belanja Saya</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <!-- BAGIAN 1: TABEL KERANJANG -->
        <div class="card card-primary card-outline">
          <div class="card-body p-0 table-responsive">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kucing</th>
                  <th>Ras</th>
                  <th>Harga</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Ambil data keranjang
                $query_cart = mysqli_query($db, "SELECT * FROM keranjang WHERE id_user = '$id_user_login' ORDER BY tanggal_masuk DESC") or die(mysqli_error($db));

                $total_belanja = 0;
                $no = 1;

                if (mysqli_num_rows($query_cart) > 0) {
                    while ($data_keranjang = mysqli_fetch_array($query_cart)) {
                        $id_keranjang = $data_keranjang['id_keranjang'];
                        $id_kucing = $data_keranjang['id_kucing'];

                        $query_kucing = mysqli_query($db, "SELECT * FROM kucing WHERE id_kucing = '$id_kucing'");
                        $data_kucing = mysqli_fetch_assoc($query_kucing);

                        if ($data_kucing) {
                            $nama_kucing = $data_kucing['nama_kucing'];
                            $harga = $data_kucing['harga'];
                            $id_ras = $data_kucing['id_ras'];

                            $query_ras = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE id_ras = '$id_ras'");
                            $data_ras = mysqli_fetch_assoc($query_ras);
                            $nama_ras = $data_ras ? $data_ras['nama_ras'] : 'Lainnya';

                            $total_belanja += $harga;
                ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><b><?= $nama_kucing; ?></b></td>
                    <td><?= $nama_ras; ?></td>
                    <td>Rp <?= number_format($harga, 0, ',', '.'); ?></td>
                    <td class="text-center">
                      <a href="proses_hapus_keranjang.php?id=<?= $id_keranjang; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kucing ini dari keranjang?');">
                        <i class="fas fa-trash"></i> Hapus
                      </a>
                    </td>
                  </tr>
                <?php
                        } 
                    } 
                ?>
                  <tr class="bg-light">
                    <td colspan="3" class="text-right"><h4><b>Total Belanja:</b></h4></td>
                    <td colspan="2"><h4 class="text-success font-weight-bold">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></h4></td>
                  </tr>
                <?php
                } else {
                    echo '<tr><td colspan="5" class="text-center text-muted py-4">Keranjang Anda masih kosong. Yuk belanja kucing lucu di katalog!</td></tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
          <?php if (mysqli_num_rows($query_cart) == 0) { ?>
          <div class="card-footer text-right">
            <a href="../index.php" class="btn btn-primary"><i class="fas fa-cat"></i> Ke Katalog Kucing</a>
          </div>
          <?php } ?>
        </div>
        <!-- END BAGIAN 1 -->

        <!-- BAGIAN 2: FORM PEMBAYARAN (Hanya muncul jika keranjang tidak kosong) -->
        <?php if (mysqli_num_rows($query_cart) > 0) { ?>
        <div class="card card-success mt-4">
          <div class="card-header">
            <h3 class="card-title">Pembayaran & Pengiriman</h3>
          </div>
          <!-- Form ini sekarang mengarah ke proses_checkout_semua.php -->
          <form action="proses_checkout_semua.php" method="post" enctype="multipart/form-data">
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
              <p>1. Silakan transfer senilai <strong>Rp <?= number_format($total_belanja, 0, ',', '.'); ?></strong> ke salah satu rekening Admin MeowMart berikut ini:</p>
              
              <!-- List Rekening Admin -->
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

              <!-- Input Hidden untuk diproses di backend -->
              <input type="hidden" name="total_bayar_semua" value="<?= $total_belanja; ?>">

              <div class="form-group">
                <label>Upload Bukti Transfer (JPG/PNG)</label>
                <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
              </div>
              
            </div>
            <div class="card-footer">
              <a href="../index.php" class="btn btn-default"><i class="fas fa-arrow-left"></i> Lanjut Belanja</a>
              <button type="submit" name="btn-checkout" class="btn btn-success float-right" onclick="return confirm('Apakah Anda yakin data transfer sudah benar? Semua kucing di keranjang akan di-checkout.')">Beli & Konfirmasi Pembayaran</button>
            </div>
          </form>
        </div>
        <?php } ?>
        <!-- END BAGIAN 2 -->

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