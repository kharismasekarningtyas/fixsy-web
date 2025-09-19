<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <title>Data Saved Successfully</title>
  <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      /* text-align: center; */
      padding: 50px;
      background-color: #f2f2f2;
      
    }

    .container {
      background-color: #fff;
      padding: 30px;
      margin: auto;
      border-radius: 10px;
      max-width: 400px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: left;
      margin-bottom: 15px;
      font-size: 20px;
    }

    p {
      margin-top: 10px;
      font-size: 15px;
    }

    a.button {
      display: inline-block;
      margin-top: 10px;
      padding: 10px 20px;
      font-family: 'Poppins';
      font-size: 15px;
      background-color: #0d6efd;
      font-size: 11px;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
    }
    
    .button-container {
      display: flex;
      justify-content: flex-end;  /* --> dorong tombol ke kanan */
      margin-top: 5px;
      margin-bottom: 1px;
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
  <div class="container">
    <h2>✅ Registration Successful</h2>
    <p>Thank you! Your account has been successfully registered.</p>
    <div class="button-container">
      <a href="admin_register.php" class="button">Back</a>
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

</body>
</html>
