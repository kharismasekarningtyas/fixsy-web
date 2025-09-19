<?php
session_start();
include 'koneksi.php';

// Ambil semua data dari session
$data1 = $_SESSION['input'] ?? [];
$data2 = $_SESSION['input2'] ?? [];
$data3 = $_SESSION['input3'] ?? [];

if (isset($_SESSION['uploaded_file'])) {
  $data3['uploaded_file'] = $_SESSION['uploaded_file'];
}

if (empty($_SESSION['input']) || empty($_SESSION['input2']) || empty($_SESSION['input3'])) {
  die("Data belum lengkap. Silakan lengkapi form terlebih dahulu.");
}

// --- CEK DUPLIKAT SERIAL NUMBER DAN PINDAHKAN DATA LAMA KE HISTORY ---
$serial = $data1['serial_number'];
$imagePath = '';
$getOld = mysqli_query($koneksi, "SELECT * FROM input WHERE serial_number = '$serial'");

if (mysqli_num_rows($getOld) > 0) {
    $row = mysqli_fetch_assoc($getOld);
    $imagePath = ($row['uploaded_file'] ?? '');
    $oldAssetId = $row['id'];

    // Ambil data file dari input3 berdasarkan asset_id
    $oldFile = mysqli_query($koneksi, "SELECT * FROM input3 WHERE id = '$oldAssetId'");
    $rowFile = mysqli_fetch_assoc($oldFile);
    $imagePath = $rowFile['uploaded_file'] ?? '';

    // 1. Pindahkan file fisik jika ada
    if (!empty($imagePath) && file_exists($imagePath)) {
        $fileName = basename($imagePath);
        $newPath = '../history/' . $fileName;
        rename($imagePath, $newPath);
    } else {
        $newPath = $imagePath;
    }

    // 2. Simpan data lama ke tabel histories
    mysqli_query($koneksi, "INSERT INTO histories (serial_number, device_merk, uploaded_file)
                            VALUES ('$serial', '{$row['device_merk']}', '$newPath')");

    // 3. Hapus data dari anak dulu baru parent
    mysqli_query($koneksi, "DELETE FROM input2 WHERE asset_id = '$oldAssetId'");
    mysqli_query($koneksi, "DELETE FROM input3 WHERE asset_id = '$oldAssetId'");
    mysqli_query($koneksi, "DELETE FROM input WHERE id = '$oldAssetId'");
}

// 1. Simpan ke tabel input
$stmt1 = $koneksi->prepare("INSERT INTO input (departement, asset_tag, asset_name, category, supplier, location, status, asset_user, asset_admin, manufacturer, model, maintenance_date, device_merk, serial_number, ip_address, mac_address, bios_version) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt1->bind_param("sssssssssssssssss",
    $data1['departement'],
    $data1['asset_tag'],
    $data1['asset_name'],
    $data1['category'],
    $data1['supplier'],
    $data1['location'],
    $data1['status'],
    $data1['asset_user'],
    $data1['asset_admin'],
    $data1['manufacturer'],
    $data1['model'],
    $data1['maintenance_date'],
    $data1['device_merk'],
    $data1['serial_number'],
    $data1['ip_address'],
    $data1['mac_address'],
    $data1['bios_version']
);
$stmt1->execute();
$asset_id = $koneksi->insert_id; // untuk relasi ke tabel lainnya
$stmt1->close();

// 2. Simpan ke tabel input2
$stmt2 = $koneksi->prepare("INSERT INTO input2
(asset_id, monitor, monitor_info, ram, ram_info, hardisk, hardisk_info, power, power_info, dvd, dvd_info, keyboard, keyboard_info, mouse, mouse_info, clean_device, clean_info) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt2->bind_param("issssssssssssssss",
    $asset_id,
    $data2['monitor'],
    $data2['monitor_info'],
    $data2['ram'],
    $data2['ram_info'],
    $data2['hardisk'],
    $data2['hardisk_info'],
    $data2['power'],
    $data2['power_info'],
    $data2['dvd'],
    $data2['dvd_info'],
    $data2['keyboard'],
    $data2['keyboard_info'],
    $data2['mouse'],
    $data2['mouse_info'],
    $data2['clean_device'],
    $data2['clean_info']
);
$stmt2->execute();
$stmt2->close();

// 3. Simpan ke tabel input3
$stmt3 = $koneksi->prepare("INSERT INTO input3 
(asset_id, os, antivirus, office, sap, chrome, acrobat, vnc, vlc, fp, pv, add_1, add_2,uploaded_file)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt3->bind_param("isssiiiiiiisss",
    $asset_id,
    $data3['os'],
    $data3['antivirus'],
    $data3['office'],
    $data3['sap'],
    $data3['chrome'],
    $data3['acrobat'],
    $data3['vnc'],
    $data3['vlc'],
    $data3['fp'],
    $data3['pv'],
    $data3['add_1'],
    $data3['add_2'],
    $data3['uploaded_file']
);
$stmt3->execute();
$stmt3->close();

session_unset();
session_destroy();
header("Location: admin_sukses.php");
exit();
?>
