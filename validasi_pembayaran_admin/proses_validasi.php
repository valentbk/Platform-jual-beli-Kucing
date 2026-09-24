<?php
session_start();
require_once '../database/koneksi.php';

// Pastikan yang mengakses adalah Admin
if ($_SESSION['role'] != 'A') {
    echo '<script>window.location.href="../logout.php"</script>';
    exit;
}

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id_transaksi = mysqli_real_escape_string($db, $_GET['id']);
    $aksi = mysqli_real_escape_string($db, $_GET['aksi']);

    if ($aksi == 'valid') {
        // Jika valid, ubah status menjadi Diproses (Penjual harus kirim)
        $update = mysqli_query($db, "UPDATE transaksi SET status_transaksi = 'Diproses' WHERE id_transaksi = '$id_transaksi'");
        if ($update) {
            echo "<script>alert('Pembayaran divalidasi! Pesanan diteruskan ke penjual.'); window.location.href='validasi_pembayaran.php';</script>";
        }
    } elseif ($aksi == 'tolak') {
        // Jika ditolak, kembalikan status menjadi Batal atau Belum Bayar
        $update = mysqli_query($db, "UPDATE transaksi SET status_transaksi = 'Batal' WHERE id_transaksi = '$id_transaksi'");
        if ($update) {
            echo "<script>alert('Pembayaran ditolak!'); window.location.href='validasi_pembayaran.php';</script>";
        }
    }
}
?>