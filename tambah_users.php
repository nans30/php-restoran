<?php
include_once 'koneksi.php';
include_once 'function.php';

$status_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = addUser($koneksi, $username, $password, $role);

    if ($result === true) {
        $status_message = "Berhasil menambahkan user.";
        header("Location: users.php");
        exit();
    } else {
        $status_message = "Gagal menambahkan user: " . $result;
    }
}
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'templates/header.php'; ?>

    <div class="main-panel">
        <div class="container mt-5">
            <h1 class="mb-4">Tambah User</h1>

            <?php if ($status_message): ?>
                <div class="alert alert-danger"><?= $status_message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="pengunjung">Pengunjung</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah User</button>
            </form>
        </div>
    </div>

    <?php include_once 'templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>