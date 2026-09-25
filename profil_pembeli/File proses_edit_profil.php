<?php 
require_once '../database/koneksi.php';
session_start();

if (isset($_POST['btn-simpan'])) {
    
    $id_user = trim(mysqli_real_escape_string($db, $_POST['id_user']));
    $nama = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $no_hp = trim(mysqli_real_escape_string($db, $_POST['no_hp']));
    $alamat = trim(mysqli_real_escape_string($db, $_POST['alamat']));
    $password = trim($_POST['password']);
    
    $query = "";

    // Cek apakah pembeli juga mengisi kolom password baru
    if (!empty($password)) {
        // Jika password diisi, ikut di-update. 
        // Asumsi menggunakan md5() untuk password seperti standar tutorial pada umumnya. Sesuaikan jika kamu pakai password_hash()
        $password_hash = md5($password); 
        
        $query = "UPDATE users SET 
                    nama = '$nama', 
                    no_hp = '$no_hp', 
                    alamat = '$alamat',
                    password = '$password_hash'
                  WHERE id_user = '$id_user'";
    } else {
        // Jika password kosong, jangan update kolom password
        $query = "UPDATE users SET 
                    nama = '$nama', 
                    no_hp = '$no_hp', 
                    alamat = '$alamat'
                  WHERE id_user = '$id_user'";
    }
              
    $eksekusi = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if ($eksekusi) {
        // Update session nama agar nama di pojok kanan atas navbar langsung berubah tanpa perlu relogin
        $_SESSION['nama'] = $nama; 
        
        echo '<script>alert("Profil dan Alamat berhasil diperbarui!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal memperbarui profil!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>