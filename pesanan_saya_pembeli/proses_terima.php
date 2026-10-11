<?php 
require_once '../database/koneksi.php';

if (isset($_GET['id'])) {
    $id_transaksi = mysqli_real_escape_string($db, $_GET['id']);
    
    // 1. Ambil data transaksi (id_kucing dan total_bayar)
    $q_trans = mysqli_query($db, "SELECT id_kucing, total_bayar FROM transaksi WHERE id_transaksi = '$id_transaksi'");
    $d_trans = mysqli_fetch_assoc($q_trans);
    
    if ($d_trans) {
        $id_kucing = $d_trans['id_kucing'];
        $total_bayar = $d_trans['total_bayar'];
        
        // 2. Ambil id_penjual dari tabel kucing
        $q_kucing = mysqli_query($db, "SELECT id_penjual FROM kucing WHERE id_kucing = '$id_kucing'");
        $d_kucing = mysqli_fetch_assoc($q_kucing);
        $id_penjual = $d_kucing['id_penjual'] ?? '';

        // 3. Eksekusi Pembagian Saldo Virtual
        if (!empty($id_penjual)) {
            // Hitung persentase
            $pendapatan_penjual = (int)($total_bayar * 0.90);
            $komisi_admin       = (int)($total_bayar * 0.10);

            // A. Tambahkan 90% ke dompet virtual Penjual
            mysqli_query($db, "UPDATE users SET saldo = saldo + $pendapatan_penjual WHERE id_user = '$id_penjual'");
            
            // B. Tambahkan 10% ke dompet virtual Admin (Super Admin)
            // Asumsi: id_user milik Super Admin utama adalah '1' atau dicari berdasarkan role 'A'
            // Jika id_user Super Admin kamu adalah 1, gunakan query ini:
            mysqli_query($db, "UPDATE users SET saldo = saldo + $komisi_admin WHERE id_user = '1'");
            
            // Alternatif jika ingin fleksibel mencari role 'A' pertama:
            // $q_admin = mysqli_query($db, "SELECT id_user FROM users WHERE role = 'A' LIMIT 1");
            // $d_admin = mysqli_fetch_assoc($q_admin);
            // $id_admin = $d_admin['id_user'];
            // mysqli_query($db, "UPDATE users SET saldo = saldo + $komisi_admin WHERE id_user = '$id_admin'");
        }
    }

    // 4. Ubah status transaksi menjadi Selesai
    $query = "UPDATE transaksi SET status_transaksi = 'Selesai' WHERE id_transaksi = '$id_transaksi'";
    $eksekusi = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if ($eksekusi) {
        echo '<script>alert("Pesanan selesai!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengkonfirmasi pesanan!")</script>';
        echo '<script>window.history.back()</script>';
    }
} else {
    echo '<script>window.location.href="index.php"</script>';
}
?>