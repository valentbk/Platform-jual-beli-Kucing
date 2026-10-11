<?php
require_once '../database/koneksi.php';

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id_transaksi = mysqli_real_escape_string($db, $_GET['id']);
    $aksi = mysqli_real_escape_string($db, $_GET['aksi']);

    if ($aksi == 'valid') {
        
        // 1. Ambil id_kucing untuk mengamankan stok
        $q_transaksi = mysqli_query($db, "SELECT id_kucing FROM transaksi WHERE id_transaksi = '$id_transaksi'");
        $d_transaksi = mysqli_fetch_assoc($q_transaksi);
        
        if ($d_transaksi) {
            $id_kucing = $d_transaksi['id_kucing'];
            // 2. Ubah status kucing menjadi 'TJ' (Terjual) agar tidak tampil di katalog
            mysqli_query($db, "UPDATE kucing SET status_jual = 'TJ' WHERE id_kucing = '$id_kucing'");
        }

        // 3. Update status transaksi menjadi Diproses (Uang 100% masih ditahan Admin)
        $update = mysqli_query($db, "UPDATE transaksi SET status_transaksi = 'Diproses' WHERE id_transaksi = '$id_transaksi'");
        
        if ($update) {
            echo "<script>alert('Pembayaran divalidasi! Pesanan diteruskan ke penjual.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal memvalidasi pembayaran!'); window.location.href='index.php';</script>";
        }
        
    } elseif ($aksi == 'tolak') {
        $update = mysqli_query($db, "UPDATE transaksi SET status_transaksi = 'Belum Bayar' WHERE id_transaksi = '$id_transaksi'");
        
        if ($update) {
            echo "<script>alert('Pembayaran ditolak! Status dikembalikan menjadi Belum Bayar.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menolak pembayaran!'); window.location.href='index.php';</script>";
        }
    }
} else {
    echo "<script>window.location.href='index.php';</script>";
}
?>