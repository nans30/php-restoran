<?php
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php

// Cek jika id_order ada di URL
if (isset($_GET['id_order'])) {
    $id_order = $_GET['id_order'];

    // Ambil data pesanan berdasarkan id_order
    $order = getOrderById($koneksi, $id_order); // Fungsi getOrderById harus dibuat di function.php

    // Jika data pesanan ditemukan
    if ($order) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data yang diinputkan untuk order item
            $id_menu = $_POST['id_menu'];
            $quantity = $_POST['quantity'];

            // Ambil harga dari menu berdasarkan id_menu
            $menu = getMenuById($koneksi, $id_menu); // Fungsi getMenuById harus dibuat di function.php
            $price = $menu['price']; // Harga per item menu

            // Menambahkan item pesanan ke tabel order_item
            $result = addOrderItem($koneksi, $id_order, $id_menu, $quantity, $price);

            if ($result) {
                echo "<div class='alert alert-success'>Item berhasil ditambahkan. Anda bisa melanjutkan pembayaran.</div>";
            } else {
                echo "<div class='alert alert-danger'>Gagal menambahkan item pesanan.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Pesanan tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID pesanan tidak valid.</div>";
}
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'templates/header.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Proses Order: ID <?= $id_order; ?></h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="id_menu" class="form-label">Menu</label>
                <select name="id_menu" class="form-select" required>
                    <!-- Ambil semua menu dari database dan tampilkan sebagai pilihan -->
                    <?php
                    $menus = getAllMenus($koneksi); // Fungsi getAllMenus harus dibuat di function.php
                    while ($menu = $menus->fetch_assoc()) {
                        echo "<option value='{$menu['id_menu']}'>{$menu['name']} - Rp " . number_format($menu['price'], 0, ',', '.') . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" min="1" required>
            </div>

            <!-- Menyembunyikan harga karena dihitung berdasarkan id_menu yang dipilih -->
            <input type="hidden" name="price" value="">

            <button type="submit" class="btn btn-primary">Add Item</button>
        </form>
    </div>

    <?php include_once 'templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$koneksi->close(); // Menutup koneksi setelah selesai
?>