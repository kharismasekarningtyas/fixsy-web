<!DOCTYPE html>
<html>
<head>
    <title>About</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', Segoe UI;
            background-color:  #f4f6fc;
            padding: 40px;
            line-height: 1.6;
        }
            h1 {
            text-align: center;
            font-size: 35px;
        }
        h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 8px;
        }
        .info-section {
            max-width: 800px;
            margin: 20px auto;
            background: #56ab2f;
            color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
            font-size: 15px;
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
            color: #000;
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
      <li><a href="logout.php" style="color: red; font-weight: bold;">Logout</a><li>
  </nav>
</div>

<div class="main expand" id="main">
  <div class="form-container">
    <h1>About</h1>
    <div class="info-section">
        <h2>Device Status </h2>
        <p><strong>Normal:</strong> The device is operating normally.</p>
        <p><strong>Error:</strong> The device is experiencing issues and requires maintenance.</p>
        <p><strong>Done:</strong> The device has been repaired and is ready for use.</p>
    </div>
    <div class="info-section">
        <h2>Maintenance Schecule</h2>
        <p>Routine maintenance is carried out every six months to ensure the equipment remains in optimal condition.</p>
    </div>
    <div class="info-section">
        <h2>PIC Contact</h2>
        <p>Contact the IT department.</p>
    </div>
    <div class="info-section">
        <h2>User guide</h2>
        <p>Use the "Add Device" button to input new data. To update the device status, use the "Maintenance" menu.</p>
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
