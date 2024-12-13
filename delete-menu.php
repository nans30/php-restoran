<?php
include_once 'koneksi.php'; // Pastikan koneksi sudah benar
include_once 'function.php'; // Memasukkan file function.php

// Memeriksa apakah id_menu ada di URL untuk dihapus
if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];

    // Memanggil fungsi untuk menghapus menu
    $delete_status = deleteMenu($koneksi, $id_menu);

    if ($delete_status === true) {
        header("Location: menu.php"); // Redirect kembali ke daftar menu setelah berhasil dihapus
    } else {
        echo "Error deleting record: " . $delete_status; // Menampilkan error jika gagal
    }
} else {
    echo "Menu ID not specified."; // Jika tidak ada id_menu yang disertakan
}

$koneksi->close(); // Menutup koneksi setelah selesai
?>
