<?php 

require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $nama = trim(mysqli_real_escape_string($db,$_POST['nama']));
    $email = trim(mysqli_real_escape_string($db,$_POST['email']));
    $role = trim(mysqli_real_escape_string($db,$_POST['role']));
    $no_hp = trim(mysqli_real_escape_string($db,$_POST['no_hp']));
    $alamat = trim(mysqli_real_escape_string($db,$_POST['alamat']));
    $id_user = trim(mysqli_real_escape_string($db,$_POST['id_user']));

    $query_edit_pengguna = mysqli_query($db,"UPDATE users SET 
        nama = '$nama',
        email ='$email',
        role = '$role',
        no_hp = '$no_hp',
        alamat = '$alamat'
        WHERE id_user='$id_user'") or die(mysqli_error($db));
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_user_admin"</script>';
    
}
?>