<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $id_rek_penjual = trim(mysqli_real_escape_string($db, $_POST['id_rek_penjual']));
    $nama_bank = trim(mysqli_real_escape_string($db, $_POST['nama_bank']));
    $no_rekening = trim(mysqli_real_escape_string($db, $_POST['no_rekening']));
    $atas_nama = trim(mysqli_real_escape_string($db, $_POST['atas_nama']));

    $query = "UPDATE rekening_penjual SET 
                nama_bank = '$nama_bank', 
                no_rekening = '$no_rekening', 
                atas_nama = '$atas_nama' 
              WHERE id_rek_penjual = '$id_rek_penjual'";
              
    $eksekusi = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Ubah Rekening Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengubah rekening!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>