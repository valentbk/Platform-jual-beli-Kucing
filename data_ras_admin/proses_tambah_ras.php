<?php 

require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    $nama_ras = trim(mysqli_real_escape_string($db,$_POST['nama_ras']));

    $query_cek_nama = mysqli_query($db, "SELECT nama_ras FROM kategori_ras WHERE nama_ras ='$nama_ras'") or die (mysqli_error($db));
    $rv = mysqli_num_rows($query_cek_nama);
    if ($rv > 0) {
        echo '<script>alert ("Data Ras sudah ada")</script>';
        echo '<script>window.location.href="../data_ras_admin"</script>';
        }else {
            $query_simpan = mysqli_query($db, "INSERT INTO kategori_ras VALUES (NULL,'$nama_ras')") or die (mysqli_error($db));
            echo '<script>alert ("Tambah Data Ras Berhasil")</script>';
            echo '<script>window.location.href="../data_ras_admin"</script>';
        }
    }


?>