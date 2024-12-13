<?php
include_once 'auth.php'; // Memastikan pengguna sudah login
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php
include_once 'templates/header.php'; // Menyertakan header.php

// Fungsi untuk mengambil item pesanan berdasarkan id_order
function getOrderItems($koneksi, $id_order)
{
    $sql = "SELECT oi.id_order_item, oi.quantity, oi.price, m.name
            FROM order_item oi
            JOIN menu m ON oi.id_menu = m.id_menu
            WHERE oi.id_order = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    return $stmt->get_result(); // Mengembalikan hasil query
}

// Jika user adalah admin, ambil semua pesanan
// Jika user adalah pengunjung, hanya ambil pesanan mereka sendiri
$user_id = $_SESSION['id_user'];
if ($_SESSION['role'] === 'admin') {
    $result = getAllOrders($koneksi); // Ambil semua pesanan
} else {
    // Ambil pesanan hanya untuk pengunjung yang sedang login
    $result = getOrdersByUserId($koneksi, $user_id); // Buat fungsi getOrdersByUserId untuk mengambil pesanan berdasarkan user_id
}

// Fungsi untuk mengambil pesanan berdasarkan id_user (hanya untuk pengunjung)
function getOrdersByUserId($koneksi, $user_id)
{
    $sql = "SELECT * FROM customer_order WHERE id_user = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result(); // Mengembalikan hasil query
}
?>
<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4">Customer Orders</h1>
        <div class="table-container">
            <!-- Tombol "Add New Order" tampil untuk semua pengguna (admin dan pengunjung) -->
            <a href="tambah_order.php" class="btn btn-primary mb-3">Add New Order</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Order Date</th>
                        <th>Order Items</th>
                        <th>Add Items</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_order']; ?></td>
                                <td><?= $row['id_user']; ?></td>
                                <td><?= $row['order_date']; ?></td>
                                <td>
                                    <?php
                                    // Ambil item pesanan berdasarkan id_order
                                    $order_items = getOrderItems($koneksi, $row['id_order']);
                                    if ($order_items->num_rows > 0) {
                                        while ($item = $order_items->fetch_assoc()) {
                                            echo $item['name'] . " (Qty: " . $item['quantity'] . ", Price: Rp " . number_format($item['price'], 2) . ")<br>";
                                        }
                                    } else {
                                        echo "No items found.";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <!-- Semua pengguna (admin dan pengunjung) bisa menambah pesanan -->
                                    <a href="proses_order.php?id_order=<?= $row['id_order']; ?>" class="btn btn-sm btn-success">Tambah Pesanan</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No orders found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once 'templates/footer.php'; // Menyertakan footer.php
$koneksi->close(); // Menutup koneksi setelah selesai
?>