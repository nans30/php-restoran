<?php
include_once 'koneksi.php';
include_once 'function.php';

if (!isset($_GET['id_user'])) {
    die("User ID tidak ditemukan.");
}

$id_user = $_GET['id_user'];
$result = deleteUser($koneksi, $id_user);

if ($result === true) {
    header("Location: users.php");
    exit();
} else {
    die("Gagal menghapus user: " . $result);
}
?>
