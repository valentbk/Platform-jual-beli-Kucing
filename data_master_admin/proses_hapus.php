<?php 
require_once '../database/koneksi.php';

$nama_kucing = $_GET['nama_kucing'];


if (isset($nama_kucing)) {

$query_hapus =mysqli_query($db,"DELETE FROM kucing WHERE nama_kucing ='$nama_kucing'") or die(mysqli_error($db));
    echo '<script>alert ("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_master_admin"</script>';
}

?>