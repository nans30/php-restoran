<?php
session_start(); // Memulai sesi untuk menggunakan session

include_once 'function.php'; // Memasukkan file function.php
include_once 'koneksi.php'; // Memasukkan koneksi
include_once 'templates/header.php'; // Tambahkan header template

// Memeriksa jika form telah disubmit
$status_message = null; // Inisialisasi variabel pesan status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Memastikan data yang dibutuhkan tersedia
    if (isset($_POST['total_amount'])) {
        $id_user = $_SESSION['id_user']; // ID User dari session
        $total_amount = $_POST['total_amount']; // Total Amount dari form

        // Menambahkan pesanan menggunakan fungsi addOrder
        $order_id = addOrder($koneksi, $id_user, $total_amount);

        // Menyimpan status pesan berdasarkan hasil
        if ($order_id) {
            $status_message = "Order berhasil ditambahkan dengan ID: $order_id";
        } else {
            $status_message = "Gagal menambahkan order.";
        }
    }
}
?>

<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4">Add New Order</h1>
        
        <!-- Tampilkan pesan status jika ada -->
        <?php if ($status_message): ?>
            <div class="alert <?= strpos($status_message, 'berhasil') !== false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?= $status_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="id_user">User ID:</label>
                <input type="text" class="form-control" name="id_user" value="<?= $_SESSION['id_user']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="total_amount">Total Amount:</label>
                <input type="number" class="form-control" name="total_amount" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Order</button>
        </form>
    </div>
</div>

<?php
include_once 'templates/footer.php'; // Tambahkan footer template
$koneksi->close(); // Menutup koneksi setelah selesai
?>
