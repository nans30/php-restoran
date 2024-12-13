<?php
include_once 'koneksi.php';
include_once 'function.php';

// Validasi input tanggal
$tanggal_awal = isset($_GET['tanggal_awal']) ? mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']) : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']) : '';

if (empty($tanggal_awal) || empty($tanggal_akhir)) {
    die("Tanggal awal dan akhir harus diisi!");
}

// Ambil data berdasarkan tanggal
$orders = getOrdersByDate($koneksi, $tanggal_awal, $tanggal_akhir);

// Header untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pesanan_{$tanggal_awal}_to_{$tanggal_akhir}.xls");

echo "ID Order\tUsername\tTanggal Order\tTotal Harga\tStatus Pembayaran\n";

while ($order = $orders->fetch_assoc()) {
    echo "{$order['id_order']}\t{$order['username']}\t{$order['order_date']}\tRp " . number_format($order['total_amount'], 2) . "\t{$order['payment_status']}\n";
}

$koneksi->close();
