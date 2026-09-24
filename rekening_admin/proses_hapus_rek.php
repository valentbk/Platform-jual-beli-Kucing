<?php 
require_once '../database/koneksi.php';

if (isset($_GET['id'])) {
    $id_rek_admin = mysqli_real_escape_string($db, $_GET['id']);
    
    $query = "DELETE FROM rekening_admin WHERE id_rek_admin = '$id_rek_admin'";
    $query_hapus = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_hapus) {
        echo '<script>alert("Hapus Data Rekening Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal menghapus data rekening!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>