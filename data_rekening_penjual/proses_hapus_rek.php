<?php 
require_once '../database/koneksi.php';

if (isset($_GET['id'])) {
    $id_rek_penjual = mysqli_real_escape_string($db, $_GET['id']);

    $query = "DELETE FROM rekening_penjual WHERE id_rek_penjual = '$id_rek_penjual'";
    $eksekusi = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Hapus Rekening Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal menghapus rekening!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>