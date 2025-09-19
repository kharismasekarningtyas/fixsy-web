<?php
include 'koneksi.php';

$id = $_GET['id'];

// Ambil file yang akan dihapus
$get = mysqli_query($koneksi, "SELECT uploaded_file FROM handover WHERE id='$id'");
$data = mysqli_fetch_assoc($get);
$file = $data['uploaded_file'];

if (file_exists("uploads-hd/$file")) {
    unlink("uploads-hd/$file"); // hapus file dari folder
}

$delete = mysqli_query($koneksi, "DELETE FROM handover WHERE id='$id'");

if ($delete) {
    header("Location: admin_handover.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}
?>
