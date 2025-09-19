<?php
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM input");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Notifications</title>
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

    h2 {                   
      text-align: center;
      font-family: 'Poppins';
      margin-bottom: 20px;
      font-size: 20px;
    }
        
    .form-container {      
      background-color: #fff;
      padding: 20px 40px 30px 40px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
    }

    .notif {
      background-color:rgb(209, 240, 171);
      border: 1px solid #a8e063;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 10px;
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
  </nav>
</div>

<div class="main expand" id="main">
  <div class="form-container">
    <h2>Notifications</h2>
    <?php
    include 'koneksi.php';

    $data = mysqli_query($koneksi, "SELECT * FROM input");

    $notifikasi = [];
    $now = date('Y-m-d');

    while ($row = mysqli_fetch_assoc($data)) {
        $next_pm = date('Y-m-d', strtotime($row['maintenance_date'] . ' +6 months'));
        $days_diff = (strtotime($next_pm) - strtotime($now)) / (60 * 60 * 24);

        if ($days_diff <= 7 && $days_diff >= 0) {
            $row['next_pm'] = $next_pm;
            $row['days_diff'] = $days_diff;
            $notifikasi[] = $row;
        }
    }

    // Urutkan berdasarkan next_pm terdekat
    usort($notifikasi, function($a, $b) {
        return strtotime($a['next_pm']) - strtotime($b['next_pm']);
    });

    if (count($notifikasi) > 0) {
        foreach ($notifikasi as $row) {
            echo "<div class='notif'>
                    <strong>Reminder!</strong> Preventive Maintenance for
                    <strong>{$row['device_merk']}</strong> (SN: {$row['serial_number']}) 
                    is scheduled on <strong>{$row['next_pm']}</strong> (in {$row['days_diff']} " . 
                    ($row['days_diff'] == 1 ? "day" : "days") . ").
                  </div>";
        }
    } else {
        echo "<p>Tidak ada notifikasi saat ini.</p>";
    }
    ?>
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
