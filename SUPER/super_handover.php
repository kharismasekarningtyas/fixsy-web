<?php
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM handover");
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
if ($search) {
    $data = mysqli_query($koneksi, "SELECT * FROM handover WHERE device_name LIKE '%$search%' ORDER BY created_at DESC");
} else {
    $data = mysqli_query($koneksi, "SELECT * FROM handover ORDER BY created_at DESC");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hand Over</title>
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
            margin-bottom: 40px;
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
            background-color:rgb(127, 245, 154);
        }

        .error {
            background-color:rgb(247, 154, 163);
        }

        .add-button {
            background-color: #e8f0ff;
            color: #000;
            padding: 12px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            margin-bottom: 19px;
            font-family: 'Poppins', sans-serif;
            align-items: stretch;
        }

        .add-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .add-button:active {
            transform: scale(0.96);
        }

        .addsearch-container {
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
            color: #fff;
            font-weight: bold;
            padding: 15px;
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
    </ul>
  </nav>
</div>
<div class="main expand" id="main">
    <div class="form-container">
        <h2>Hand Over</h2>
        <div class="addsearch-container">
          <a href="super_input-hd.php" class="add-button" id="add-button" style="background-color: #ddd;">
            Add Data
          </a>
          <input type="text" id="searchInput" placeholder="Search...">
        </div>
        <div style="overflow-x: auto;" class="container-table">
          <table>
            <tr>
              <th>Date</th>
              <th>Device Name</th>
              <th>First Party</th>
              <th>Second Party</th>
              <th>View File</th>
              <th>Action</th> 
            </tr>
          <?php while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr class="data-row">
              <td style="text-align: center;"><?= $row['created_at'] ?></td>
              <td style="text-align: center;"><?= $row['device_name'] ?></td>
              <td style="text-align: center;"><?= $row['first'] ?></td>
              <td style="text-align: center;"><?= $row['second'] ?></td>
              <td style="text-align: center;">
              <?php if (!empty($row['uploaded_file'])): ?>
                <a href="../uploads-hd/<?= urlencode($row['uploaded_file']) ?>" target="_blank" title="View File">
                <img src="../assets/view.png" style="width: 20px; height: 20px;" />
                </a>
                <?php else: ?>
                  <img src="../assets/view.png" style="color: #ccc; width: 20px; height: 20px;" title="No file uploaded"></i>
                <?php endif; ?>
              </td>
              <td style="text-align: center;">
                <a href="super_edit-hd.php?id=<?= $row['id'] ?>" style="color: blue; text-decoration: none;">Edit</a> | 
                <a href="super_delete-hd.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus file?')" style="color: red; text-decoration: none;">Delete</a>
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