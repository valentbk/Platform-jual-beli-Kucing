<?php
require_once '../database/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'PB') {
    echo '<script>alert("Akses ditolak!"); window.location.href="../login.php";</script>';
    exit;
}

if (isset($_GET['id'])) {
    $id_keranjang = $_GET['id'];
    $id_user = $_SESSION['id_user'];

    $query_hapus = mysqli_query($db, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang' AND id_user = '$id_user'");

    if ($query_hapus) {
        echo '<script>window.location.href="../keranjang_pembeli/index.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus! Error: ' . mysqli_error($db) . '"); window.location.href="../keranjang_pembeli/index.php";</script>';
    }
} else {
    echo '<script>window.location.href="../keranjang_pembeli/index.php";</script>';
}
?>