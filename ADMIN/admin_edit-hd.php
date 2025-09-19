<?php
include 'koneksi.php';

// Fungsi sanitasi
function clean($data) {
  return htmlspecialchars(trim($data));
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM handover WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_name = clean($_POST['device_name'] ?? '');
    $first = clean($_POST['first'] ?? '');
    $second = clean($_POST['second'] ?? '');

    // Periksa apakah file baru diupload
    if (!empty($_FILES['uploaded_file']['name'])) {
        // Ganti spasi dengan underscore & beri timestamp supaya unik
        $original_name = $_FILES['uploaded_file']['name'];
        $tmp_name = $_FILES['uploaded_file']['tmp_name'];
        $extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $unique_part = uniqid() . '.' . time();
        $clean_name = 'handover_' . $unique_part . '.' . $extension;
        $upload_path = "uploads-hd/$clean_name";

        // Hapus file lama jika ada
        if (!empty($row['uploaded_file']) && file_exists("uploads-hd/" . $row['uploaded_file'])) {
            unlink("uploads-hd/" . $row['uploaded_file']);
        }

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Update dengan nama file baru
            $update = mysqli_query($koneksi, "UPDATE handover SET 
                device_name='$device_name',
                first='$first',
                second='$second',
                uploaded_file='$clean_name' 
                WHERE id='$id'");
        } else {
            echo "Gagal upload file baru!";
            exit;
        }
    } else {
        // Jika tidak upload file baru, update data selain file
        $update = mysqli_query($koneksi, "UPDATE handover SET 
            device_name='$device_name',
            first='$first',
            second='$second' 
            WHERE id='$id'");
    }

    if ($update) {
        header("Location: admin_handover.php");
        exit;
    } else {
        echo "Gagal update data!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Hand Over</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', Segoe UI, sans-serif;
            background-color:rgb(240, 240, 242);
            padding: 15px;
            font-size: 13px;
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

        .form-section h4 {      /*memberikan jarak yang ada di bawan check device functions*/
            font-size: 15px;
        }

        .form-section p {
            font-size: 10px;
            margin-left: 15px;
            margin-top: 10px;
            margin-bottom: 15px;
            color: #555;
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
        <span class="menu-icon" id="toggleSidebar">☰</span> 
        <h3>Home</h3>
    </div>
    <nav>
      <ul>
        <li><a href="admin_desktop.php">Dashboard</a></li>
        <li><a href="admin_about.php">About</a></li>
        <li><a href="admin_notif.php">Notifications</a></li>
        <li><a href="admin_histo.php">Histories</a></li>
        <li><a href="admin_setting.php">Settings</a></li>
        <li><a href="../logout.php" style="color: red; font-weight: bold;">Logout</a><li>
      </ul>
    </nav>
    </div>
    <div class="main expand" id="main">
        <div class="form-container">
            <h2>Edit Data Hand Over</h2>
            <form id=edit-hd method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-section">
                    <h3>1. Hand Over Informations</h3>
                    <div class="input-container">
                        <div class="input-row">
                        <label for="device_name">Device Name <span class="required">*</span></label>
                        <input type="text" id="device_name" name="device_name" required value="<?= clean($row['device_name'] ?? '') ?>">
                        </div>
                        <div class="input-row">
                        <label for="first">First Party <span class="required">*</span></label>
                        <input type="text" id="first" name="first" required value="<?= clean($row['first'] ?? '') ?>">
                        </div>
                        <div class="input-row">
                        <label for="second">Second Party <span class="required">*</span></label>
                        <input type="text" id="second" name="second" required value="<?= clean($row['second'] ?? '') ?>">
                        </div>
                    </div>
                    </div>

                <div class="form-group">
                    <div class="form-section">
                      <br>
                      <h4>2. Upload Document </h4>
                      <p>(Leave empty if you do not wish to change it)</p>
                        <div class="input-row">
                        <label for="uploaded_file">Upload File (JPG/PNG)</label></label>
                        <input type="file" name="uploaded_file" id="uploaded_file" accept=".jpg,.png" value="<?= clean($row['uploaded_file'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                    
                <div class="button-container">
                    <button type="submit" name="action" id="btn-save" value="save" class="btn-submit">Update</button>
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
