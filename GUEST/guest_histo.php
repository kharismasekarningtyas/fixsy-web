<?php
include 'koneksi.php';
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
        <li><a href="guest_desktop.php">Dashboard</a></li>
        <li><a href="guest_about.php">About</a></li>
        <li><a href="guest_histo.php">Histories</a></li>
        <li><a href="guest_setting.php">Settings</a></li>
        <li><a href="../logout.php" style="color: red; font-weight: bold;">Logout</a><li>
      </ul>
    </nav>
  </div>

  <div class="main expand" id="main">
    <div class="form-container">
      <h2>This feature is coming soon.</h2>
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
