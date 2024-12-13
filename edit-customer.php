<?php
include_once 'koneksi.php';
include_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_order = $_POST['id_order'];
    $id_user = $_POST['id_user'];
    $total_amount = $_POST['total_amount'];

    if (updateOrder($koneksi, $id_order, $id_user, $total_amount)) {
        echo "Pesanan berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui pesanan.";
    }
}

$order = getOrderById($koneksi, $_GET['id']); // Mengambil data pesanan berdasarkan id_order
?>

<form method="POST">
    <input type="hidden" name="id_order" value="<?= $order['id_order']; ?>">
    <label>ID User:</label>
    <input type="number" name="id_user" value="<?= $order['id_user']; ?>" required><br>
    <label>Total Harga:</label>
    <input type="number" name="total_amount" step="0.01" value="<?= $order['total_amount']; ?>" required><br>
    <button type="submit">Perbarui Pesanan</button>
</form>
