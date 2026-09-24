<?php 

require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    $nama = trim(mysqli_real_escape_string($db,$_POST['nama']));
    $email = trim(mysqli_real_escape_string($db,$_POST['email']));
    $role = trim(mysqli_real_escape_string($db,$_POST['role']));
    $no_hp = trim(mysqli_real_escape_string($db,$_POST['no_hp']));
    $alamat = trim(mysqli_real_escape_string($db,$_POST['alamat']));
    $pin = "12345";
    $password = sha1($nama);

    $query_cek_nama = mysqli_query($db, "SELECT nama FROM users WHERE nama ='$nama'") or die (mysqli_error($db));
    $rv = mysqli_num_rows($query_cek_nama);
    if ($rv > 0) {
        echo '<script>alert ("Data User sudah ada")</script>';
        echo '<script>window.location.href="../data_user_admin"</script>';
        }else {
            $query_simpan = mysqli_query($db, "INSERT INTO users VALUES (NULL,'$nama','$email','$password','$role','$no_hp', '$alamat', NOW(), '$pin')") or die (mysqli_error($db));
            echo '<script>alert ("Tambah Data Berhasil")</script>';
            echo '<script>window.location.href="../data_user_admin"</script>';
        }
    }


?>