<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // === CEK APAKAH USERNAME SUDAH ADA ===
    $cek = $koneksi->prepare("SELECT id FROM users WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan. Silakan pilih yang lain.'); window.history.back();</script>";
        exit();
    }
    $cek->close();

    // === INSERT JIKA USERNAME BELUM ADA ===
    $stmt = $koneksi->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $stmt->close();

    header("Location: super_sukses-rg.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>

<!-- Import font dari Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {              /* ------> mengatur background paling belakang */ 
      font-family: 'Poppins', Segoe UI;
      background-color: #f1f1f1;
      padding: 15px;
    }

    .form-container {      /* ------> menambahkan kotak putih di depan background*/
      background-color: #fff;
      padding: 20px 40px 10px 40px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
    }

    h2 {                    /* ------> mengatur style judul form preventive maintenance */
      text-align: center;
      margin-bottom: 20px;
      font-size: 20px;
    }

    .form-section h3 {      /*memberikan jarak yang ada di bawan check device functions*/
      margin-bottom: 15px;
      font-size: 15px;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .input-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: center;
      margin-bottom: 15px;
    }

    .input-row label {
      width: 180px; /* Sesuaikan sesuai panjang label terpanjang */
      margin-right: -30px;
      font-size: 11px;
      gap: 20px;
    }

    .input-row input[type="text"], input[type="password"], select {
      flex: 1;
    }

    .input-row label {
      display: block;
      margin-bottom: 7px;
      font-size: 11px;
      margin-left: 17px;
    }

    .required {    /* ------> memberi warna merah pada bintang untuk kolom yang wajib diisi */
      color: red;
      color: red;
      vertical-align: top;
      font-size: 11px;
    }

    input[type="text"], input[type="password"], 
    select {   
      width: 100%;
      padding: 5px;
      border: 2px solid #ccc;
      border-radius: 4px;
      font-size: 11px;
      font-family: 'Poppins', Segoe UI;
    }

    .button-container {                 /*mengatur tata letak button agar menjadi rata kanan dan rata kiri*/
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
      align-items: right;
      margin-bottom: 10px; 
    }

    .btn-submit {        /*mengatur style button*/
      padding: 10px 20px;
      font-size: 11px;
      font-family: 'Poppins', Segoe UI;
      background-color: #56ab2f;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    /* === Sidebar === */
    .sidebar {
        width: 140px;
        background-color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        height: 100vh;
        transition: all 0.3s ease;
        overflow-y: auto;
        z-index: 1000;
        font-size: 13px;
      }

      .sidebar.hide {
        width: 55px;
      }

      .sidebar-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
      }

      .menu-icon {
        font-size: 20px;
        cursor: pointer;
        margin-right: 10px;
      }

      .sidebar-header h3 {
        font-size: 20px;
        transition: 0.3s;
      }

      .sidebar.hide .sidebar-header h3 {
        opacity: 0;
        pointer-events: none;
        font-size: 0;
      }

      .sidebar nav a {
        display: block;
        margin: 15px 0;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: 0.3s;
      }

      .sidebar.hide nav a {
        font-size: 0;
        opacity: 0;
      }

      .sidebar ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
      }

      /* === Main Content === */
      .main {
        margin-left: 120px;
        padding: 20px 40px;
        flex: 1;
        transition: margin-left 0.3s ease;
      }

      .sidebar.hide ~ .main {
        margin-left: 40px;
      }

      .main.expand {
        margin-left: 40px !important;
      }
  </style>

</head>
<body>

<!-- ============ Sidebar Layout ============ -->
<div class="sidebar hide" id="sidebar">
  <div class="sidebar-header">
    <span class="menu-icon" id="toggleSidebar">☰</span> <!-- Tombol toggle -->
    <h3>Home</h3> <!-- Judul sidebar -->
  </div>
  <nav>
    <ul>
      <li><a href="super_desktop.php">Dashboard</a></li>
      <li><a href="super_about.php">About</a></li>
      <li><a href="super_notif.php">Notifications</a></li>
      <li><a href="super_histo.php">Histories</a></li>
      <li><a href="super_register.php">Register</a></li>
      <li><a href="super_setting.php">Settings</a></li>
      <li><a href="logout.php" style="color: red; font-weight: bold;">Logout</a><li>
  </nav>
</div>

<div class="main expand" id="main">
  <div class="form-container">
    <h2>Register</h2>
    <form id=register method="post" action="">
      <div class="form-group">
        <div class="input-container">
            <div class="input-row">
              <label for="device_name" style="font-size: 13px">Username </label>
              <input type="text" name="username" required>
            </div>
            <div class="input-row">
              <label for="device_name" style="font-size: 13px">Password </label>
              <input type="password" name="password" required>
            </div>
            <div class="input-row">
              <label for="device_name" style="font-size: 13px">Role </label>
              <select name="role" id="role">
                  <option value="superadmin">Super Admin</option>
                  <option value="admin">Admin</option>
                  <option value="guest">Guest</option>
              </select>
            </div>
        </div>
      </div>

      <div class="button-container">
          <button type="submit" name="action" id="btn-save" value="save" class="btn-submit">Register</button>
    </form>   
  </div>
</div>
<!-- ============ JavaScript buat Sidebar Toggle ============ -->
<script>
document.getElementById("toggleSidebar").onclick = function () {
    document.getElementById("sidebar").classList.toggle("hide");
    document.getElementById("main").classList.toggle("expand");
  };
</script>
</body>
</html>

