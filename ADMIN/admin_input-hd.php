<?php
session_start();

include 'koneksi.php';

// Fungsi sanitasi
function clean($data) {
  return htmlspecialchars(trim($data));
}

// Handle submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['input-hd'] = [
      'device_name' => clean($_POST['device_name']?? ''),
      'first' => clean($_POST['first']?? ''),
      'second' => clean($_POST['second']?? ''),
      'uploaded_file' => ($_SESSION['uploaded_file'] ?? '')
    ];

  // Validasi dan upload file
  if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === 0) {
    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $fileTmp = $_FILES['uploaded_file']['tmp_name'];
    $fileSize = $_FILES['uploaded_file']['size'];
    $fileMime = mime_content_type($fileTmp);
    $extension = strtolower(pathinfo($_FILES['uploaded_file']['name'], PATHINFO_EXTENSION));

    if (!in_array($fileMime, $allowedMimeTypes)) {
        die("Tipe file tidak diizinkan. Hanya JPG dan PNG.");
    }

    if (!in_array($extension, $allowedExtensions)) {
        die("Ekstensi file tidak diizinkan. Hanya JPG dan PNG.");
    }

    if ($fileSize > $maxSize) {
        die("Ukuran file terlalu besar. Maksimal 2MB.");
    }

    $targetDir = "uploads-hd/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true);
    }

    $file_name = uniqid("handover_", true) . "." . $extension;
    $targetPath = $targetDir . $file_name;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $_SESSION['uploaded_file'] = $file_name; // 
    } else {
        die("Gagal mengunggah file.");
    }
  } else {
    $_SESSION['uploaded_file'] = null;
  }


  if (isset($_POST['action']) && $_POST['action'] === 'save') {
    header("Location: admin_simpan-hd.php"); // lanjut ke simpan
    exit();
  }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Hand Over</title>
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

    .input-row input[type="text"], input[type="file"] {
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

    input[type="text"], input[type="file"] {   /*mengatur ukuran form kotakan*/
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
    <h2>Form Hand Over</h2>
    <form id=input-hd method="post" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="form-section">
          <h3>1. Hand Over Informations</h3>
          <div class="input-container">
            <div class="input-row">
              <label for="device_name">Device Name <span class="required">*</span></label>
              <input type="text" id="device_name" name="device_name" required value="<?= clean($_SESSION['input-hd']['device_name'] ?? '') ?>">
            </div>
            <div class="input-row">
              <label for="first">First Party <span class="required">*</span></label>
              <input type="text" id="first" name="first" required value="<?= clean($_SESSION['input-hd']['first'] ?? '') ?>">
            </div>
            <div class="input-row">
              <label for="second">Second Party <span class="required">*</span></label>
              <input type="text" id="second" name="second" required value="<?= clean($_SESSION['input-hd']['second'] ?? '') ?>">
            </div>
          </div>
        </div>

      <div class="form-group">
        <div class="form-section">
          <br>
          <h3>2. Upload Document</h3>
            <div class="input-row">
              <label for="uploaded_file">Upload File (JPG/PNG)<span class="required">*</span></label></label>
              <input type="file" name="uploaded_file" id="uploaded_file" accept=".jpg,.png" required>
            </div>
            </div>
          </div>
        </div>

        <div class="button-container">
          <button type="submit" name="action" id="btn-save" value="save" class="btn-submit">Save</button>
        </div>
    </form>
  </div>
<div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("input-hd");
    const btnSave = document.getElementById("btn-save");
    const uploadInput = document.getElementById("uploaded_file");

    btnSave.addEventListener("click", function (e) {
      // Validasi hanya dijalankan jika tombol Save ditekan
      if (!form.checkValidity()) {
        e.preventDefault();
        form.reportValidity();
      }
    });
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
