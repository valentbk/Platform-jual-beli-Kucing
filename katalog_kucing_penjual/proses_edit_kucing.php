<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    
    // Menangkap data perubahan
    $id_kucing = trim(mysqli_real_escape_string($db, $_POST['id_kucing']));
    $id_ras = trim(mysqli_real_escape_string($db, $_POST['id_ras']));
    $jenis_kelamin = trim(mysqli_real_escape_string($db, $_POST['jenis_kelamin']));
    $umur_bulan = trim(mysqli_real_escape_string($db, $_POST['umur_bulan']));
    $harga = trim(mysqli_real_escape_string($db, $_POST['harga']));
    $deskripsi = trim(mysqli_real_escape_string($db, $_POST['deskripsi']));
    $file_lama = trim(mysqli_real_escape_string($db, $_POST['file_kesehatan_lama']));
    
    $nama_file_kesehatan = $file_lama; 

    // Proses Upload PDF Baru (Jika ada)
    if (isset($_FILES['file_kesehatan']) && $_FILES['file_kesehatan']['error'] === 0) {
        $fileName = $_FILES['file_kesehatan']['name'];
        $fileTmp  = $_FILES['file_kesehatan']['tmp_name'];
        
        $targetDir = "../../admin/pdf/"; 
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileExtension == 'pdf') {
            $nama_file_kesehatan = time() . '_' . $fileName;
            $targetFile = $targetDir . $nama_file_kesehatan;
            
            if (move_uploaded_file($fileTmp, $targetFile)) {
                // Hapus file lama jika upload file baru sukses
                if (!empty($file_lama) && file_exists($targetDir . $file_lama)) {
                    unlink($targetDir . $file_lama);
                }
            } else {
                echo "<script>alert('Gagal mengupload file PDF!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('File sertifikat harus berformat PDF!'); window.history.back();</script>";
            exit;
        }
    }
    
    // Query Update Data
    // Catatan: status_validasi direset menjadi 'P' setiap kali penjual melakukan edit data
    $query = "UPDATE kucing SET 
                id_ras = '$id_ras',
                jenis_kelamin = '$jenis_kelamin',
                umur_bulan = '$umur_bulan',
                harga = '$harga',
                deskripsi = '$deskripsi',
                file_kesehatan = '$nama_file_kesehatan',
                status_validasi = 'P' 
              WHERE id_kucing = '$id_kucing'";
              
    $query_update = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_update) {
        echo '<script>alert("Data berhasil diubah! Status kembali Pending untuk divalidasi ulang oleh Admin.")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengubah data!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>