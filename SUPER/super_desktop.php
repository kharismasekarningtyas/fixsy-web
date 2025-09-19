<?php
session_start();

// Koneksi ke database
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil username dari session
$username = $_SESSION['username'];

// Untuk tabel To Do
$query = "
    SELECT i.id, i.device_merk, i.serial_number, i.asset_user, i2.*
    FROM input i
    JOIN input2 i2 ON i.id = i2.id
";

$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - Super Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
/* Ini buat atur tampilan keseluruhan halaman */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* Warna background dan layout halaman */
body {
  background-color: #f4f6fc;
  display: flex;
  min-height: 100vh;
  overflow-x: hidden;
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
  margin-left: 60px;
}

/*agar main menyesuaikan posisinya ketika sidebar ditutup*/
.main.expand {
    margin-left: 60px !important;
  }

/* Header atas */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

/* Judul halaman */
.title-section {
  display: flex;
  flex-direction: column;
}

/* Teks judul */
.title-section h1 {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 5px;
}

/* Teks tanggal */
.title-section .date {
  font-size: 12px;
  color: #555;
}

/* Nama profil user */
.profile {
  font-weight: 600;
}

/* ============ Welcome Section ============ */
.welcome-section {
  background: linear-gradient(135deg, #56ab2f);
  border-radius: 15px;
  padding: 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 30px;
  position: relative;
  overflow: visible; 
}

.welcome-section .text-section {
  position: relative;
  z-index: 2; 
  max-width: 60%;
  color: white;
}

/* Gambar di welcome section */
.welcome-section img {
  position: absolute;
  right: 50px;
  bottom: 0;
  width: 220px;
}

/* ============ Overview Cards ============ */
.overview h3, .last-edited h3 {
  font-size: 14px;
  color: black;
  margin-bottom: 10px;
}

/* Kartu-kartu overview */
.cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 30px;
}

/* Tiap kartu */
.card {
  flex: 1 1 200px;
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
  text-align: center;
  color: white
}

/* Icon dalam kartu */
.card-icon {
  font-size: 30px;
  margin-bottom: 10px;
}

/* Warna background tiap kartu */
.card.yellow { background: linear-gradient(135deg, #56ab2f) }
.card.blue { background:linear-gradient(135deg, #56ab2f) }
.card.gray { background: linear-gradient(135deg, #56ab2f) }

/* ============ Tabel ============ */
table {
  width: 100%;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
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
  font-size: 14px;
}

td {
  background-color: #fff;
  color: #000;
  padding: 20px;
  font-size: 13px;
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
</style>

</head>
<body>

<!-- Sidebar -->
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

<!-- Main Content -->
<div class="main expand" id="main">
  <div class="header">
    <div class="title-section">
      <h1>Dashboard</h1>
      <div class="date">
        <?php 
          date_default_timezone_set('Asia/Jakarta'); 
          echo date('l, d F Y'); 
        ?>
      </div>
    </div>
  </div>

  <!-- Welcome Section -->
  <div class="welcome-section">
    <div class="text-section">
      <h2>Hello, <?= htmlspecialchars($username) ?>!</h2>
      <p>Easily check and manage all your assets here</p>
    </div>
    <!-- <div class="image-section">
      <img src="../assets/image1.png" alt="Illustration">
    </div> -->
  </div>

  <!-- Overview Cards -->
  <div class="overview">
    <h3>Overview</h3>
    <div class="cards">
    <!-- Setiap card menunjukkan data berbeda -->
<div class="card yellow" onclick="window.location.href='super_asset.php'" style="cursor: pointer;">
        <div class="card-icon">📋</div>
        <div><strong>Assets</strong></div>
      </div>
      <div class="card gray" onclick="window.location.href='super_mainte.php'" style="cursor: pointer;">
        <div class="card-icon">🛠️</div>
        <div><strong>Maintenance</strong></div>
      </div>
      <div class="card blue" onclick="window.location.href='super_handover.php'" style="cursor: pointer;">
        <div class="card-icon">ℹ️</div>
        <div><strong>Hand Over</strong></div>
      </div>
    </div>
  </div>

   <!-- Todo Table -->
  <div class="overview">
    <h3>To Do</h3> </div>
  <div style="overflow-x: auto;" class="container-table"> 
    <table>
        <tr>
          <th>Device Name</th>
          <th>Serial Number</th>
          <th>User</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) :
        // Logika pengecekan status
        $komponen = ['monitor', 'ram', 'hardisk', 'power', 'dvd', 'keyboard', 'mouse', 'clean_device'];
        $status = 'Normal';

        foreach ($komponen as $key) {
            if (isset($row[$key])) {
                $value = strtolower(trim($row[$key]));
                if ($value !== 'normal' && $value !== '') {
                    $status = 'Error';
                    break;
                }
            }
        }
        // Tampilkan hanya jika status = Error
        if ($status === 'Error') :
        ?>
        <tr>
          <td style="text-align: center;"><?= $row['device_merk'] ?></td>
          <td style="text-align: center;"><?= $row['serial_number'] ?></td>
          <td style="text-align: center;"><?= $row['asset_user'] ?></td>
          <td style="text-align: center;">
            <p style="color: red; font-weight: bold;">
              <?= ucfirst($status) ?>
            </p>
          </td>
          <td style="text-align: center;"><button class="mark-normal" data-id="<?= $row['id']; ?>">✔️</button></td>
        </tr>
    <?php endif; endwhile; ?>
    </table>
  </div>
</div>

<!-- ============ JavaScript buat Sidebar Toggle ============ -->
<script>
  document.getElementById("toggleSidebar").onclick = function () {
    document.getElementById("sidebar").classList.toggle("hide");
    document.getElementById("main").classList.toggle("expand");
  };
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".mark-normal").forEach(button => {
    button.addEventListener("click", function () {
      const row = this.closest("tr");
      const id = this.getAttribute("data-id");

      fetch("super_statustodo.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`
      })
      .then(res => res.text())
      .then(response => {
        if (response.trim() === "OK") {
          row.remove(); // Hapus baris dari tabel
        } else {
          alert("Gagal update status.");
        }
      });
    });
  });
});
</script>

</body>
</html>