<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jumlah = intval($_POST['jumlah']);
    $contact_method = $_POST['contact_method'];

    $harga_per_voucher = 3000;
    $total_harga = $jumlah * $harga_per_voucher;

    // Cek apakah pelanggan sudah ada
    $check_pelanggan = "SELECT id_pelanggan FROM pelanggan WHERE nama = '$nama_pelanggan' LIMIT 1";
    $result_pelanggan = mysqli_query($conn, $check_pelanggan);
    
    if (mysqli_num_rows($result_pelanggan) > 0) {
        $row = mysqli_fetch_assoc($result_pelanggan);
        $id_pelanggan = $row['id_pelanggan'];
    } else {
        // Jika pelanggan baru, tambahkan ke database
        $insert_pelanggan = "INSERT INTO pelanggan (nama) VALUES ('$nama_pelanggan')";
        mysqli_query($conn, $insert_pelanggan);
        $id_pelanggan = mysqli_insert_id($conn);
    }

    // Simpan transaksi penjualan
    $sql_penjualan = "INSERT INTO penjualan (id_pelanggan, jumlah, total_harga, contact_method) 
                      VALUES ('$id_pelanggan', '$jumlah', '$total_harga', '$contact_method')";

    if (mysqli_query($conn, $sql_penjualan)) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>