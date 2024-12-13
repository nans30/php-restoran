<?php
include_once 'koneksi.php';
include_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_order = $_POST['id_order'];

    if (deleteOrder($koneksi, $id_order)) {
        echo "Pesanan berhasil dihapus.";
    } else {
        echo "Gagal menghapus pesanan.";
    }
}
?>

<form method="POST">
    <label>ID Pesanan:</label>
    <input type="number" name="id_order" required><br>
    <button type="submit">Hapus Pesanan</button>
</form>
