<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Klasifikasi Buah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <!-- Upload Gambar -->
    <div class="upload-box">
        <h3>Upload Gambar Buah Apel, Jeruk, Mangga</h3>
        <form action="proses.php" method="post" enctype="multipart/form-data">
            <label class="file-label">
                <span id="namaFile" style="color: #6495ED;">Belum ada file</span>
                <input type="file" name="gambar" id="gambarInput" hidden required onchange="tampilkanNamaFile()">
            </label>
            <button type="submit">Upload</button>
        </form>
    </div>

    <!-- Tabel Riwayat Klasifikasi -->
    <div class="riwayat-box">
        <h4 style="text-align: center;">KLASIFIKASI</h4>
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Hasil</th>
                    <th>Contrast</th>
                    <th>Dissimilarity</th>
                    <th>Homogeneity</th>
                    <th>Energy</th>
                    <th>Correlation</th>
                    <th>ASM</th>
                    <th>Mean R</th>
                    <th>Mean G</th>
                    <th>Mean B</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM klasifikasi ORDER BY id DESC");

                // Jika belum ada data
                if (mysqli_num_rows($sql) == 0) {
                    echo "<tr><td colspan='12'>Belum ada data klasifikasi.</td></tr>";
                } else {
                    // Tampilkan setiap baris data
                    while ($d = mysqli_fetch_array($sql)) {
                        echo "<tr>";
                        echo "<td><img src='uploads/{$d['nama_file']}' width='150'></td>";
                        echo "<td>{$d['hasil']}</td>";
                        echo "<td>{$d['contrast']}</td>";
                        echo "<td>{$d['dissimilarity']}</td>";
                        echo "<td>{$d['homogeneity']}</td>";
                        echo "<td>{$d['energy']}</td>";
                        echo "<td>{$d['correlation']}</td>";
                        echo "<td>{$d['asm']}</td>";
                        echo "<td>{$d['mean_r']}</td>";
                        echo "<td>{$d['mean_g']}</td>";
                        echo "<td>{$d['mean_b']}</td>";
                        
                        echo "<td>";

                        // Tombol Hapus
                        echo "<form method='post' action='hapus.php' style='display:inline-block' onsubmit=\"return confirm('Yakin hapus data ini?');\">";
                        echo "<input type='hidden' name='id' value='{$d['id']}'>";
                        echo "<input type='hidden' name='nama_file' value='{$d['nama_file']}'>";
                        echo "<button class='hapus-btn'>Hapus</button>";
                        echo "</form> ";

                        // Tombol Edit
                        echo "<form method='get' action='edit.php' style='display:inline-block'>";
                        echo "<input type='hidden' name='file' value='{$d['nama_file']}'>";
                        echo "<button class='hapus-btn' style='background-color: orange;'>Edit</button>";
                        echo "</form>";

                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Script JS untuk menampilkan nama file upload -->
<script>
function tampilkanNamaFile() {
    const input = document.getElementById('gambarInput');
    const namaFile = document.getElementById('namaFile');
    namaFile.textContent = input.files.length > 0 ? input.files[0].name : "Belum ada file";
}
</script>

</body>
</html>
