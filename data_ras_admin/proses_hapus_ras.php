<?php 
require_once '../database/koneksi.php';

$id_ras = $_GET['id_ras'];


if (isset($id_ras)) {

$query_hapus =mysqli_query($db,"DELETE FROM kategori_ras WHERE id_ras ='$id_ras'") or die(mysqli_error($db));
    echo '<script>alert ("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_ras_admin"</script>';
}

?>