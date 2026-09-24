<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    $id_penjual = trim(mysqli_real_escape_string($db, $_POST['id_penjual']));
    $nama_bank = trim(mysqli_real_escape_string($db, $_POST['nama_bank']));
    $no_rekening = trim(mysqli_real_escape_string($db, $_POST['no_rekening']));
    $atas_nama = trim(mysqli_real_escape_string($db, $_POST['atas_nama']));

    $query = "INSERT INTO rekening_penjual (id_penjual, nama_bank, no_rekening, atas_nama) 
              VALUES ('$id_penjual', '$nama_bank', '$no_rekening', '$atas_nama')";
              
    $eksekusi = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Tambah Rekening Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal menambahkan rekening!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>