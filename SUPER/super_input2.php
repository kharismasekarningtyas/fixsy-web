<?php
  session_start();
  if (isset($_GET['reset']) && $_GET['reset'] === 'true') {
    session_destroy(); // atau unset($_SESSION['step1'], $_SESSION['step2']);
    header("Location: super_input.php"); // redirect biar URL bersih
    exit();
  }

  include 'koneksi.php';

  // Fungsi sanitasi
  function clean($data) {
    return htmlspecialchars(trim($data));
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['input2'] = [
      'monitor' => clean($_POST['monitor'] ?? ''),
      'monitor_info' => clean($_POST['monitor_info'] ?? ''),
      'ram' => clean($_POST['ram'] ?? ''),
      'ram_info' => clean($_POST['ram_info'] ?? ''),
      'hardisk' => clean($_POST['hardisk'] ?? ''),
      'hardisk_info' => clean($_POST['hardisk_info'] ?? ''),
      'power' => clean($_POST['power'] ?? ''),
      'power_info' => clean($_POST['power_info'] ?? ''),
      'dvd' => clean($_POST['dvd'] ?? ''),
      'dvd_info' => clean($_POST['dvd_info'] ?? ''),
      'keyboard' => clean($_POST['keyboard'] ?? ''),
      'keyboard_info' => clean($_POST['keyboard_info'] ?? ''),
      'mouse' => clean($_POST['mouse'] ?? ''),
      'mouse_info' => clean($_POST['mouse_info'] ?? ''),
      'clean_device' => clean($_POST['clean_device'] ?? ''),
      'clean_info' => clean($_POST['clean_info'] ?? '')
    ];
    
    if (isset($_POST['action']) && $_POST['action'] === 'back') {
      header("Location: super_input.php");
      exit();
    } else {
      header("Location: super_input3.php");
      exit();
    }
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Form Preventive Maintenance</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        font-family: 'Poppins', Segoe UI;
        background-color: #f1f1f1;
        padding: 15px;
      }

      /* === Form Container === */
      .form-container {
        background-color: #fff;
        padding: 20px 40px 20px 40px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
      }

      /* === Judul Form === */
      h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 20px;
      }

      .form-section h3 {
        margin-bottom: 15px;
        font-size: 15px;
      }

      /* === Struktur Form === */
      .form-row {
        display: flex;
        gap: 25px;
        margin-bottom: 10px;
        justify-content: space-between;
      }

      label {
        flex: 1.2;
        font-size: 11px;
        font-family: 'Poppins', Segoe UI;
        margin-left: 15px;
        align-self: center;
      }

      .required {
        color: red;
        color: red;
        vertical-align: top;
        font-size: 11px;
      }

      input[type="text"],
      input[type="date"],
      select {
        flex: 1.6;
        padding: 5px;
        margin-bottom: 7px;
        font-size: 11px;
        font-family: 'Poppins', Segoe UI;
        border: 2px solid #ccc;
        border-radius: 4px;
      }

      /* === Tombol === */
      .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 17px;
        margin-bottom: 13px;
      }

      .btn-submit {
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
      <li><a href="../logout.php" style="color: red; font-weight: bold;">Logout</a><li>
  </nav>
</div>

<div class="main expand" id="main">
  <div class="form-container">
    <h2>Form Preventive Maintenance</h2>
    <form id="step3" method="post" action="">
      <div class="form-section">
        <h3>1. Device Functionality Check</h3>
          <div class="form-row">
            <label for="monitor">Monitor/ LCD <span class="required">*</span></label>
            <select name="monitor" id="monitor" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['monitor'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['monitor'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="ram_info" id="ram_info" value="<?= clean($_SESSION['input2']['ram_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="ram">RAM <span class="required">*</span></label>
            <select name="ram" id="ram" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['ram'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['ram'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="ram_info" id="ram_info" value="<?= clean($_SESSION['input2']['ram_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="hardisk">Hardisk <span class="required">*</span></label>
            <select name="hardisk" id="hardisk" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['hardisk'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['hardisk'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="hardisk_info" id="hardisk_info" value="<?= clean($_SESSION['input2']['hardisk_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="power">Power Supply/ Adaptor/ Battery <span class="required">*</span></label>
            <select name="power" id="power" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['power'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['power'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="power_info" id="power_info" value="<?= $_SESSION['input2']['power_info'] ?? '' ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="dvd">DVD/CD ROM <span class="required">*</span></label>
            <select name="dvd" id="dvd" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['dvd'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['dvd'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="dvd_info" id="dvd_info" value="<?= clean($_SESSION['input2']['dvd_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="keyboard">Keyboard <span class="required">*</span></label>
            <select name="keyboard" id="keyboard" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['keyboard'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['keyboard'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="keyboard_info" id="keyboard_info" value="<?= clean($_SESSION['input2']['keyboard_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="mouse">Mouse <span class="required">*</span></label>
            <select name="mouse" id="mouse" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['mouse'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['mouse'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="mouse_info" id="mouse_info" value="<?= clean($_SESSION['input2']['mouse_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>

          <div class="form-row">
            <label for="clean_device">Clean of the device <span class="required">*</span></label>
            <select name="clean_device" id="clean_device" required>
              <option value="" disabled selected hidden>Kondisi</option>
              <option value="normal" <?= clean($_SESSION['input2']['clean_device'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
              <option value="error" <?= clean($_SESSION['input2']['clean_device'] ?? '') === 'error' ? 'selected' : '' ?>>Error</option>
            </select>
            <input type="text" name="clean_info" id="clean_info" value="<?= clean($_SESSION['input2']['clean_info'] ?? '') ?>" placeholder="Add details if necessary" />
          </div>
          <div class="button-container">
            <button type="submit" name="action" id="btn-back" value="back" class="btn-submit">Back</button>
            <button type="submit" name="action" id="btn-next" value="save" class="btn-submit">Next</button>
          </div>    
      </div>
    </form>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("step3");
    const btnBack = document.getElementById("btn-back");
    const btnNext = document.getElementById("btn-next");

    // Tombol Back - hapus validasi
    btnBack.addEventListener("click", function () {
      // Menonaktifkan validasi form
      form.setAttribute("novalidate", "true");
      removeRequiredAttributes();
    });

    // Tombol Next - aktifkan validasi
    btnNext.addEventListener("click", function (e) {
      // Menghapus novalidate sebelum validasi
      form.removeAttribute("novalidate");
      addRequiredAttributes();

      // Cek validitas form, jika tidak valid, batalkan pengiriman
      if (!form.checkValidity()) {
        e.preventDefault();  // Mencegah pengiriman form
        form.reportValidity();  // Menampilkan pesan validasi
      }
    });

    // Fungsi untuk menambahkan atribut 'required' pada elemen select
    function addRequiredAttributes() {
      const selects = form.querySelectorAll('select');
      selects.forEach(select => {
        select.setAttribute("required", "true");  // Menambahkan atribut required
      });
    }

    // Fungsi untuk menghapus atribut 'required' pada elemen select
    function removeRequiredAttributes() {
      const selects = form.querySelectorAll('select');
      selects.forEach(select => {
        select.removeAttribute("required");  // Menghapus atribut required
      });
    }
  });
</script>
<!-- ============ JavaScript buat Sidebar Toggle ============ -->
<script>
  document.getElementById("toggleSidebar").onclick = function () {
    document.getElementById("sidebar").classList.toggle("hide");
    document.getElementById("main").classList.toggle("expand");
  };
</script>

</body>
</html>


    

