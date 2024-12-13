<?php
include_once 'auth.php'; // Memuat file proteksi halaman
checkLogin(); // Pastikan pengguna sudah login, peran tidak dibatasi

include_once('templates/header.php'); // Memuat header
?>

<div class="main-panel">
  <h1>Selamat Datang, <?= $_SESSION['username']; ?>!</h1>
  <p>Anda login sebagai: <?= $_SESSION['role']; ?></p>
</div>

<?php
include_once('templates/footer.php'); // Memuat footer
?>