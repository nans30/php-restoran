<?php
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php

if (!isset($_GET['id_order'])) {
    die("Order ID not specified.");
}

$id_order = $_GET['id_order'];
$order = getOrderById($koneksi, $id_order);

if (!$order) {
    die("Order not found.");
}

$status_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $total_amount = $_POST['total_amount'];

    // Memperbarui pesanan
    $result = updateOrder($koneksi, $id_order, $id_user, $total_amount);

    if ($result === true) {
        $status_message = "Order successfully updated.";
        header("Location: customer-orders.php"); // Redirect ke halaman daftar pesanan
        exit();
    } else {
        $status_message = "Failed to update order: " . $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
</head>
<body>
    <h1>Edit Order</h1>
    <?php if ($status_message): ?>
        <p style="color: green;"><?= $status_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="edit-customer-order.php?id_order=<?= $order['id_order']; ?>">
        <label for="id_user">User ID:</label>
        <input type="text" name="id_user" value="<?= $order['id_user']; ?>" required><br>

        <label for="total_amount">Total Amount:</label>
        <input type="number" name="total_amount" value="<?= $order['total_amount']; ?>" step="0.01" required><br>

        <button type="submit">Update Order</button>
    </form>
</body>
</html>
<?php
$koneksi->close();
?>
