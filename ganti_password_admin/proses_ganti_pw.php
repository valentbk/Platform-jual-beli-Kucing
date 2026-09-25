<?php 

require_once '../database/koneksi.php'; // memanggil koneksi database

if (isset($_POST['btn-ganti'])) { // cek tombol ketika ditekan
    // menampung data dari input
    $nama  = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $pw_baru   = trim(mysqli_real_escape_string($db, $_POST['password']));
    $c_password = trim(mysqli_real_escape_string($db, $_POST['konfirmasi_password']));

    if ($pw_baru == $c_password) {
        $pw_enkripsi = sha1($pw_baru);
        $query_ganti_password = mysqli_query($db, "UPDATE users SET
        password = '$pw_enkripsi'
        WHERE nama = '$nama'
        ") or die(mysqli_error($db));
        echo '<script>alert("Ganti Password Berhasil");</script>';
        echo '<script>window.location.href="../logout.php";</script>';
    }else {
        echo '<script>alert("Password Baru dan Konfirmasi Password Tidak Sama");</script>';
        echo '<script>window.location.href="index.php";</script>';
    }
    
    
}

?>