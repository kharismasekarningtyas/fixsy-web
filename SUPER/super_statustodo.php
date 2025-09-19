<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $update = mysqli_query($koneksi, "UPDATE input2 SET 
        monitor='Normal',
        ram='Normal',
        hardisk='Normal',
        power='Normal',
        dvd='Normal',
        keyboard='Normal',
        mouse='Normal',
        clean_device='Normal'
        WHERE id = $id");

    echo $update ? "OK" : "ERROR";
}
?>
