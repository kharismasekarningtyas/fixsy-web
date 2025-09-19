<?php
session_start();
// Reset semua data jika user konfirmasi "mulai dari awal"
if (isset($_GET['reset']) && $_GET['reset'] === 'true') {
  session_destroy(); // atau unset($_SESSION['step1'], $_SESSION['step2']);
  header("Location: admin_input.php"); // redirect biar URL bersih
  exit();
}

include 'koneksi.php';

// Fungsi sanitasi
function clean($data) {
  return htmlspecialchars(trim($data));
}

if (!empty($_POST['ip_address']) && !filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) {
  die("IP Address tidak valid.");
}

if (!empty($_POST['mac_address']) && !preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $_POST['mac_address'])) {
  die("MAC Address tidak valid.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['input'] = [
    'departement' => clean($_POST['departement'] ?? ''),
    'asset_tag' => clean($_POST['asset_tag'] ?? ''),
    'asset_name' => clean($_POST['asset_name'] ?? ''),
    'category' => clean($_POST['category'] ?? ''),
    'supplier' => clean($_POST['supplier'] ?? ''),
    'location' => clean($_POST['location'] ?? ''),
    'status' => clean($_POST['status'] ?? ''),
    'asset_user' => clean($_POST['asset_user'] ?? ''),
    'asset_admin' => clean($_POST['asset_admin'] ?? ''),
    'manufacturer' => clean($_POST['manufacturer'] ?? ''),
    'model' => clean($_POST['model'] ?? ''),
    'maintenance_date' => clean($_POST['maintenance_date'] ?? ''),
    'device_merk' => clean($_POST['device_merk'] ?? ''),
    'serial_number' => clean($_POST['serial_number'] ?? ''),
    'ip_address' => clean($_POST['ip_address'] ?? ''),
    'mac_address' => clean($_POST['mac_address'] ?? ''),
    'bios_version' => clean($_POST['bios_version'] ?? '')
  ];
  
  // Redirect ke halaman kedua (hindari double submit)
  header("Location: admin_input2.php");
  exit();
}

if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script>
    window.onload = function () {
      // Cek apakah halaman di-refresh
      if (performance.navigation.type === 1) {
        // Cek apakah form memiliki data
        const form = document.querySelector("form"); // Ganti selector sesuai kebutuhan
        const inputs = form.querySelectorAll("input, select, textarea");
        let isFormFilled = false;

        inputs.forEach(input => {
          if (
            input.type !== "submit" &&
            input.type !== "button" &&
            input.value.trim() !== ""
          ) {
            isFormFilled = true;
          }
        });

        // Jika form terisi, tampilkan konfirmasi
        if (isFormFilled) {
          if (confirm("This will clear the form. Do you want to continue?")) {
            window.location.href = "admin_input.php?reset=true";
          }
        }
      }
    };
  </script>

  <meta charset="UTF-8" />
  <title>Form Preventive Maintenance</title>
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
      padding: 20px 40px 30px 40px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
    }

    h2 {                    /* ------> mengatur style judul form preventive maintenance */
      text-align: center;
      margin-bottom: 20px;
      font-size: 20px;
    }

    form {            /* ------> mengaturnya menjadi 1 baris, jika tidak cukup akan dibuat kolom ke samping */
      display: flex;
      gap: 25px;
    }

    .column {         /* ------> mengatur kolom pada ruang yang tersedia agar terisi merata*/
      flex: 1;
      min-width: 120px;
      gap: 20px;
    }

    .form-row {     /* ------> mengatur bagian aset, kategori, status, manu, dll agar menjadi sebaris */
      display: flex;
      flex-direction: row;
      gap: 20px;
      width: 100%;
    }

    .form-group {    /* ------> mengatur form tunggal menjadi lebar merata */
      flex: 1;
      flex-direction: column;
      margin-bottom: 24px;
      gap: 5px;
      min-width: 0;
    }

    label {        /* ------> mengatur ukuran label  */
      font-size: 11px;
      font-family: 'Poppins', Segoe UI;
      vertical-align: top;
    }

    .required {    /* ------> memberi warna merah pada bintang untuk kolom yang wajib diisi */
      color: red;
      vertical-align: top;
      font-size: 11px;
    }

    input[type="text"],          /* ------> mengatur ukuran form yang ada di bawah label  */
    input[type="date"],
    select {
      width: 100%;
      padding: 5px;
      border: 2px solid #ccc;
      /* margin-bottom: 1px; */
      border-radius: 4px;
      font-size: 11px;
      font-family: 'Poppins', Segoe UI;
    }  

    .button-container {
      display: flex;
      justify-content: flex-end;  /* --> dorong tombol ke kanan */
      margin-top: 74px;
      margin-bottom: 1px;
    }

    .btn-submit {             /* ------> mengatur button next */
      background-color: #56ab2f;
      font-family: 'Poppins', Segoe UI;
      font-size: 11px;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
    }

    /* ============ Sidebar ============ */
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

    /* Ini sidebar kalau disembunyiin */
    .sidebar.hide {
      width: 55px;
    }

    /* Header di dalam sidebar */
    .sidebar-header {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
    }

    /* Icon menu toggle */
    .menu-icon {
      font-size: 20px;
      cursor: pointer;
      margin-right: 10px;
    }

    /* Judul di sidebar */
    .sidebar-header h3 {
      font-size: 20px;
      transition: 0.3s;
    }

    /* Hide text saat sidebar kecil */
    .sidebar.hide .sidebar-header h3 {
      opacity: 0;
      pointer-events: none;
      font-size: 0;
    }

    /* Link navigasi di sidebar */
    .sidebar nav a {
      display: block;
      margin: 15px 0;
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: 0.3s;
    }

    /* Kalau sidebar disembunyiin, link kecil */
    .sidebar.hide nav a {
      font-size: 0;
      opacity: 0;
    }

    .sidebar ul {
      list-style: none;
      padding-left: 0;
      margin: 0;
    }

    /* ============ Main Content ============ */
    .main {
      margin-left: 120px;
      padding: 20px 40px;
      flex: 1;
      transition: margin-left 0.3s ease;
    }

    /* Kalau sidebar hide, main geser kiri */
    .sidebar.hide ~ .main {
      margin-left: 40px;
    }

    /*agar main menyesuaikan posisinya ketika sidebar ditutup*/
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
      <li><a href="admin_desktop.php">Dashboard</a></li>
      <li><a href="admin_about.php">About</a></li>
      <li><a href="admin_notif.php">Notifications</a></li>
      <li><a href="admin_histo.php">Histories</a></li>
      <li><a href="admin_setting.php">Settings</a></li>
      <li><a href="../logout.php" style="color: red; font-weight: bold;">Logout</a><li>
  </nav>
