<?php
include_once 'auth.php'; // Memastikan hanya pengguna yang login dapat mengakses
checkRole('admin'); // Hanya admin yang bisa mengakses halaman ini

include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php
include_once 'templates/header.php'; // Menyertakan header.php

// Ambil data menu dari fungsi getAllMenus
$result = getAllMenus($koneksi);
?>

<div class="main-panel">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Menu List</h1>

        <a href="tambah_menu.php" class="btn btn-primary mb-3">Add New Menu</a>

        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Recommended</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_menu']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['description']; ?></td>
                                <td>$<?= number_format($row['price'], 2); ?></td>
                                <td>
                                    <?php if ($row['is_recommended']): ?>
                                        <span class="badge badge-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit-menu.php?id_menu=<?= $row['id_menu']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete-menu.php?id_menu=<?= $row['id_menu']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No menu items found</td>
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