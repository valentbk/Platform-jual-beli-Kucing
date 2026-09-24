<?php 

require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $id_ras = trim(mysqli_real_escape_string($db,$_POST['id_ras']));
    $nama_ras = trim(mysqli_real_escape_string($db,$_POST['nama_ras']));

    $query_edit_pengguna = mysqli_query($db,"UPDATE kategori_ras SET 
        nama_ras = '$nama_ras'
        WHERE id_ras='$id_ras'") or die(mysqli_error($db));
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_ras_admin"</script>';
    
}
?>