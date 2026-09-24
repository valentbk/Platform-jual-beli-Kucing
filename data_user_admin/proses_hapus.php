<?php 
require_once '../database/koneksi.php';

$id_user = $_GET['id_user'];


if (isset($id_user)) {

$query_hapus =mysqli_query($db,"DELETE FROM users WHERE id_user ='$id_user'") or die(mysqli_error($db));
    echo '<script>alert ("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_user_admin"</script>';
}

?>