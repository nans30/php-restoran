<?php
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php
include_once 'templates/header.php'; // Header file
?>

<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4">Add Menu</h1>
        <form method="POST" action="tambah_menu.php">
            <div class="form-group">
                <label for="name">Menu Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Menu Name" required>
            </div>
            <div class="form-group">
                <label for="description">Menu Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Menu Description"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control" placeholder="Price" step="0.01" required>
            </div>
            <div class="form-check">
                <input type="checkbox" id="is_recommended" name="is_recommended" class="form-check-input">
                <label for="is_recommended" class="form-check-label">Recommended</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Add Menu</button>
        </form>

        <?php
        // Memproses form saat disubmit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ambil data dari form
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $is_recommended = isset($_POST['is_recommended']) ? 1 : 0;

            // Panggil fungsi untuk menambah menu
            $add_status = addMenu($koneksi, $name, $description, $price, $is_recommended);

            if ($add_status === true) {
                echo "<div class='alert alert-success mt-3'>Menu added successfully. </div>";
               
                exit();
            } else {
                echo "<div class='alert alert-danger mt-3'>Failed to add menu. Please try again later.</div>";
            }

        }
        ?>
    </div>
</div>

<?php
include_once 'templates/footer.php'; // Footer file
$koneksi->close(); // Menutup koneksi setelah selesai
?>
