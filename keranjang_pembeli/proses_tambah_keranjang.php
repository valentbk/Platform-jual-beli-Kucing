<?php
require_once '../database/koneksi.php';

// Pastikan pembeli sudah login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'PB') {
    echo '<script>alert("Akses ditolak! Silakan login terlebih dahulu."); window.location.href="../login.php";</script>';
    exit;
}

if (isset($_POST['tambah_keranjang'])) {
    $id_user = $_SESSION['id_user'];
    $id_kucing = $_POST['id_kucing'];

    // Cek apakah kucing ini sudah ada di keranjang user
    $cek = mysqli_query($db, "SELECT id_keranjang FROM keranjang WHERE id_user = '$id_user' AND id_kucing = '$id_kucing'");
    
    if (mysqli_num_rows($cek) > 0) {
        echo '<script>alert("Kucing ini sudah ada di keranjang Anda!"); window.location.href="../index.php";</script>';
    } else {
        // Jika belum ada, masukkan ke database
        $query_insert = mysqli_query($db, "INSERT INTO keranjang (id_user, id_kucing) VALUES ('$id_user', '$id_kucing')");
        
        if ($query_insert) {
            echo '<script>alert("Berhasil dimasukkan ke keranjang!"); window.location.href="../index.php";</script>';
        } else {
            echo '<script>alert("Gagal memasukkan ke keranjang. Error: ' . mysqli_error($db) . '"); window.location.href="../index.php";</script>';
        }
    }
}
?>