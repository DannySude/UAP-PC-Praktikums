<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>GLCM UI - Satu Frame</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">

    <!-- Upload + Proses -->
    <div class="result-area">

        <form method="post" action="proses.php" enctype="multipart/form-data">
            <div class="preview-area">
                <div class="img-box">
                    <p><b>Gambar Asli</b></p>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM klasifikasi ORDER BY waktu DESC LIMIT 1");
                    $d = mysqli_fetch_assoc($q);
                    ?>
                    <img src="uploads/<?= $d['gambar_asli'] ?>">
                </div>
                <div class="img-box">
                    <p><b>Gambar Edit</b></p>
                    <img src="uploads/<?= $d['gambar_edit'] ?>">
                </div>
                <div class="controls">
                    <label>Upload Gambar (JPG, PNG)</label>
                    <input type="file" name="gambar"><br>

                    <label>Rotasi</label>
                    <output id="rotasiVal">0</output>°
                    <input type="range" name="rotasi" min="0" max="360" value="0" oninput="rotasiVal.value = value">

                    <input type="number" name="lebar" placeholder="Lebar" required>
                    <input type="number" name="tinggi" placeholder="Tinggi" required>

                    <input type="hidden" name="gambar_lama" value="<?= $d['gambar_asli'] ?? '' ?>">
                    <button type="submit">PROSES</button>
                </div>
            </div>
        </form>

        <style>
            tab {
                display: inline-block;
                width: 40px;
            }
        </style>


        <div class="features">
            <div class ="baris">
            <p>Contrast : <?= $d['contrast'] ?? '-' ?></p>
            <p>Dissimilarity : <?= $d['dissimilarity'] ?? '-' ?></p>
            <p>Homogeneity : <?= $d['homogeneity'] ?? '-' ?></p>
            <p>Energy : <?= $d['energy'] ?? '-' ?></p>
            <p>Correlation : <?= $d['correlation'] ?? '-' ?></p>
            <p>ASM : <?= $d['asm'] ?? '-' ?></p>
            </div>

            <?php if (!empty($d['gambar_edit'])): ?>
                <a href="uploads/<?= $d['gambar_edit'] ?>" download>
                    <button class="download-btn">DOWNLOAD</button>
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>
</body>
</html>
