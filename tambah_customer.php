<?php
include_once 'koneksi.php';
include_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $total_amount = $_POST['total_amount'];

    $result = addOrder($koneksi, $id_user, $total_amount);

    if ($result) {
        echo "Pesanan berhasil ditambahkan dengan ID: " . $result;
    } else {
        echo "Gagal menambahkan pesanan.";
    }
}
?>

<form method="POST">
    <label>ID User:</label>
    <input type="number" name="id_user" required><br>
    <label>Total Harga:</label>
    <input type="number" name="total_amount" step="0.01" required><br>
    <button type="submit">Tambah Pesanan</button>
</form>
