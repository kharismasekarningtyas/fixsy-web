<?php
session_start();
include 'koneksi.php';

// Ambil semua data dari session
$data = $_SESSION['input-hd'] ?? [];

if (isset($_SESSION['uploaded_file'])) {
  $data['uploaded_file'] = $_SESSION['uploaded_file'];
}

$stmt = $koneksi->prepare("INSERT INTO handover 
(device_name,  first, second, uploaded_file) 
VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss",
    $data['device_name'],
    $data['first'],
    $data['second'],
    $data['uploaded_file'],
);
$stmt->execute();
$stmt->close();

session_unset();
session_destroy();
header("Location: super_sukses-hd.php");
exit();
?>
