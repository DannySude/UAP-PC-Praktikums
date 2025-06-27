<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gambar'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validasi gambar
    $allowTypes = ['jpg', 'jpeg', 'png'];
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
            // Jalankan klasifikasi dengan Python
            $command = escapeshellcmd("python klasifikasi.py " . escapeshellarg($targetFilePath));
            $output = shell_exec($command);

            if ($output && strpos($output, '|') !== false) {
                list($hasil, $contrast, $dissimilarity, $homogeneity, $energy, $correlation, $asm, $mean_r, $mean_g, $mean_b) = explode("|", $output);

                // Simpan ke database
                $query = "INSERT INTO klasifikasi 
                (nama_file, hasil, contrast, dissimilarity, homogeneity, energy, correlation, asm, mean_r, mean_g, mean_b)
                VALUES 
                ('$fileName', '$hasil', '$contrast', '$dissimilarity', '$homogeneity', '$energy', '$correlation', '$asm', '$mean_r', '$mean_g', '$mean_b')";

                if (mysqli_query($conn, $query)) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Gagal menyimpan ke database: " . mysqli_error($conn);
                }
            } else {
                echo "Gagal menjalankan klasifikasi: $output";
            }
        } else {
            echo "Gagal mengupload gambar.";
        }
    } else {
        echo "Format file tidak didukung. Hanya JPG, JPEG, PNG.";
    }
} else {
    echo "Tidak ada data terkirim.";
}
?>
