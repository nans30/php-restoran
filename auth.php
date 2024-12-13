<?php
include_once 'function.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Fungsi untuk memeriksa peran pengguna
