<?php
// Fungsi untuk mendapatkan menu berdasarkan id_menu
function getMenuById($koneksi, $id_menu) {
    $sql = "SELECT * FROM menu WHERE id_menu='$id_menu'";
    $result = $koneksi->query($sql);
    if ($result->num_rows == 0) {
        return null; // Jika menu tidak ditemukan
    }
    return $result->fetch_assoc(); // Mengembalikan data menu
}

// Fungsi untuk menambah menu baru
function addMenu($koneksi, $name, $description, $price, $is_recommended)
{
    // Query dengan placeholder
    $sql = "INSERT INTO menu (name, description, price, is_recommended) VALUES (?, ?, ?, ?)";

    // Siapkan statement
    $stmt = $koneksi->prepare($sql);
    if ($stmt === false) {
        return $koneksi->error; // Gagal menyiapkan statement
    }

    // Bind parameter ke statement
    $stmt->bind_param("ssdi", $name, $description, $price, $is_recommended);

    // Eksekusi statement
    if ($stmt->execute()) {
        $stmt->close();
        return true; // Berhasil
    } else {
        $error = $stmt->error; // Tangkap error
        $stmt->close();
        return $error; // Kembalikan error
    }
}


// Fungsi untuk memperbarui menu berdasarkan id_menu
function updateMenu($koneksi, $id_menu, $name, $description, $price, $is_recommended) {
    $sql = "UPDATE menu SET 
            name='$name', 
            description='$description', 
            price='$price', 
            is_recommended='$is_recommended' 
            WHERE id_menu='$id_menu'";
    if ($koneksi->query($sql) === TRUE) {
        return true; // Pembaruan berhasil
    } else {
        return $koneksi->error; // Jika gagal
    }
}

// Fungsi untuk menghapus menu berdasarkan id_menu
function deleteMenu($koneksi, $id_menu) {
    $sql = "DELETE FROM menu WHERE id_menu='$id_menu'";
    if ($koneksi->query($sql) === TRUE) {
        return true; // Menu berhasil dihapus
    } else {
        return $koneksi->error; // Jika gagal
    }
}

// Fungsi untuk mendapatkan semua menu
function getAllMenus($koneksi) {
    $sql = "SELECT * FROM menu";
    return $koneksi->query($sql);
}

// ========================== CRUD USER ==========================

// Fungsi untuk menambah user baru
// Fungsi untuk menambah user baru
function addUser($koneksi, $username, $password, $role) {
    // Cek apakah username sudah ada
    $check_sql = "SELECT * FROM user WHERE username = ?";
    $check_stmt = $koneksi->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        return "Username sudah ada. Silakan gunakan username lain."; // Kembalikan pesan error
    }

    // Jika username tidak ada, lanjutkan menambahkan user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password
    $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        return true; // User berhasil ditambahkan
    } else {
        return $stmt->error; // Jika terjadi error
    }
}


// Fungsi untuk mendapatkan semua user
function getAllUsers($koneksi) {
    $sql = "SELECT id_user, username, role, created_at FROM user";
    $result = $koneksi->query($sql);

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; // Menyimpan setiap hasil ke array
    }
    return $users; // Mengembalikan array hasil
}

// Fungsi untuk mendapatkan user berdasarkan id_user
function getUserById($koneksi, $id_user) {
    $sql = "SELECT id_user, username, role, created_at FROM user WHERE id_user = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_user); // "i" -> integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        return null; // Jika user tidak ditemukan
    }
    return $result->fetch_assoc(); // Mengembalikan data user
}

// Fungsi untuk memperbarui user
function updateUser($koneksi, $id_user, $username, $password, $role) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Enkripsi password baru
    $sql = "UPDATE user SET username = ?, password = ?, role = ? WHERE id_user = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sssi", $username, $hashed_password, $role, $id_user); // "sssi" -> string, string, string, integer

    if ($stmt->execute()) {
        return true; // Berhasil memperbarui user
    } else {
        return $stmt->error; // Jika gagal
    }
}

// Fungsi untuk menghapus user berdasarkan id_user
function deleteUser($koneksi, $id_user) {
    $sql = "DELETE FROM user WHERE id_user = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_user); // "i" -> integer

    if ($stmt->execute()) {
        return true; // Berhasil menghapus user
    } else {
        return $stmt->error; // Jika gagal
    }
}

