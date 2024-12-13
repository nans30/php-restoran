<?php
include_once 'auth.php'; // Memastikan hanya pengguna yang login dapat mengakses
checkRole('admin'); // Hanya admin yang bisa mengakses halaman ini

include_once 'koneksi.php';
include_once 'function.php';
include_once 'templates/header.php'; // Menambahkan header template

$orders = getAllOrders($koneksi);
?>

<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4">Laporan</h1>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>ID User</th>
                        <th>Tanggal Pesanan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders->num_rows > 0): ?>
                        <?php while ($order = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?= $order['id_order']; ?></td>
                                <td><?= $order['id_user']; ?></td>
                                <td><?= $order['order_date']; ?></td>
                                <td>
                                    <?php
                                    $total_order = getOrderTotal($koneksi, $order['id_order']);
                                    echo "Rp " . number_format($total_order, 2);
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pesanan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once 'templates/footer.php'; // Menambahkan footer template
$koneksi->close(); // Menutup koneksi setelah selesai
?>