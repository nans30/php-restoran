<?php
include_once 'auth.php'; // Pastikan pengguna sudah login dan memiliki peran yang sesuai
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {
    // Jika bukan admin, arahkan ke halaman index atau halaman yang diinginkan
    header('Location: index.php');
    exit();
}

// Mendapatkan semua user
$users = getAllUsers($koneksi);
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'templates/header.php'; ?>

    <div class="main-panel">
        <div class="container mt-5">
            <h1 class="mb-4">Daftar User</h1>
            <div class="table-container">
                <!-- Tombol "Tambah User" hanya untuk admin -->
                <a href="tambah_users.php" class="btn btn-primary mb-3">Tambah User</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id_user']; ?></td>
                                    <td><?= $user['username']; ?></td>
                                    <td><?= $user['role']; ?></td>
                                    <td><?= $user['created_at']; ?></td>
                                    <td>
                                        <a href="edit-users.php?id_user=<?= $user['id_user']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete-users.php?id_user=<?= $user['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pengguna</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include_once 'templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>