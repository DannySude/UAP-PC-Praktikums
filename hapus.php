<?php
include 'koneksi.php';

if (isset($_POST['id']) && isset($_POST['nama_file'])) {
    $id = $_POST['id'];
    $nama_file = $_POST['nama_file'];

    // Hapus gambar dari folder
    if (file_exists("uploads/$nama_file")) {
        unlink("uploads/$nama_file");
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM klasifikasi WHERE id='$id'");

    header("Location: index.php");
}
?>
