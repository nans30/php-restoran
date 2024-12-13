<?php
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php
include_once 'templates/header.php'; // Menambahkan header template

// Memeriksa apakah parameter id_menu ada di URL
if (!isset($_GET['id_menu']) || empty($_GET['id_menu'])) {
    die("Menu ID not specified.");
}

// Mendapatkan id_menu dari URL
$id_menu = $_GET['id_menu'];

// Mengambil data menu berdasarkan id_menu
$menu = getMenuById($koneksi, $id_menu);

if (!$menu) {
    die("Menu not found.");
}

// Variabel status untuk menampilkan pesan
$status_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_menu = $_POST['id_menu'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $is_recommended = isset($_POST['is_recommended']) ? 1 : 0;

    // Memperbarui menu dengan menggunakan fungsi updateMenu
    $update_result = updateMenu($koneksi, $id_menu, $name, $description, $price, $is_recommended);

    if ($update_result === TRUE) {
        $status_message = "Berhasil memperbarui menu.";
        header("Location: menu.php"); // Redirect ke menu.php setelah pembaruan berhasil
        exit();
    } else {
        $status_message = "Gagal memperbarui menu. Error: " . $koneksi->error;
    }
}
?>

<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4">Edit Menu</h1>

        <!-- Tampilkan status pesan jika ada -->
        <?php if ($status_message): ?>
            <div class="alert <?= ($status_message == 'Berhasil memperbarui menu.') ? 'alert-success' : 'alert-danger'; ?>">
                <?= $status_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="id_menu" value="<?= $menu['id_menu']; ?>">
            <div class="form-group">
                <label for="name">Menu Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= $menu['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Menu Description</label>
                <textarea id="description" name="description" class="form-control"><?= $menu['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control" value="<?= $menu['price']; ?>" step="0.01" required>
            </div>
            <div class="form-check">
                <input type="checkbox" id="is_recommended" name="is_recommended" class="form-check-input" <?= $menu['is_recommended'] ? "checked" : ""; ?>>
                <label for="is_recommended" class="form-check-label">Recommended</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Menu</button>
        </form>
    </div>
</div>

<?php
include_once 'templates/footer.php'; // Menambahkan footer template
$koneksi->close(); // Menutup koneksi setelah selesai
?>
