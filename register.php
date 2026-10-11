<?php
require_once 'database/koneksi.php';

if (isset($_POST['btn-register'])) {
    $nama = mysqli_real_escape_string($db, $_POST['nama']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $role = mysqli_real_escape_string($db, $_POST['role']); 
    // Menangkap data no_hp dan alamat dari form
    $no_hp = mysqli_real_escape_string($db, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);

    // Cek apakah email sudah terdaftar
    $cek_user = mysqli_query($db, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Email sudah terdaftar! Silakan gunakan email lain.'); window.history.back();</script>";
        exit;
    }

    $password_hash = sha1($password);

    // Masukkan data ke database dengan variabel $no_hp dan $alamat, beserta PIN default '123'
    $query_insert = "INSERT INTO users (nama, email, password, role, no_hp, alamat, pin) 
                     VALUES ('$nama', '$email', '$password_hash', '$role', '$no_hp', '$alamat', '123')";
    $eksekusi = mysqli_query($db, $query_insert);

    if ($eksekusi) {
        echo "<script>alert('Registrasi Berhasil! Silakan Login menggunakan akun Anda.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Registrasi Gagal! Pastikan koneksi database aman.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Akun - MeowMart</title>

  <!-- Menggunakan CSS bawaan AdminLTE -->
  <link rel="stylesheet" href="asset_adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="asset_adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 400px;"> <!-- Lebar sedikit ditambah agar form alamat terlihat rapi -->
  <div class="register-logo">
    <a href="#"><b>Meow</b>Mart</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Daftar sebagai member baru</p>

      <form action="register.php" method="post">
        
        <div class="input-group mb-3">
          <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email (Untuk Login)" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <!-- Input Form Tambahan: Nomor HP -->
        <div class="input-group mb-3">
          <input type="text" name="no_hp" class="form-control" placeholder="Nomor HP / WhatsApp" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>

        <!-- Input Form Tambahan: Alamat -->
        <div class="input-group mb-3">
          <textarea name="alamat" class="form-control" placeholder="Alamat Lengkap" rows="2" required></textarea>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <select name="role" class="form-control" required>
            <option value="">-- Pilih Tujuan Anda --</option>
            <option value="PB">Ingin Membeli Kucing</option>
            <option value="PJ">Ingin Menjual Kucing</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-users"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" name="btn-register" class="btn btn-primary btn-block">Daftar Akun</button>
          </div>
        </div>

      </form>

      <div class="text-center mt-3">
          <a href="index.php" class="text-center">Saya sudah punya akun (Masuk di sini)</a>
      </div>
    </div>
  </div>
</div>

<script src="asset_adminlte/plugins/jquery/jquery.min.js"></script>
<script src="asset_adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="asset_adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>