<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-tarik'])) {
    
    $id_penjual = trim(mysqli_real_escape_string($db, $_POST['id_penjual']));
    $id_rek_penjual = trim(mysqli_real_escape_string($db, $_POST['id_rek_penjual']));
    $nominal = trim(mysqli_real_escape_string($db, $_POST['nominal']));
    
    // Status awal selalu 'Pending'
    $status_penarikan = 'Pending';
    
    // Insert pengajuan ke database
    $query = "INSERT INTO penarikan_dana (id_penjual, id_rek_penjual, nominal, status_penarikan) 
              VALUES ('$id_penjual', '$id_rek_penjual', '$nominal', '$status_penarikan')";
              
    $eksekusi = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Pengajuan Penarikan Dana berhasil dikirim! Silakan tunggu proses dari Admin.")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengajukan penarikan dana!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>