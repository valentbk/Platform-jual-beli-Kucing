<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-kirim'])) {
    $id_transaksi = trim(mysqli_real_escape_string($db, $_POST['id_transaksi']));
    $no_resi = trim(mysqli_real_escape_string($db, $_POST['no_resi']));
    
    // Update status transaksi menjadi 'Dikirim' dan simpan nomor resinya
    $query = "UPDATE transaksi SET 
                status_transaksi = 'Dikirim',
                no_resi_pengiriman = '$no_resi'
              WHERE id_transaksi = '$id_transaksi'";
              
    $eksekusi = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Pesanan berhasil diupdate menjadi DIKIRIM!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal memproses pengiriman!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>