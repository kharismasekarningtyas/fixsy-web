<?php
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM input");

$data_array = [];
while ($row = mysqli_fetch_assoc($data)) {
    $row['next_pm'] = date('Y-m-d', strtotime($row['maintenance_date'] . ' +6 months'));
    $data_array[] = $row;
}

// Urutkan berdasarkan next_pm
usort($data_array, function($a, $b) {
    return strtotime($a['next_pm']) - strtotime($b['next_pm']);
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Maintenance</title>
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

        .container-table {
            width: 100%;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background-color: #fff;
        }

        table {
            table-layout: auto; 
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #56ab2f;
            color: #fff;
            font-weight: bold;
            padding: 15px;
            text-align: center;
        }

        th:nth-child(1), td:nth-child(1) {
            width: 15%;
            text-align: center;
        }

        th:nth-child(2), td:nth-child(2) {
            width: 20%;
            text-align: center;
        }

        th:nth-child(6), td:nth-child(6) {
            width: 18%;
            text-align: center;
        }

        td {
            background-color: #fff;
            color: #000;
            padding: 30px;
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
    <span class="menu-icon" id="toggleSidebar">☰</span> 
    <h3>Home</h3>
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
        <h2>Maintenance</h2>
        <div style="overflow-x: auto;" class="container-table">
          <table>
            <tr>
              <th>Device Merk</th>
              <th>Serial Number</th>
              <th>User</th>
              <th>Last PM</th>
              <th>Next PM</th>
              <th>Action</th> 
            </tr>
            <?php foreach ($data_array as $row) { ?>
            <tr class="data-row">
              <td style="text-align: center;"><?= $row['device_merk'] ?></td>
              <td style="text-align: center;"><?= $row['serial_number'] ?></td>
              <td style="text-align: center;"><?= $row['asset_user'] ?></td>
              <td style="text-align: center;"><?= $row['maintenance_date'] ?></td>
              <td style="text-align: center;">
                <?= $row['next_pm'] ?>
              </td>
              <td style="text-align: center;">
                <button class="action-btn" style="cursor: pointer" data-id="<?= $row['serial_number']; ?>">✔️</button>
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
<!-- ============ JavaScript buat Actions ============ -->
<script>
  document.querySelectorAll('.action-btn').forEach(function(button) {
    button.addEventListener('click', function() {
      const serial = this.dataset.serial;

      alert("Please fill out the preventive maintenance form.\nYou will be redirected to the form now.");
        window.location.href = 'super_input.php?serial=' + serial;
    });
  });
</script>

</body>
</html>