</div>

<div class="main expand" id="main">
  <div class="form-container">
    <h2>Form Preventive Maintenance</h2>
    <form method="post" action="">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <!-- Kolom Kiri -->
      <div class="column">
        <div class="form-group">
          <label for="departement">Departement</label>
          <select name="departement" id="departement">
            <option value="">None</option>
            <option value="it" <?= clean($_SESSION['input']['departement'] ?? '') === 'it' ? 'selected' : '' ?>>IT</option>
            <option value="hrd" <?= clean($_SESSION['input']['departement'] ?? '') === 'hrd' ? 'selected' : '' ?>>HRD</option>
            <option value="finance" <?= clean($_SESSION['input']['departement'] ?? '') === 'finance' ? 'selected' : '' ?>>Finance</option>
            <option value="marketing" <?= clean($_SESSION['input']['departement'] ?? '') === 'marketing' ? 'selected' : '' ?>>Marketing</option>
          </select>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="asset_tag">Asset Number <span class="required">*</span></label>
            <input type="text" name="asset_tag" id="asset_tag" required value="<?= clean($_SESSION['input']['asset_tag'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="asset_name">Asset Name <span class="required" >*</span></label>
            <input type="text" name="asset_name" id="asset_name" required value="<?= clean($_SESSION['input']['asset_name'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="category">Category </label>
            <input type="text" name="category" id="category" value="<?= clean($_SESSION['input']['category'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="supplier">Supplier </label>
            <input type="text" name="supplier" id="supplier" value="<?= clean($_SESSION['input']['supplier'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="location">Location </label>
            <input type="text" name="location" id="location" value="<?= clean($_SESSION['input']['location'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="status">Asset Status </label>
            <input type="text" name="status" id="status" value="<?= clean($_SESSION['input']['status'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="asset_user">Asset User </label><span class="required">*</span>
            <input type="text" name="asset_user" id="asset_user" required value="<?= clean($_SESSION['input']['asset_user'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="asset_admin">Asset Admin </label>
            <input type="text" name="asset_admin" id="asset_admin" value="<?= clean($_SESSION['input']['asset_admin'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="manufacturer">Manufacturer </label>
            <input type="text" name="manufacturer" id="manufacturer" value="<?= clean($_SESSION['input']['manufacturer'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="model">Model </label>
            <input type="text" name="model" id="model" value="<?= clean($_SESSION['input']['model'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row-end">
          <div class="form-group">
            <label for="maintenance_date">Maintenance Date <span class="required">*</span></label>
            <input type="date" name="maintenance_date" id="maintenance_date" required value="<?= clean($_SESSION['input']['maintenance_date'] ?? '') ?>">
          </div>
        </div>
      </div>

      <!-- Kolom Kanan -->
      <div class="column">
        <div class="form-group">
          <label for="device_merk">Device Merk <span class="required">*</span></label>
          <input type="text" name="device_merk" id="device_merk" required value="<?= clean($_SESSION['input']['device_merk'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label for="serial_number">Serial Number <span class="required">*</span></label>
          <input type="text" name="serial_number" id="serial_number" required value="<?= clean($_SESSION['input']['serial_number'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label for="ip_address">IP Address </label>
          <input type="text" name="ip_address" id="ip_address" value="<?= clean($_SESSION['input']['ip_address'] ?? '') ?>" pattern="(?:[0-9]{1,3}\.){3}[0-9]{1,3}" title="Masukkan IP address yang valid">
        </div>
        <div class="form-group">
          <label for="mac_address">MAC Address </label>
          <input type="text" name="mac_address" id="mac_address" value="<?= clean($_SESSION['input']['mac_address'] ?? '') ?>" pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$" title="Format: XX:XX:XX:XX:XX:XX">
        </div>
        <div class="form-group">
          <label for="bios_version">BIOS Version/Date <span class="required">*</span></label>
          <input type="date" name="bios_version" id="bios_version" required value="<?= clean($_SESSION['input']['bios_version'] ?? '') ?>">
        </div>
        <div class="form-row-end">
          <div class="button-container"> 
            <button type="submit" class="btn-submit">Next</button>
          </div>
        </div>
      </div>
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