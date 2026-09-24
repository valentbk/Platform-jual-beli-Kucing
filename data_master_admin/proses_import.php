<?php

require_once '../database/koneksi.php';

if (isset($_POST['btn-import'])) {
    
    $fileName = $_FILES['file_kesehatan']['name'];
    $fileTmp  = $_FILES['file_kesehatan']['tmp_name'];
    $fileSize = $_FILES['file_kesehatan']['size'];
    $fileError= $_FILES['file_kesehatan']['error'];
    
    $targetDir = "pdf/";
    
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if ($fileExtension === 'pdf') {
        if ($fileError === 0) {
            if ($fileSize < 5000000) {
                
                $uniqueName = time() . '_' . $fileName;
                $targetFile = $targetDir . $uniqueName;

                if (move_uploaded_file($fileTmp, $targetFile)) {
                    
                    $id_penjual = $_SESSION['id_user']; 

                    $query = "INSERT INTO kucing (id_penjual, file_kesehatan) VALUES ('$id_penjual', '$uniqueName')";
                    $simpan = mysqli_query($db, $query);


                    if ($simpan) {
                        echo "<script>
                                alert('File PDF Kesehatan berhasil diupload!');
                                window.location='index.php'; // Kembali ke halaman utama data_master_admin
                              </script>";
                    } else {
                        echo "Gagal menyimpan ke database: " . mysqli_error($db);
                    }

                } else {
                    echo "Gagal memindahkan file ke folder pdf. Periksa izin akses folder Anda.";
                }
            } else {
                echo "Ukuran file terlalu besar! Maksimal 5MB.";
            }
        } else {
            echo "Terjadi error saat proses upload.";
        }
    } else {
        echo "Format file salah! Harus berupa file PDF.";
    }
}
?>
