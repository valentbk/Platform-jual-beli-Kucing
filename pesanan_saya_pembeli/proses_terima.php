<?php 
require_once '../database/koneksi.php';

if (isset($_GET['id'])) {
    $id_transaksi = mysqli_real_escape_string($db, $_GET['id']);
    
    // Ubah status menjadi Selesai
    $query = "UPDATE transaksi SET status_transaksi = 'Selesai' WHERE id_transaksi = '$id_transaksi'";
    $eksekusi = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Terima kasih! Pesanan telah dikonfirmasi selesai.")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengkonfirmasi pesanan!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>