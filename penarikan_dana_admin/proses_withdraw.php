<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-proses-wd'])) {
    
    $id_penarikan = trim(mysqli_real_escape_string($db, $_POST['id_penarikan']));
    $status_penarikan = trim(mysqli_real_escape_string($db, $_POST['status_penarikan']));
    
    $nama_file_bukti = '';
    $query_update = "";
    
    // Cek apakah Admin mengunggah file bukti transfer
    if (isset($_FILES['bukti_transfer_admin']) && $_FILES['bukti_transfer_admin']['error'] === 0) {
        $fileName = $_FILES['bukti_transfer_admin']['name'];
        $fileTmp  = $_FILES['bukti_transfer_admin']['tmp_name'];
        $fileSize = $_FILES['bukti_transfer_admin']['size'];
        
        $targetDir = "../bukti_withdraw/";
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            if ($fileSize < 5000000) {
                $nama_file_bukti = time() . '_' . $fileName;
                $targetFile = $targetDir . $nama_file_bukti;
                
                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $query_update = "UPDATE penarikan_dana SET 
                                     status_penarikan = '$status_penarikan', 
                                     bukti_transfer_admin = '$nama_file_bukti' 
                                     WHERE id_penarikan = '$id_penarikan'";
                } else {
                    echo "<script>alert('Gagal mengupload bukti transfer!'); window.history.back();</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Ukuran foto terlalu besar! Maksimal 5MB.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file salah! Harus berupa JPG, JPEG, atau PNG.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Jika admin tidak mengunggah gambar (Misal karena statusnya 'Ditolak')
        if ($status_penarikan == 'Sukses') {
            echo "<script>alert('Status Sukses wajib melampirkan Bukti Transfer!'); window.history.back();</script>";
            exit;
        } else {
            // Update status saja tanpa file
            $query_update = "UPDATE penarikan_dana SET 
                             status_penarikan = '$status_penarikan' 
                             WHERE id_penarikan = '$id_penarikan'";
        }
    }
    
    if (!empty($query_update)) {
        $eksekusi = mysqli_query($db, $query_update) or die(mysqli_error($db));
        if ($eksekusi) {
            echo '<script>alert("Proses Penarikan Dana Berhasil Disimpan!")</script>';
            echo '<script>window.location.href="index.php"</script>'; 
        } else {
            echo '<script>alert("Gagal memproses penarikan dana!")</script>';
            echo '<script>window.history.back()</script>';
        }
    }
}
?>