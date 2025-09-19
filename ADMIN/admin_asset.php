<?php
include 'koneksi.php';

$query1 = mysqli_query($koneksi, "SELECT * FROM input");
$normal = 0;
$error  = 0;

// Hitung status berdasarkan isian semua kolom komponen
$query2 = mysqli_query($koneksi, "SELECT * FROM input2");
while ($row2 = mysqli_fetch_assoc($query2)) {
    $status = 'normal';
    foreach ($row2 as $key => $value) {
        if (in_array($key, ['id', 'asset_id', 'monitor_info', 'ram_info', 'hardisk_info', 'power_info', 'dvd_info', 'keyboard_info', 'mouse_info', 'clean_info'])) {
            continue;
        }
        if (empty(trim($value)) || strtolower(trim($value)) !== 'normal') {
            $status = 'error';
            break;
        }
    }
    if ($status === 'normal') {
        $normal++;
    } else {
        $error++;
    }
}
$query3 = mysqli_query($koneksi, "SELECT * FROM input3");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assets</title>
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

        h4 {
            text-align: center;
        }
        
        h2 {                    /* ------> mengatur style judul form preventive maintenance */
            text-align: center;
            font-family: 'Poppins';
            margin-bottom: 20px;
            font-size: 20px;
        }

        .form-container {      /* ------> menambahkan kotak putih di depan background*/
            background-color: #fff;
            padding: 20px 40px 30px 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .box-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }

        .link-box {
            text-decoration: none;
            color: inherit;
            display: inline-block;
        }

        .box {
            width: 200px;
            padding: 30px 20px;
            color: black;
            border-radius: 15px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .box:active {
            transform: scale(0.97);
        }

        .normal {
            background-color: #a8e063;
        }

        .error {
            background-color:rgb(221, 76, 90);
        }

        .showallbutton {
            background-color: #eee9fd;
            color: #000;
            padding: 12px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 2px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
            align-items: stretch;
        }

        .showallbutton:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .showallbutton:active {
            transform: scale(0.96);
        }

        .showsearch-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        #searchInput {
            padding: 10px 20px;
            width: 75%;
            max-width: 400px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 10px;
        }

        .container-table {
            width: 100%;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background-color: #fff;
        }

        table {
            table-layout: fixed;  
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #56ab2f;
            color: #fff;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        td {
            background-color: #fff;
            color: #000;
            padding: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        tr:nth-child(even) td {
            background-color: white;
        }

        th:first-child {
            border-top-left-radius: 12px;
        }

        th:last-child {
            border-top-right-radius: 12px;
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
    </ul>
  </nav>
</div>
<div class="main expand" id="main">
    <div class="form-container">
        <h2>Assets</h2>

        <div class="box-container">
            <div class="box normal" id="filterNormal">
                <h4><div><?= $normal ?></div>
                <div>Normal</div></h4>
            </div>
            <div class="box error" id="filterError">
                <h4><div><?= $error ?></div>
                <div>Error</div></h4>
            </div>
            <a href="admin_input.php" class="box" id="add-device" style="background-color: #ddd; text-decoration: none; color: inherit;">
                <h4><div>Add</div>
                <div>Device</div></h4>
            </a>
        </div>

        <div class="showsearch-container">
            <div class="showallbutton" id="showAll" style="background-color: #ddd;">
                Show All
            </div>
            <input type="text" id="searchInput" placeholder="Search...">
        </div>

        <div style="overflow-x: auto;" class="container-table"> 
            <table>
                <tr>
                    <th>Device Name</th>
                    <th>Serial Number</th>
                    <th>No Asset</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Uploaded File</th>
                </tr>
                <?php while ($row1 = mysqli_fetch_assoc($query1)) { ?>
                <tr
                    <?php
                    $id = $row1['id'];
                    $q = "SELECT * FROM input2 WHERE id = '$id'";
                    $result2 = mysqli_query($koneksi, $q);
                    $row2 = mysqli_fetch_assoc($result2);

                    $row3 = mysqli_fetch_assoc($query3);

                    $komponen = ['monitor', 'ram', 'hardisk', 'power', 'dvd', 'keyboard', 'mouse', 'clean_device'];
                    $status = 'normal';
                    foreach ($komponen as $key) {
                        if (isset($row2[$key])) {
                            $value = strtolower(trim($row2[$key]));
                            if ($value !== 'normal' && $value !== '') {
                                $status = 'error';
                                break;
                            }
                        }
                    }
                    echo "class='data-row $status'";
                    ?>
                >
                    <td style="text-align: center;"><?= $row1['device_merk'] ?></td>
                    <td style="text-align: center;"><?= $row1['serial_number'] ?></td>
                    <td style="text-align: center;"><?= $row1['asset_tag'] ?></td>
                    <td style="text-align: center;"><?= $row1['asset_user'] ?></td>
                    <td style="text-align: center;">
                        <p style="color: <?= $status === 'error' ? 'red' : 'green' ?>; font-weight: bold;">
                            <?= ucfirst($status) ?>
                        </p>
                    </td>
                    <td style="text-align: center;">
                        <?php if (!empty($row3['uploaded_file'])): ?>
                            <a href="../uploads/<?= urlencode($row3['uploaded_file']) ?>" target="_blank" title="View File">
                                <img src="../assets/view.png" style="width: 20px; height: 20px;" />
                            </a>
                        <?php else: ?>
                            <img src="../assets/view.png" style="color: #ccc; width: 20px; height: 20px;" title="No file uploaded"></i>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<!-- ============ JavaScript buat Sidebar Toggle ============ -->
<script>
document.getElementById("toggleSidebar").onclick = function () {
    document.getElementById("sidebar").classList.toggle("hide");
    document.getElementById("main").classList.toggle("expand");
  };
</script>
<!-- ============ JavaScript buat Filter Status ============ -->
<script>
document.getElementById("filterNormal").addEventListener("click", function () {
    document.querySelectorAll(".data-row").forEach(row => {
        row.style.display = row.classList.contains("normal") ? "" : "none";
    });
});

document.getElementById("filterError").addEventListener("click", function () {
    document.querySelectorAll(".data-row").forEach(row => {
        row.style.display = row.classList.contains("error") ? "" : "none";
    });
});

document.getElementById("showAll").addEventListener("click", function () {
    document.querySelectorAll(".data-row").forEach(row => {
        row.style.display = "";
    });
});
</script>
<!-- ============ JavaScript buat Search ============ -->
<script>
document.getElementById("searchInput").addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll(".data-row").forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? "" : "none";
    });
});
</script>

</body>
</html>