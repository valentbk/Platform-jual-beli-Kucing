<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tarik'])) {
    
    $id_penjual      = trim(mysqli_real_escape_string($db, $_POST['id_penjual']));
    $id_rek_penjual  = trim(mysqli_real_escape_string($db, $_POST['id_rek_penjual']));
    $nominal         = trim(mysqli_real_escape_string($db, $_POST['nominal']));
    
    // 1. Validasi nominal harus angka positif
    if (!is_numeric($nominal) || $nominal <= 0) {
        echo '<script>alert("Nominal penarikan tidak valid!")</script>';
        echo '<script>window.history.back()</script>';
        exit;
    }

    // 2. Cek saldo penjual di tabel 'users' (BUKAN tabel 'penjual')
    $query_cek = "SELECT saldo FROM users WHERE id_user = '$id_penjual'";
    $result_cek = mysqli_query($db, $query_cek);
    
    if ($result_cek && mysqli_num_rows($result_cek) > 0) {
        $data_penjual = mysqli_fetch_assoc($result_cek);
        $saldo_sekarang = $data_penjual['saldo'];

        // Cek apakah saldo mencukupi
        if ($nominal > $saldo_sekarang) {
            echo '<script>alert("Gagal! Saldo Anda tidak mencukupi untuk penarikan ini.")</script>';
            echo '<script>window.history.back()</script>';
            exit;
        }
    } else {
        echo '<script>alert("Data penjual tidak ditemukan!")</script>';
        echo '<script>window.history.back()</script>';
        exit;
    }

    // Status awal selalu 'Pending'
    $status_penarikan = 'Pending';
    
    // 3. Insert pengajuan ke database
    $query = "INSERT INTO penarikan_dana (id_penjual, id_rek_penjual, nominal, status_penarikan, tanggal_pengajuan) 
              VALUES ('$id_penjual', '$id_rek_penjual', '$nominal', '$status_penarikan', NOW())";
              
    $eksekusi = mysqli_query($db, $query);
    
    if ($eksekusi) {
        // 4. POTONG SALDO PENJUAL (Wajib dieksekusi agar tidak bisa narik dobel)
        mysqli_query($db, "UPDATE users SET saldo = saldo - $nominal WHERE id_user = '$id_penjual'");

        echo '<script>alert("Pengajuan Penarikan Dana berhasil dikirim! Saldo telah dipotong, silakan tunggu proses transfer dari Admin.")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengajukan penarikan dana: ' . mysqli_error($db) . '")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>