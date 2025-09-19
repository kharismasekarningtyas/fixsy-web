<?php
session_start();
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

$software = [];
if (isset($_SESSION['input3'])) {
  foreach (['sap' => 'SAP', 'chrome' => 'Google Chrome', 'acrobat' => 'Acrobat Reader DC', 'vnc' => 'Ultra VNC Viewer', 'vlc' => 'VLC Media Player', 'fp' => 'Forcepoint', 'pv' => 'Project Viewer'] as $key => $value) {
    if (!empty($_SESSION['input3'][$key])) {
      $software[] = $value;
    }
  }
}

// Handle submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['input3'] = [
      'os' => clean($_POST['os'] ?? ''),
      'antivirus' => clean($_POST['antivirus'] ?? ''),
      'office' => clean($_POST['office'] ?? ''),
      'sap' => in_array('SAP', $_POST['software'] ?? []) ? 1 : 0,
      'chrome' => in_array('Google Chrome', $_POST['software'] ?? []) ? 1 : 0,
      'acrobat' => in_array('Acrobat Reader DC', $_POST['software'] ?? []) ? 1 : 0,
      'vnc' => in_array('Ultra VNC Viewer', $_POST['software'] ?? []) ? 1 : 0,
      'vlc' => in_array('VLC Media Player', $_POST['software'] ?? []) ? 1 : 0,
      'fp' => in_array('Forcepoint', $_POST['software'] ?? []) ? 1 : 0,
      'pv' => in_array('Project Viewer', $_POST['software'] ?? []) ? 1 : 0,
      'add_1' => clean($_POST['add_1'] ?? ''),
      'add_2' => clean($_POST['add_2'] ?? ''),
      'uploaded_file' => ($_SESSION['uploaded_file'] ?? '')
    ];

  // Validasi dan upload file
  if (isset($_FILES['upload_doc']) && $_FILES['upload_doc']['error'] === 0) {
    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $fileTmp = $_FILES['upload_doc']['tmp_name'];
    $fileSize = $_FILES['upload_doc']['size'];
    $fileMime = mime_content_type($fileTmp);
    $extension = strtolower(pathinfo($_FILES['upload_doc']['name'], PATHINFO_EXTENSION));

    if (!in_array($fileMime, $allowedMimeTypes)) {
        die("Tipe file tidak diizinkan. Hanya JPG dan PNG.");
    }

    if (!in_array($extension, $allowedExtensions)) {
        die("Ekstensi file tidak diizinkan. Hanya JPG dan PNG.");
    }

    if ($fileSize > $maxSize) {
        die("Ukuran file terlalu besar. Maksimal 2MB.");
    }

    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true);
    }

    $filename = uniqid("upload_", true) . "." . $extension;
    $targetPath = $targetDir . $filename;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $_SESSION['uploaded_file'] = $filename; // 
    } else {
        die("Gagal mengunggah file.");
    }
  } else {
    $_SESSION['uploaded_file'] = null;
  }


  if (isset($_POST['action']) && $_POST['action'] === 'back') {
    header("Location: admin_input2.php"); // back ke step sebelumnya
    exit();
  } else if (isset($_POST['action']) && $_POST['action'] === 'save') {
    header("Location: admin_simpan.php"); // lanjut ke simpan
    exit();
  }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Preventive Maintenance</title>
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

    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px 20px;
      margin-top: 5px;
      margin-left: 17px;
    }

    .checkbox-grid label {
      display: flex;
      align-items: center;
      font-size: 11px;
    }

    input[type="checkbox"] {
      margin-right: 8px;
      transform: scale(1.3);
      gap: 10px;
    }

    .lainnya-wrapper {
      width: 30%;
      display: flex;
      align-items: center;
      font-size: 11px;
      font-family: 'Poppins', Segoe UI;
      gap: 3px; 
    }

    .lainnya-input {
      border-bottom: 1px solid #000;
      min-width: 100px;
      min-height: 20px;
      outline: none;
    }

    .button-container {                 /*mengatur tata letak button agar menjadi rata kanan dan rata kiri*/
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      /* margin-bottom: 1px; */
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
    <h2>Form Preventive Maintenance</h2>
    <form id=step3 method="post" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="form-section">
          <h3>2. Standard Software</h3>
          <div class="input-container">
            <div class="input-row">
              <label for="os">Operating System <span class="required">*</span></label>
              <input type="text" id="os" name="os" required value="<?= clean($_SESSION['input3']['os'] ?? '') ?>">
            </div>

            <div class="input-row">
              <label for="antivirus">Antivirus <span class="required">*</span></label>
              <input type="text" id="antivirus" name="antivirus" required value="<?= clean($_SESSION['input3']['antivirus'] ?? '') ?>">
            </div>

            <div class="input-row">
              <label for="office">Office <span class="required">*</span></label>
              <input type="text" id="office" name="office" required value="<?= clean($_SESSION['input3']['office'] ?? '') ?>">
            </div>
          </div>
        </div>

      <div class="form-group">
        <div class="form-section">
          <h3>3. Additional Software</h3>
          <div class="checkbox-grid">
            <?php
            $softwareList = [
              "SAP",
              "Ultra VNC Viewer",
              "Project Viewer",
              "Google Chrome",
              "VLC Media Player",
              "Acrobat Reader DC",
              "Forcepoint"
            ];

            foreach ($softwareList as $sw) {
              echo '<label><input type="checkbox" name="software[]" value="'. $sw .'" '. (in_array($sw, $software) ? 'checked' : '') .'>'. $sw .'</label>';
            }
            ?>
            
            <div class="lainnya-wrapper">
              <label>
                <input type="checkbox" name="add_1_check" value="1"
                  <?= isset($_SESSION['input3']['add_1']) && $_SESSION['input3']['add_1'] !== '' ? 'checked' : '' ?>>
                <input type="text" name="add_1" class="lainnya-input"
                  value="<?= clean($_SESSION['input3']['add_1'] ?? '') ?>" placeholder="Others...">
              </label>
            </div>

            <div class="lainnya-wrapper">
              <label>
                <input type="checkbox" name="add_2_check" value="1"
                  <?= isset($_SESSION['input3']['add_2']) && $_SESSION['input3']['add_2'] !== '' ? 'checked' : '' ?>>
                <input type="text" name="add_2" class="lainnya-input"
                  value="<?= clean($_SESSION['input3']['add_2'] ?? '') ?>" placeholder="Others...">
              </label>
            </div>
          </div>

      <div class="form-group">
        <div class="form-section">
          <br>
          <h3>4. Upload Document</h3>
            <div class="input-row">
              <label for="upload_doc">Upload File (JPG/PNG)<span class="required">*</span></label></label>
              <input type="file" name="upload_doc" id="upload_doc" accept=".jpg,.png" required>
            </div>
          </div>
        </div>

        <div class="button-container">
        <button type="submit" name="action" id="btn-back" value="back" class="btn-submit">Back</button>
        <button type="submit" name="action" id="btn-save" value="save" class="btn-submit">Save</button>
        </div>
    </form>
  </div>
<div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("step3");
    const btnBack = document.getElementById("btn-back");
    const btnSave = document.getElementById("btn-save");
    const uploadInput = document.getElementById("upload_doc");

    btnBack.addEventListener("click", function (e) {
      // Hapus required agar bisa submit tanpa file
      form.querySelectorAll("[required]").forEach(input => input.removeAttribute("required"));
      uploadInput.removeAttribute("required")
    });

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
