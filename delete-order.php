<?php
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php

if (!isset($_GET['id_order'])) {
    die("Order ID not specified.");
}

$id_order = $_GET['id_order'];

// Menghapus pesanan berdasarkan id_order
$result = deleteOrder($koneksi, $id_order);

if ($result === true) {
    header("Location: customer-orders.php"); // Redirect ke halaman daftar pesanan
    exit();
} else {
    echo "Failed to delete order: " . $result;
}

$koneksi->close();
?>
