<?php
$filename = $_GET['file'] ?? '';
$filepath = "uploads/" . $filename;

if (!file_exists($filepath)) {
    die("File tidak ditemukan.");
}

$output_path = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rotasi = (int) $_POST['rotasi'];
    $lebar = (int) $_POST['lebar'];
    $tinggi = (int) $_POST['tinggi'];

    $output = shell_exec("python edit_gambar.py \"$filepath\" $rotasi $lebar $tinggi");
    $output_path = trim($output);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Gambar</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .back-btn {
            background-color: #6495ED;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .edit-form {
            margin-bottom: 20px;
        }
        .edit-form input {
            padding: 6px;
            width: 80px;
            margin: 5px;
        }
        .edit-form button {
            margin-top: 10px;
            background-color: #6495ED;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .gambar-wrapper {
            display: flex;
            gap: 40px;
            margin-bottom: 20px;
        }
        .gambar-wrapper div {
            text-align: center;
        }
        .gambar-wrapper img {
            max-width: 300px;
            max-height: 300px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .download-frame {
            padding: 0px;
            margin-top: 20px;
            max-width: 320px;
        }
        .download-frame button {
            background-color: #6495ED;
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .frame1{
           padding: 20px;
           background-color: #ffffff;
           max-width: 98%;
           margin: 30px;
           border-radius: 10px;
           box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

    </style>
</head>
<body>
<div class="frame1">
    <a href="index.php" class="back-btn">Back</a>

    <h3>Edit Gambar: <?= htmlspecialchars($filename) ?></h3>

    <form method="POST" class="edit-form">
        <label>Rotasi (°): <input type="number" name="rotasi" value="0"></label>
        <label>Lebar: <input type="number" name="lebar" value="128"></label>
        <label>Tinggi: <input type="number" name="tinggi" value="128"></label><br>
        <button type="submit">Edit Gambar</button>
    </form>

    <div class="gambar-wrapper">
        <div>
            <h4>Gambar Asli</h4>
            <img src="<?= $filepath ?>">
        </div>
        <?php if (!empty($output_path) && file_exists($output_path)): ?>
        <div>
            <h4>Gambar Hasil Edit</h4>
            <img src="<?= $output_path ?>">
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($output_path) && file_exists($output_path)): ?>
    <div class="download-frame">
        <a href="<?= $output_path ?>" download>
            <button>Download Gambar Edit</button>
        </a>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
