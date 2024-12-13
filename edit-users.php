<?php
include_once 'koneksi.php';
include_once 'function.php';

if (!isset($_GET['id_user'])) {
    die("User ID tidak ditemukan.");
}

$id_user = $_GET['id_user'];
$user = getUserById($koneksi, $id_user);

if (!$user) {
    die("User tidak ditemukan.");
}

$status_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = updateUser($koneksi, $id_user, $username, $password, $role);

    if ($result === true) {
        $status_message = "Berhasil memperbarui user.";
        header("Location: users.php");
        exit();
    } else {
        $status_message = "Gagal memperbarui user: " . $result;
    }
}

include_once 'templates/header.php';
?>
<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4">Edit User</h1>
        <?php if ($status_message): ?>
            <p style="color: red;"><?= $status_message; ?></p>
        <?php endif; ?>
        <div class="table-container">
            <form method="POST">
                <div class="form-group">
                    <label>Username:</label><br>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required><br>
                </div>
                <div class="form-group">
                    <label>Password (Kosongkan jika tidak ingin mengubah):</label><br>
                    <input type="password" name="password" class="form-control"><br>
                </div>
                <div class="form-group">
                    <label>Role:</label><br>
                    <select name="role" class="form-control" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="pengunjung" <?= $user['role'] == 'pengunjung' ? 'selected' : ''; ?>>Pengunjung</option>
                    </select><br><br>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="users.php" class="btn btn-secondary ml-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?php
include_once 'templates/footer.php';
?>