// Fungsi untuk login user
function loginUser($koneksi, $username, $password) {
    // Query untuk mencari user berdasarkan username
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "Username tidak ditemukan."; // Jika username tidak ditemukan
    }

    $user = $result->fetch_assoc();

    // Verifikasi password
    if (!password_verify($password, $user['password'])) {
        return "Password salah."; // Jika password tidak cocok
    }

    // Jika login berhasil, kembalikan data user
    return $user;
}
// Fungsi untuk mendapatkan semua pesanan
function getAllOrders($koneksi) {
    $sql = "SELECT * FROM customer_order";
    return $koneksi->query($sql);
}

// Fungsi untuk menambahkan pesanan baru
function addOrder($koneksi, $id_user, $total_amount) {
    $sql = "INSERT INTO customer_order (id_user, total_amount) VALUES (?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("id", $id_user, $total_amount);
    if ($stmt->execute()) {
        return $koneksi->insert_id; // Mengembalikan ID pesanan yang baru dibuat
    } else {
        return false; // Gagal menambah pesanan
    }
}

// Fungsi untuk memperbarui pesanan berdasarkan id_order
function updateOrder($koneksi, $id_order, $id_user, $total_amount) {
    $sql = "UPDATE customer_order SET id_user = ?, total_amount = ? WHERE id_order = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("idi", $id_user, $total_amount, $id_order);
    return $stmt->execute(); // True jika berhasil
}

// Fungsi untuk menghapus pesanan berdasarkan id_order
function deleteOrder($koneksi, $id_order) {
    $sql = "DELETE FROM customer_order WHERE id_order = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_order);
    return $stmt->execute(); // True jika berhasil
}

// Fungsi untuk mendapatkan semua item berdasarkan id_order
// function getOrderItems($koneksi, $id_order) {
//     $sql = "SELECT * FROM order_item WHERE id_order = ?";
//     $stmt = $koneksi->prepare($sql);
//     $stmt->bind_param("i", $id_order);
//     $stmt->execute();
//     return $stmt->get_result(); // Mengembalikan hasil item-item di pesanan
// }

// Fungsi untuk menambahkan item baru ke pesanan
function addOrderItem($koneksi, $id_order, $id_menu, $quantity) {
    // Ambil harga dari tabel menu berdasarkan id_menu
    $sql = "SELECT price FROM menu WHERE id_menu = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_menu);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika menu ditemukan, ambil harga dan hitung harga total
    if ($result->num_rows > 0) {
        $menu = $result->fetch_assoc();
        $price_per_item = $menu['price'];
        $total_price = $price_per_item * $quantity;

        // Masukkan data item pesanan ke dalam order_item
        $sql_insert = "INSERT INTO order_item (id_order, id_menu, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_insert = $koneksi->prepare($sql_insert);
        $stmt_insert->bind_param("iiid", $id_order, $id_menu, $quantity, $total_price);
        return $stmt_insert->execute(); // True jika berhasil
    }

    return false; // Jika menu tidak ditemukan
}


// Fungsi untuk memperbarui item pesanan berdasarkan id_order_item
function updateOrderItem($koneksi, $id_order_item, $id_menu, $quantity, $price) {
    $sql = "UPDATE order_item SET id_menu = ?, quantity = ?, price = ? WHERE id_order_item = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("iidi", $id_menu, $quantity, $price, $id_order_item);
    return $stmt->execute(); // True jika berhasil
}

// Fungsi untuk menghapus item pesanan berdasarkan id_order_item
function deleteOrderItem($koneksi, $id_order_item) {
    $sql = "DELETE FROM order_item WHERE id_order_item = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_order_item);
    return $stmt->execute(); // True jika berhasil
}


// Fungsi untuk mendapatkan pesanan berdasarkan id_order
function getOrderById($koneksi, $id_order) {
    $sql = "SELECT * FROM customer_order WHERE id_order = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // Mengembalikan data pesanan
}

function getOrderTotal($koneksi, $id_order)
{
    $sql = "SELECT SUM(oi.quantity * oi.price) AS total_order 
            FROM order_item oi
            WHERE oi.id_order = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_order'] ?: 0; // Mengembalikan 0 jika null
}

function checkRole($requiredRole)
{
    // Jika peran pengguna tidak sesuai, arahkan ke halaman login
    if ($_SESSION['role'] !== $requiredRole) {
        header("Location: login.php");
        exit();
    }
}
function checkLogin()
{
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit();
    }
}

function getOrdersByDate($koneksi, $tanggal_awal, $tanggal_akhir)
{
    $sql = "SELECT * FROM `customer_order` WHERE order_date BETWEEN ? AND ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('ss', $tanggal_awal, $tanggal_akhir);
    $stmt->execute();
    return $stmt->get_result();
}





