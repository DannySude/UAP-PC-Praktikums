<?php
include 'koneksi.php';

$upload_dir = "uploads/";
$nama_file = "";
$is_new_upload = isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0;

// Jika upload baru
if ($is_new_upload) {
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp_file, $upload_dir . $nama_file);
} else if (isset($_POST['gambar_lama']) && $_POST['gambar_lama'] != '') {
    // Pakai gambar lama
    $nama_file = $_POST['gambar_lama'];
} else {
    die("Gambar tidak tersedia.");
}

// Ambil parameter transformasi
$rotasi = isset($_POST['rotasi']) ? (float)$_POST['rotasi'] : 0;
$lebar  = isset($_POST['lebar']) ? (int)$_POST['lebar'] : 0;
$tinggi = isset($_POST['tinggi']) ? (int)$_POST['tinggi'] : 0;

// Validasi ukuran
if ($lebar <= 0 || $tinggi <= 0) {
    die("Ukuran lebar dan tinggi tidak valid.");
}

// Nama file edit
$nama_edit = "edit_" . uniqid() . "_" . $nama_file;
$path_asli = $upload_dir . $nama_file;
$path_edit = $upload_dir . $nama_edit;

// Jalankan Python
$command = escapeshellcmd("python glcm.py $path_asli $rotasi $lebar $tinggi $path_edit");
$output = shell_exec($command);

// Ambil hasil
if ($output && strpos($output, '|') !== false) {
    list($contrast, $dissimilarity, $homogeneity, $energy, $correlation, $asm) = explode('|', trim($output));

    // Simpan ke database
    $query = "INSERT INTO klasifikasi (gambar_asli, gambar_edit, contrast, dissimilarity, homogeneity, energy, correlation, asm)
              VALUES ('$nama_file', '$nama_edit', '$contrast', '$dissimilarity', '$homogeneity', '$energy', '$correlation', '$asm')";
    mysqli_query($koneksi, $query);
}

header("Location: index.php");
?>
